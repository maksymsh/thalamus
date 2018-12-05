<?php

namespace WWSC\ThalamusBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWSC\ThalamusBundle\Service\DebugFileLogTrait;
use WWSC\ThalamusBundle\Service\MailService;

/**
 * User controler.
 *
 * In this controller describes the functions of adding, editing(contact information and personal information about user),
 * deleting and activation user.
 */
class UserController extends Controller
{
    use DebugFileLogTrait;

    /**
     *   Method add.
     *
     *   This method is responsible for create new user for company
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fUser = $this->createForm(new \WWSC\ThalamusBundle\Form\UserForm());
        if ($oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'))) {
            if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && $this->getUser()->getCompany()->getId() != $request->get('company')
                || !$oCompany->getAccount()->getChekUserForAccount($this->getUser(), true)
            ) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $fUser->add('profile', new \WWSC\ThalamusBundle\Form\UserProfileForm());
            if ('POST' == $request->getMethod()) {
                $fUser->handleRequest($request);
                if ($fUser->isValid()) {
                    $fUser = $fUser->getData();
                    $userManager = $this->container->get('fos_user.user_manager');

                    /* create new user */
                    $fUser->setUsername(trim($fUser->getEmail()));
                    $fUser->setPlainPassword(base64_encode(microtime()));
                    $fUser->setLastLoggedAccount($request->getSession()->get('account')->id);
                    $fUser->setEnabled(false);
                    $fUser->setConfirmationToken($this->get('fos_user.util.token_generator')->generateToken());
                    $em->persist($fUser);

                    $fUser->getProfile()->setUser($fUser);
                    $em->flush();

                    if ($request->get('role-user')) {
                        $fUser->addCompanyUser($oCompany, false, $request->get('role-user'));
                    } else {
                        $fUser->addCompanyUser($oCompany);
                    }

                    if ($fUser->getLanguageCode()) {
                        $langTemplate = $fUser->getLanguageCode();
                    } else {
                        $langTemplate = 'en';
                    }

                    // Subject
                    $subject = 'Create account Thalamus!';
                    if($langTemplate == 'de') {
                        $subject = 'Thalamus-Konto erstellen';
                    }
                    
