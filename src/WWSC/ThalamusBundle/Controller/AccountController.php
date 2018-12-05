<?php

/**
 *  Account controller.
 */

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Proxies\__CG__\WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\WWSCThalamusBundle;

/**
 * Account controler.
 *
 * In this controller describes the functions of registration new account and display pages dashboard, To-Dos, Calendar, Settings, Templates for account.
 */
class AccountController extends Controller
{
    /**
     *  Method list.
     *
     *  This method is responsible for display companies and persons on  the page "All People"
     */
    public function allPeopleAction(Request $request)
    {
        $this->getRequest()->getSession()->set('active_module', 'all-people');
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id);

        return $this->render('WWSCThalamusBundle:Account:all-people.html.twig', array('aCompanies' => $oAccount->getCompany(), 'accountOwnerId' => $oAccount->getAccountOwner()->getId()));
    }

    /**
     *  Method change account.
     *
     *  This method is responsible for changing the user account
     */
    public function changeAccountAction(Request $request)
    {
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->get('account'));
        $request->getSession()->set('aFilterTask', false);
        $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
        $userManager = $this->container->get('fos_user.user_manager');
        $this->getUser()->setRoles(array($this->getUser()->getCompany()->getRoles()));
        $this->getUser()->setLastLoggedAccount($oAccount->getId());
        $userManager->updateUser($this->getUser());
        $token = new UsernamePasswordToken($this->getUser(), null, 'main', $this->getUser()->getRoles());
        $this->container->get('security.context')->setToken($token);

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
    }

    /**
     *  Method  create a new account.
     *
     *  This method is responsible for creating a new account and company ( logged user ).
     */
    public function newAccountAction(Request $request)
    {
        $fAccount = $this->createForm(new \WWSC\ThalamusBundle\Form\AccountForm());
        if ('POST' == $request->getMethod()) {
            $fAccount->bind($request);
            if ($fAccount->isValid()) {
                $fAccount = $fAccount->getData();
                /* create new Account */
                $em = $this->getDoctrine()->getManager();
                $newAccount = new \WWSC\ThalamusBundle\Entity\Account();
                $newAccount->setName($fAccount['name']);
                $em->persist($newAccount);

                /* create new Company */
                $newCompany = new \WWSC\ThalamusBundle\Entity\Company();
                $newCompany->setName($fAccount['name']);
                $newCompany->setAbbreviation($fAccount['abbreviation']);
                $newCompany->setAccount($newAccount);
                $newCompany->setRoles('ROLE_PROVIDER');
                $newCompany->setPrimaryCompany(1);
                $newCompany->setTimeZone($fAccount['timeZone']);
                $em->persist($newCompany);
                $em->flush();
                $this->getUser()->addCompanyUser($newCompany, 1, 'ROLE_ACCOUNTING');

                if ($this->getUser()->getLanguageCode()) {
                    $langTemplate = $this->getUser()->getLanguageCode();
                } else {
                    $langTemplate = 'en';
                }
                /* after save data user,  send confirm letter on mail user */
                $message = \Swift_Message::newInstance()
                    ->setSubject('Create account Thalamus!')
                    ->setFrom($this->container->getParameter('admin_email'))
                    ->setContentType('text/html')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody($this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/registr_email.txt.twig', array(
                        'username' => $this->getUser()->getUsername(),
                        'first_name' => $this->getUser()->getFirstName(),
                        'url' => $request->getScheme().'://'.$request->getHttpHost(),
                    )));

                if (!$this->get('mailer')->send($message)) {
                    $em = $this->getDoctrine()->getManager();
                    $oAccount = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Account')->find($newAccount);
                    $em->remove($oAccount);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('notice', 'Account has not been  created please try again');
                    $request->getSession()->getFlashBag()->add('status', 'error');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_account_new'));
                }

                $request->getSession()->set('account', (object) array('slug' => $newAccount->getSlug(), 'name' => $newAccount->getName(), 'id' => $newAccount->getId()));
                $userManager = $this->container->get('fos_user.user_manager');
                $this->getUser()->setRoles(array($this->getUser()->getCompany()->getRoles()));
                $this->getUser()->setLastLoggedAccount($newAccount->getId());
                $userManager->updateUser($this->getUser());

                $token = new UsernamePasswordToken($this->getUser(), null, 'main', $this->getUser()->getRoles());
                $this->container->get('security.context')->setToken($token);

                return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
            }
        }

        return $this->render('WWSCThalamusBundle:Account:new-account.html.twig', array('form' => $fAccount->createView()));
    }

    /**
     *  Method dashboard.
     *
     *  This method is responsible for display  "account dashboard" page
     */
    public function dashboardAction(Request $request)
    {
        $request->getSession()->set('active_module', 'dashboard');
        if ($this->getUser() && $request->getSession()->get('account')) {
            if ($oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id)) {
                return $this->render('WWSCThalamusBundle:Account:dashboard.html.twig', array('oAccount' => $oAccount));
            }
        } else {
            return $this->redirect('http://blog.thalamus.io');
        }
    }

    /**
     *  Method dashboard.
     *
     *  This method is responsible for display  "order project list" page
     */
    public function orderProjectListAction(Request $request)
    {
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id);
        $aProjects = $oAccount->getProjects($request->get('order'), false, false, 'open', true);
        if ('projectLead' == $request->get('order')) {
            $userManager = $this->container->get('fos_user.user_manager');
            $this->getUser()->setSortingProjectsList(1);
            $userManager->updateUser($this->getUser());

            return new JsonResponse(array('dashboardMenuProject' => $this->renderView('WWSCThalamusBundle:Account:dashboard-menu-project-projectLead.html.twig', array('aProjects' => $aProjects))));
        } else {
            $userManager = $this->container->get('fos_user.user_manager');
            $this->getUser()->setSortingProjectsList(0);
            $userManager->updateUser($this->getUser());

            return new JsonResponse(array('dashboardMenuProject' => $this->renderView('WWSCThalamusBundle:Account:dashboard-menu-project-alphabet.html.twig', array('aProjects' => $aProjects))));
        }
    }

    /**
     *  Method header.
     *
     *  This method is responsible for display  header for template account.
     */
    public function headerAction(Request $request)
    {
        return $this->render('WWSCThalamusBundle:Account:header.html.twig', array('route' => $request->get('route'), 'route_params' => $request->get('route_params')));
    }

    /**
     * Method registration.
     *
     * This method is responsible for registration and save new account.
     *
     * @param  form registration[] data obtained by method post from the registrations form
     *
     * @return In the case of successful registration, message about successfully create new account. When an error occurs an error message
     */
    public function registrationAccountAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fRegistration = $this->createForm(new \WWSC\ThalamusBundle\Form\RegistrationForm());
        if ('POST' == $request->getMethod()) {
            $fRegistration->bind($request);
            if ($fRegistration->isValid()) {
                $fRegistration = $fRegistration->getData();

                /* create new User */
                $fRegistration->setEnabled(true);
                $fRegistration->setRoles(array('ROLE_PROVIDER'));
                $em->persist($fRegistration);

                $fRegistration->getProfile()->setUser($fRegistration);
                $em->persist($fRegistration);
                $em->flush();
                $token = new UsernamePasswordToken($fRegistration, null, 'main', $fRegistration->getRoles());
                $this->container->get('security.context')->setToken($token);

                /* create new Account */
                $newAccount = new \WWSC\ThalamusBundle\Entity\Account();
                $newAccount->setName($fRegistration->getAccount());
                $em->persist($newAccount);

                /* create new Company */
                $newCompany = new \WWSC\ThalamusBundle\Entity\Company();
                $newCompany->setName($fRegistration->getAccount());
                $newCompany->setAccount($newAccount);
                $newCompany->setRoles('ROLE_PROVIDER');
                $newCompany->setPrimaryCompany(1);
                $newCompany->setTimeZone($fRegistration->getTimezone());
                $em->persist($newCompany);
                $em->flush();

                $this->getUser()->addCompanyUser($newCompany, 1);
                /* after save data user,  send confirm letter on mail user */

                if ($this->getUser()->getLanguageCode()) {
                    $langTemplate = $this->getUser()->getLanguageCode();
                } else {
                    $langTemplate = 'en';
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject('Create account Thalamus!')
                    ->setFrom($this->container->getParameter('admin_email'))
                    ->setContentType('text/html')
                    ->setTo($fRegistration->getEmail())
                    ->setBody($this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/registr_email.txt.twig', array(
                        'username' => $fRegistration->getUsername(),
                        'first_name' => $fRegistration->getFirstName(),
                        'url' => $request->getScheme().'://'.$request->getHttpHost(),
                    )));

                if (!$this->get('mailer')->send($message)) {
                    $em = $this->getDoctrine()->getManager();
                    $oAccount = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Account')->find($newAccount->getId());
                    $em->remove($oAccount);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('notice', 'Account has not been  created please try again');
                    $request->getSession()->getFlashBag()->add('status', 'error');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_registration_account'));
                }

                $request->getSession()->set('account', (object) array('slug' => $newAccount->getSlug(), 'name' => $newAccount->getName(), 'id' => $newAccount->getId()));
                $userManager = $this->container->get('fos_user.user_manager');
                $this->getUser()->setRoles(array('ROLE_PROVIDER'));
                $this->getUser()->setLastLoggedAccount($newAccount->getId());
                $userManager->updateUser($this->getUser());

                return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
            }
        }

        return $this->render('WWSCThalamusBundle:Account:registration.html.twig', array('form' => $fRegistration->createView()));
    }

    public function listClosedProjectsAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'dashboard');
        if ($oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id)) {
            return $this->render('WWSCThalamusBundle:Account:list-closed-projects.html.twig', array('oAccount' => $oAccount));
        }
    }

    public function presentationModeAction(Request $request)
    {
        if ($request->getSession()->get('presentationMode')) {
            $request->getSession()->set('presentationMode', false);
        } else {
            $request->getSession()->set('presentationMode', true);
        }
        if ($request->headers->get('referer')) {
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
    }

    public function showTasksAction(Request $request)
    {
        if (!($this->container->get('security.context')->isGranted('ROLE_PROVIDER') || $this->container->get('security.context')->isGranted('ROLE_FREELANCER'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $request->getSession()->set('active_module', 'tasks');
        $fFilter = $this->createForm(new \WWSC\ThalamusBundle\Form\FilterTaskForm());
        $fFilter->bind($request);
        $aFilter = $fFilter->getData();
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->findOneBy(array('id' => $request->getSession()->get('account')->id));
        $aFilter['hide_empty_tasks'] = false;
        if ($request->get('filter_task_status') || '1' != $request->get('filter')) {
            $aFilter['filter_task_status'] = 1;
        }
        if (!$request->get('filter_time')) {
            $aFilter['filter_person'] = '';
        } else {
            $aFilter['filter_person'] = $request->get('filter_time')['filter_person'];
        }
        if ($request->get('hide_empty_tasks')) {
            $aFilter['hide_empty_tasks'] = true;
        }

        if ($request->get('filter_status')) {
            $aFilter['filter_status'] = $request->get('filter_status');
        } else {
            $aFilter['filter_status'] = '';
        }

        if ($request->get('filter_project_title')) {
            $aFilter['filter_project_title'] = $request->get('filter_project_title');
        } else {
            $aFilter['filter_project_title'] = '';
        }

        $aProjects = $oAccount->getProjectsForAccount();
        $aTasks = $oAccount->getTasksForAccount($aFilter);

        $data = array(
            'aTasks' => $aTasks,
            'fFilter' => $fFilter->createView(),
            'aProjects' => $aProjects,
            'aStates' => TaskItem::$states,
        );
        if ($this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            $data['aUsersForFilterTime'] = \WWSC\ThalamusBundle\Entity\TimeTracker::getUsersForFilterTime();
            $template = 'show-tasks.html.twig';
        } else {

            $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
            $oCompany = $oUser->getCompany();

            if($oCompany->getId() == 24) {
                $template = 'show-tasks-dev.html.twig';
            } else {
                $template = 'show-tasks-freelancer.html.twig';
            }

        }

        return $this->render("WWSCThalamusBundle:Account:{$template}", $data);
    }
}