                    $mailBody = $this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/create_user.txt.twig', array(
                        'company_name' => $oCompany->getName(),
                        'first_name' => $fUser->getFirstName(),
                        'created_user' => $this->getUser(),
                        'profile_description' => $fUser->getProfile()->getDescription(),
                        'url' => $this->generateUrl('wwsc_thalamus_user_activation', array(
                            'account' => $oCompany->getAccount()->getSlug(),
                            'token' => $fUser->getConfirmationToken(), ), true),
                    ));

                    /**
                     * @var MailService $mailService
                     */
                    $mailService = $this->get('app.mail.service');
                    $mailService->send($subject, $this->container->getParameter('admin_email'), $fUser->getEmail(), $mailBody);
                    
                    if ($request->request->get('project')) {
                        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->request->get('project')));
                        $oProject->addUser($fUser);
                        $em->flush();

                        return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
                    }
                    $request->getSession()->getFlashBag()->add('notice', 'Person has  been created sucessfully');
                    $request->getSession()->getFlashBag()->add('status', 'success');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
                }
            }
            $aData = array('form' => $fUser->createView(), 'oCompany' => $oCompany);
            if ('ROLE_PROVIDER' == $oCompany->getRoles() && $oCompany->getAccount()->getAccountOwner()->getId() == $this->getUser()->getId()) {
                $aData['aRoles'] = $em->getRepository('WWSCThalamusBundle:RoleUser')->findAll();
            }

            return $this->render('WWSCThalamusBundle:User:add.html.twig', $aData);
        }
    }

    public function addExistentUserToCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oCompany = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $oUser = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:User')->find($request->get('user'));
        $oUser->addCompanyUser($oCompany);
        if ($oUser->getLanguageCode()) {
            $langTemplate = $oUser->getLanguageCode();
        } else {
            $langTemplate = 'en';
        }
        
        $mailBody = $this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/add_user_to_account.txt.twig', array(
            'company_name' => $oCompany->getName(),
            'first_name' => $oUser->getFirstName(),
            'created_user' => $this->getUser(),
            'profile_description' => $oUser->getProfile()->getDescription(),
            'urlAcceptInvitation' => $this->generateUrl('wwsc_thalamus_user_acccept_invitation', array(
                'account' => $oCompany->getAccount()->getSlug(),
                'company' => $oCompany->getId(),
                'salt' => $oUser->getSalt(), ), true),
            'urlRejectInvitation' => $this->generateUrl('wwsc_thalamus_user_reject_invitation', array(
                'account' => $oCompany->getAccount()->getSlug(),
                'company' => $oCompany->getId(),
                'salt' => $oUser->getSalt(), ), true),
        ));

        /**
         * @var MailService $mailService
         */
        $mailService = $this->get('app.mail.service');
        $mailService->send(
            'Add to account '.$oCompany->getAccount()->getName().' Thalamus!', 
            $this->container->getParameter('admin_email'), 
            $oUser->getEmail(), 
            $mailBody
        );
        
        if ($request->request->get('project')) {
            $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->request->get('project')));
            $oProject->addUser($oUser);
            $em->flush();

            return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
        }
        $request->getSession()->getFlashBag()->add('notice', 'Person has  been created sucessfully');
        $request->getSession()->getFlashBag()->add('status', 'success');

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
    }

    public function userAccceptInvitationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $oUser = $em->getRepository('WWSCThalamusBundle:User')->findOneBy(array('salt' => $request->get('salt')));

        $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
        $this->container->get('security.context')->setToken($token);

        $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $oCompany, 'user' => $oUser));
        if ($oCompanyUser) {
            $oCompanyUser->setEnabled(1);
            $em->flush();

            return $this->redirect($this->generateUrl('wwsc_thalamus_account_change', array('account' => $oCompany->getAccount()->getId())));
        }
    }

    public function userRejectInvitationAction(Request $request)
    {
        $oCompany = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $oUser = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:User')->findOneBy(array('salt' => $request->get('salt')));
        $oUser->removeCompanyUser($oCompany);
        $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
        $this->container->get('security.context')->setToken($token);

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_change', array('account' => $oUser->getLastLoggedAccount())));
    }

    public function checkUserExistAction(Request $request)
    {
        $oCompany = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $userManager = $this->container->get('fos_user.user_manager');
        $oExistentUser = $userManager->findUserByEmail(trim($request->get('email')));
        if ($oExistentUser) {
            if (!$oCompany->getAccount()->getChekUserForAccount($oExistentUser)) {
                $oUser = array(
                    'firstName' => $request->get('firstName'),
                    'lastName' => $request->get('lastName'),
                    'company' => $oCompany->getId(),
                    'project' => $request->get('project'),
                );
                $oExistentUser = array(
                    'id' => $oExistentUser->getId(),
                    'firstName' => $oExistentUser->getFirstName(),
                    'lastName' => $oExistentUser->getLastName(),
                    'email' => $oExistentUser->getEmail(),
                );

                return new \Symfony\Component\HttpFoundation\JsonResponse(array(
                    'status' => false,
                    'htmlpopup' => $this->renderView('WWSCThalamusBundle:User:popup_add_existing_user.html.twig', array(
                        'oExistentUser' => $oExistentUser,
                        'oUser' => $oUser,
                    )), ));
            }
        }

        return new \Symfony\Component\HttpFoundation\JsonResponse(array('status' => true));
    }

    /**
     *   Method edit.
     *
     *   This method is responsible for edit and update contact information about user
     */
    public function editAction(Request $request)
    {
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id);
        $userManager = $this->container->get('fos_user.user_manager');
        $oUser = $userManager->findUserBy(array('id' => $request->get('id')));
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && $this->getUser()->getCompany()->getId() != $oUser->getCompany()->getId() || !$oAccount->getChekUserForAccount($oUser, false)) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == $this->getUser()->getId()) {
            $fUser = $this->createForm(new \WWSC\ThalamusBundle\Form\UserMyContactForm(), $oUser);
            $template = 'my_contact_edit.html.twig';
        } else {
            $fUser = $this->createForm(new \WWSC\ThalamusBundle\Form\UserContactForm($oUser->getCompany()->getAccount()->getCompany()), $oUser);
            $template = 'contact_edit.html.twig';
        }
        $changeUserRole = false;
        if ('ROLE_PROVIDER' == $oUser->getCompany()->getRoles() && $this->getUser()->getCompany()->getAccount()->getAccountOwner()->getId() == $this->getUser()->getId()) {
            $changeUserRole = true;
        }
        if (isset($fUser)) {
            if ('POST' == $request->getMethod()) {
                $fUser->bind($request);
                if ($fUser->isValid()) {
                    $fUser = $fUser->getData();
                    if ($request->get('project-for-screenshot-tool') != $oUser->getProjectForScreenshotTool()) {
                        $fUser->setProjectForScreenshotTool($request->get('project-for-screenshot-tool'));
                    }
                    $em->persist($fUser);
                    $em->flush();
                    if ($changeUserRole) {
                        $fUser->updateRole($request->get('role-user'));
                    }
                    $request->getSession()->getFlashBag()->add('notice', 'Person has been updated successfully');
                    $request->getSession()->getFlashBag()->add('status', 'success');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_user_edit', array('id' => $request->get('id'))));
                }
            }

            $aData = array('form' => $fUser->createView(), 'oUser' => $oUser);
            if ($changeUserRole) {
                $aData['aRoles'] = $em->getRepository('WWSCThalamusBundle:RoleUser')->findAll();
            }

            return $this->render('WWSCThalamusBundle:User:'.$template, $aData);
        }
    }

    /**
     *   Method myInfo.
     *
     *   This method is responsible for edit and update personal information about user
     */
    public function myInfoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fUser = $this->createForm(new \WWSC\ThalamusBundle\Form\UserForm(), $this->getUser());

        $changeUserRole = false;
        if ('ROLE_PROVIDER' == $this->getUser()->getCompany()->getRoles() && $this->getUser()->getCompany()->getAccount()->getAccountOwner()->getId() == $this->getUser()->getId()) {
            $changeUserRole = true;
        }
        if ('POST' == $request->getMethod()) {
            $fUser->bind($request);
            if ($fUser->isValid()) {
                $em->flush();
                if ($request->get('project-for-screenshot-tool') != $this->getUser()->getProjectForScreenshotTool()) {
                    $this->getUser()->setProjectForScreenshotTool($request->get('project-for-screenshot-tool'));
                }
                $language = $this->getUser()->getLanguage();
                if ('de' == $language || 'de_AT' == $language) {
                    $request->getSession()->set('_localeThalamus', 'de');
                } else {
                    $request->getSession()->set('_localeThalamus', 'en');
                }
                if ($changeUserRole) {
                    $this->getUser()->updateRole($request->get('role-user'));
                }
                $request->getSession()->getFlashBag()->add('notice', 'Person has been updated sucessfully');
                $request->getSession()->getFlashBag()->add('status', 'success');

                return $this->redirect($this->generateUrl('wwsc_thalamus_user_myinfo'));
            }
        }
        $aData = array('form' => $fUser->createView());
        if ($changeUserRole) {
            $aData['aRoles'] = $em->getRepository('WWSCThalamusBundle:RoleUser')->findAll();
        }

        return $this->render('WWSCThalamusBundle:User:my_info.html.twig', $aData);
    }

    /**
     *   Method activationUser.
     *
     *   This method is responsible for activation user.
     */
    public function activationUserAction(Request $request, $account, $token)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        if (!$oAccount = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Account')->findOneBy(array('slug' => $account))) {
            $request->getSession()->getFlashBag()->add('notice', 'Incorrect account name');
            $request->getSession()->getFlashBag()->add('status', 'error');

            return $this->render('WWSCThalamusBundle:User:activation_user.html.twig', compact('account', 'token'));
        }
        if (!$oUser = $userManager->findUserByConfirmationToken($token)) {
            $request->getSession()->getFlashBag()->add('notice', 'Incorrect user code ');
            $request->getSession()->getFlashBag()->add('status', 'error');

            return $this->render('WWSCThalamusBundle:User:activation_user.html.twig', compact('account', 'token'));
        }
        if ($oUser->getLanguage()) {
            $request->getSession()->set('_localeThalamus', $oUser->getLanguageCode());
        } else {
            $request->getSession()->set('_localeThalamus', 'de');
        }
        $request->setLocale($request->getSession()->get('_localeThalamus'));
        $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
        $fUser = $this->createForm(new \WWSC\ThalamusBundle\Form\ActivationUserForm(), $oUser);

        if ('POST' == $request->getMethod()) {
            $fUser->bind($request);
            if ($fUser->isValid()) {
                $oUser = $fUser->getData();
                $oUser->setEnabled(true);
                $oUser->setConfirmationToken(null);
                $oUser->setRoles(array($oUser->getCompany()->getRoles()));

                $userManager->updateUser($oUser);

                $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $oUser->getCompany(), 'user' => $oUser));
                if ($oCompanyUser) {
                    $oCompanyUser->setEnabled(1);
                    $em->flush();
                }

                $this->get('fos_user.security.login_manager')->logInUser('main', $oUser);
                return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
            }
        }

        return $this->render('WWSCThalamusBundle:User:activation_user.html.twig', array(
            'form' => $fUser->createView(),
            'oAccount' => $oAccount,
            'oUser' => $oUser,
            'token' => $token,
        ));
    }

    /**
     *   Method delete.
     *
     *   This method is responsible for delete user.
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id);
        $user = $this->getDoctrine()->getRepository('WWSCThalamusBundle:User')->find($request->get('id'));

        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && $this->getUser()->getCompany()->getId() != $user->getCompany()->getId() || !$oAccount->getChekUserForAccount($user, false)) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($user->getCompany()->getProjects()) {
            foreach ($user->getCompany()->getProjects() as $oProject) {
                $oProject->removeUser($user);
            }
        }
        $user->removeCompanyUser($user->getCompany());
        $em->flush();
        if ($user->hasAccount()) {
            $user->setLastLoggedAccount($user->hasAccount());
        } else {
            $user->setIsDeleted(1);
            $user->setEnabled(0);
            $user->setLocked(1);
            $user->setEmail($user->getId().'-'.$user->getEmail());
            $user->setLastLoggedAccount(0);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Person has been updated sucessfully');
        $request->getSession()->getFlashBag()->add('status', 'success');

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
    }

    /**
     *   Method resend Email.
     *
     *   This method is responsible for re-sending emails to user.
     */
    public function resendEmailAction(Request $request)
    {
        $oUser = $this->getDoctrine()->getRepository('WWSCThalamusBundle:User')->find($request->get('id'));
        if ($oUser->getLanguageCode()) {
            $langTemplate = $oUser->getLanguageCode();
        } else {
            $langTemplate = 'en';
        }
        
        // Subject
        $subject = 'Create account Thalamus!';
        if($langTemplate == 'de') {
            $subject = 'Thalamus-Konto erstellen';
        }

        $mailBody = $this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/create_user.txt.twig', array(
            'company_name' => $oUser->getCompany()->getName(),
            'first_name' => $oUser->getFirstName(),
            'created_user' => $oUser,
            'profile_description' => $oUser->getProfile()->getDescription(),
            'url' => $this->generateUrl('wwsc_thalamus_user_activation', array(
                'account' => $oUser->getCompany()->getAccount()->getSlug(),
                'token' => $oUser->getSalt(), ), true),
        ));

        /**
         * @var MailService $mailService
         */
        $mailService = $this->get('app.mail.service');
        $mailService->send($subject, $this->container->getParameter('admin_email'), $oUser->getEmail(), $mailBody);

        return $this->redirect($this->generateUrl('wwsc_thalamus_user_edit', array('id' => $request->get('id'))));
    }

    /**
     *   Method resend Email.
     *
     *   This method is responsible for re-sending emails to user.
     */
    public function resendEmailExistUserAction(Request $request)
    {
        $oCompany = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $oUser = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:User')->find($request->get('user'));
        if ($oUser->getLanguageCode()) {
            $langTemplate = $oUser->getLanguageCode();
        } else {
            $langTemplate = 'en';
        }
        
        $mailBody = $this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/add_user_to_account.txt.twig', array(
            'company_name' => $oCompany->getName(),
            'first_name' => $oUser->getFirstName(),
            'created_user' => $this->getUser(),
            'profile_description' => $oUser->getProfile()->getDescription(),
            'urlAcceptInvitation' => $this->generateUrl('wwsc_thalamus_user_acccept_invitation', array(
                'account' => $oCompany->getAccount()->getSlug(),
                'company' => $oCompany->getId(),
                'salt' => $oUser->getSalt(), ), true),
            'urlRejectInvitation' => $this->generateUrl('wwsc_thalamus_user_reject_invitation', array(
                'account' => $oCompany->getAccount()->getSlug(),
                'company' => $oCompany->getId(),
                'salt' => $oUser->getSalt(), ), true),
        ));

        /**
         * @var MailService $mailService
         */
        $mailService = $this->get('app.mail.service');
        $mailService->send(
            'Add to account '.$oCompany->getAccount()->getName().' Thalamus!', 
            $this->container->getParameter('admin_email'), 
            $oUser->getEmail(), 
            $mailBody
        );

        return $this->redirect($this->generateUrl('wwsc_thalamus_user_edit', array('id' => $request->get('user'))));
    }

    public function timeTrackTodayAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        return new JsonResponse(array('timeTrackToday' => \WWSC\ThalamusBundle\Entity\TimeTracker::getTimeTrackToday('user', $this->getUser()->getId())));
    }

    /**
     * Clear OAuth token data
     */
    public function userClearOauthTokenDataAction(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->get('security.context')->getToken()->getUser();
        
        // Clear data
        if($user instanceof User) {

            /**
             * @var EntityManagerInterface $em
             */
            $em = $this->getDoctrine()->getManager();
            
            $user->setGoogleDriveToken(null);
            $user->setGoogleDriveTokenExpire(null);
            $user->setGoogleDriveTokenRefresh(null);
            
            $em->persist($user);
            $em->flush();
    
            // Create response
            $response = [
                'status'    => 'success',
                'message'   => 'token_data_cleared',
                'desc'      => 'You have to reset your Google app permissions!
                
Now Google permissions page will be opened.
You have to remove permissions from Thalamus.

After that you will grant permissions again during Google Drive authorization.'
            ];
            
        } else {

            // Create response
            $response = [
                'status'    => 'error',
                'message'   => 'could_not_save_user_data'
            ];
            
        }
        
        return new JsonResponse($response);
        
    }

    /**
     * Get OAuth auth code
     */
    public function userGetOauthCodeAction(Request $request)
    {
        return $this->render('WWSCThalamusBundle:Oauth:get_code.html.twig');
    }

    /**
     * Get Google Drive token
     */
    public function userGetOauthTokenAction(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->get('security.context')->getToken()->getUser();

        if($user->getGoogleDriveToken() === null) {

            // User have no tokens in profile
            $response = [
                'status'    => 'error',
                'message'   => 'access_token_not_found'
            ];

        } else {

            // Check token for expiring
            $today      = strtotime(date('Y-m-d H:i:s'));
            $expire     = strtotime($user->getGoogleDriveTokenExpire());
            $interval   = $expire - $today;

            if($interval > 0) {

                // Access token is still valid
                $response = [
                    'status'    => 'success',
                    'message'   => 'access_token_valid',
                    'access'    => $user->getGoogleDriveToken()
                ];

            } else {

                // Check for refresh token
                if($user->getGoogleDriveTokenRefresh() !== null) {
                    
                    // Access token is not valid, need to refresh
                    $response = [
                        'status'    => 'error',
                        'message'   => 'access_token_invalid',
                        'refresh'   => $user->getGoogleDriveTokenRefresh()
                    ];
                    
                } else {

                    // Access token is not valid, need to refresh
                    $response = [
                        'status'    => 'error',
                        'message'   => 'refresh_token_not_found'
                    ];
                    
                }

            }
            
        }

        return new JsonResponse($response);
    }

    /**
     * User save Google Drive tokens
     */
    public function userSaveOauthTokensAction(Request $request)
    {
        $response = [
            'status'    => 'error',
            'message'   => 'Error during saving tokens to profile'
        ];
        /**
         * @var Request $request
         */
        $request = $request->request;

        /**
         * @var User $user
         */
        $user = $this->get('security.context')->getToken()->getUser();

        if($user instanceof User) {
            
            $em = $this->getDoctrine()->getManager();

            // Set access token expiration date and time
            $now    = date('Y-m-d H:i:s');
            $expire = date('Y-m-d H:i:s', strtotime('+'.$request->get('access_token_expire').' seconds', strtotime($now)));

            // Save data
            $user->setGoogleDriveToken($request->get('access_token'));
            $user->setGoogleDriveTokenExpire($expire);
            $user->setGoogleDriveTokenRefresh($request->get('refresh_token'));

            $em->persist($user);
            $em->flush();
            
            $response = [
                'status'    => 'tokens_saved',
                'message'   => 'Authentication passed! Now you can upload files from Google Drive!'
            ];
            
        }

        return new JsonResponse($response);
    }
    
    public function userGetOauthUpdateAccessTokenAction(Request $request)
    {
        $response = [
            'status'    => 'error',
            'message'   => 'Error during saving new access token to profile'
        ];
        /**
         * @var Request $request
         */
        $request = $request->request;

        /**
         * @var User $user
         */
        $user = $this->get('security.context')->getToken()->getUser();

        if($user instanceof User) {
            $em = $this->getDoctrine()->getManager();

            // Set access token expiration date and time
            $now    = date('Y-m-d H:i:s');
            $expire = date('Y-m-d H:i:s', strtotime('+'.$request->get('access_token_expire').' seconds', strtotime($now)));

            // Save data
            $user->setGoogleDriveToken($request->get('access_token'));
            $user->setGoogleDriveTokenExpire($expire);

            $em->persist($user);
            $em->flush();

            $response = [
                'status'    => 'token_updated',
                'message'   => 'User token was successfully updated!',
                'access'    => $request->get('access_token')
            ];
        }

        return new JsonResponse($response);
    }

}
