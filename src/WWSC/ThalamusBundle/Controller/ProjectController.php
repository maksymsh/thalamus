<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Project;
use WWSC\ThalamusBundle\Form\ProjectForm;

/**
 * Project controler.
 *
 * In this controller describes the functions of adding, editing, deleting and display project,
 * and display pages Overview, Messages, To-Dos, Calendar, Writeboards, Files for project.
 */
class ProjectController extends Controller
{
    /**
     *  Method header.
     *
     *  This method describes header template project
     */
    public function headerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));

        return $this->render('WWSCThalamusBundle:Project:header.html.twig', array('oProject' => $oProject, 'route' => $request->get('route'), 'route_params' => $request->get('route_params')));
    }

    /**
     *  Method project people.
     *
     *  This method is responsible for display companies and persons which take part in the development project
     */
    public function projectpeopleAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'people_permissions');
        if ($oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            return $this->render('WWSCThalamusBundle:Project:project-people.html.twig', array('oProject' => $oProject, 'accountOwnerId' => $oProject->getAccount()->getAccountOwner()->getId()));
        }
    }

    /**
     *  Method add people project.
     *
     *  This method is responsible for add companies or persons which will take part in the  project
     */
    public function addpeopleProjectAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'people_permissions');
        $em = $this->getDoctrine()->getManager();
        if ($oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $fCompanyProject = $this->createForm(new \WWSC\ThalamusBundle\Form\CompanyProjectForm($oProject->getCompaniesNotInProject()));
            $fCompany = $this->createForm(new \WWSC\ThalamusBundle\Form\CompanyForm());
            if ('POST' == $request->getMethod()) {
                $fCompanyProject->bind($request);
                if ($fCompanyProject->isValid()) {
                    $fCompanyProject = $fCompanyProject->getData();
                    $oProject->addCompany($fCompanyProject['company']);
                    if ($fCompanyProject['access_to_all_people']) {
                        $this->statusProjectAllPeopleCompany($fCompanyProject['company'], $oProject, 'add');
                    }
                    $em->flush();

                    return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
                }
            }

            return $this->render('WWSCThalamusBundle:Project:add-project-people.html.twig', array('form' => $fCompanyProject->createView(), 'fCompany' => $fCompany->createView(), 'oProject' => $oProject));
        }
    }

    /**
     *  Method change status project all people company.
     *
     *  This method is responsible for  change status  to project all people company
     */
    public function statusProjectAllPeopleCompany($oCompany, $oProject, $action)
    {
        if ('remove' == $action) {
            foreach ($oCompany->getUsers() as $oUser) {
                if ((1 != $oCompany->getPrimaryCompany()) || (1 == $oCompany->getPrimaryCompany() && $oCompany->getuserCreated()->getId() != $oUser->getId())) {
                    $oProject->removeUser($oUser);
                }
            }
        }
        if ('add' == $action) {
            foreach ($oCompany->getUsers() as $oUser) {
                $oProject->addUser($oUser);
            }
        }
    }

    public function changeStatusAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        if ('closed' == $request->get('status')) {
            $oProject->setClosedProject(1);
        }
        if ('open' == $request->get('status')) {
            $oProject->setClosedProject(0);
        }
        $em->flush();

        return new \Symfony\Component\HttpFoundation\Response(1);
    }

    /**
     *  Method change status project all people.
     *
     *  This method is responsible for  change status  to project all people
     */
    public function changeStatusAllpeopleProjectAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('company'));
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $this->statusProjectAllPeopleCompany($oCompany, $oProject, $request->get('action'));
        $em->flush();

        return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for deleted company, which takes part in the project
     */
    public function removeCompanyProjectAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') and !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'people_permissions');
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('id'));
        $oProject->removeCompany($oCompany);
        $em->flush();

        return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
    }

    /**
     *  Method change status user.
     *
     *  This method is responsible for change status user, which takes part in the project
     */
    public function statusUserProjectAction(Request $request)
    {
        $this->getRequest()->getSession()->set('active_module', 'people_permissions');
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $oUser = $em->getRepository('WWSCThalamusBundle:User')->find($request->get('id'));
        if ('remove' == $request->get('action')) {
            $oProject->removeUser($oUser);
        }
        if ('add' == $request->get('action')) {
            $oProject->addUser($oUser);
        }
        $em->flush();

        return new \Symfony\Component\HttpFoundation\Response(1);
    }

    public function loadTable($oProject, $page)
    {
        $limit = 25;
        $countPage = $oProject->getLogPagination(true, $limit);
        $aData = array(
            'countPage' => $countPage,
            'currentPage' => $page,
            'oProject' => $oProject,
            'aLog' => $oProject->getLogPagination(false, $limit, $page),
        );

        return $aData;
    }

    public function showTableAction(Request $request)
    {
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));

        if ($oProject instanceof Project) {
            if (!$oProject->hasLog() && (0 == $oProject->getIsPublicDescription() || (!$oProject->getDescription() && 1 == $oProject->getIsPublicDescription()))) {
                return $this->render('WWSCThalamusBundle:Project:empty-project.html.twig', array('oProject' => $oProject));
            }
            $aData = $this->loadTable($oProject, $request->get('page', 1));
        }

        return $this->render('WWSCThalamusBundle:Project:table-log.html.twig', $aData);
    }

    /**
     *  Method overview.
     *
     *  This method is responsible for display  "overview project" page
     */
    public function overviewAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'overview');

        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));

        if ($oProject instanceof Project) {
            if (!$oProject->hasLog() && (0 == $oProject->getIsPublicDescription() || (!$oProject->getDescription() && 1 == $oProject->getIsPublicDescription()))) {
                return $this->render('WWSCThalamusBundle:Project:empty-project.html.twig', array('oProject' => $oProject));
            }
            $aData = $this->loadTable($oProject, $request->get('page', 1));
            if ($this->isGranted('ROLE_PROVIDER') && ('ROLE_ACCOUNTING' == $this->getUser()->getRole() || $oProject->getProjectleader('id') == $this->getUser()->getId())) {
                if (!$aFilter = $request->getSession()->get('aDateRangeFilter')) {
                    $aFilter = array();
                }
                if (!isset($aFilter[$request->get('project')]) && 2 == $oProject->getType()) {
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
                    if ('de' == $this->getUser()->getLanguageCode()) {
                        $aFilter = array($request->get('project') => ['date_from' => date('01-m-Y'), 'date_to' => date($daysInMonth.'-m-Y')]);
                    } else {
                        $aFilter = array($request->get('project') => ['date_from' => date('Y-m-01'), 'date_to' => date('Y-m-'.$daysInMonth)]);
                    }
                    $request->getSession()->set('aDateRangeFilter', $aFilter);
                }
                $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $oProject->getId(), 'all', false, $oProject->getSlug());
                $aData['aFinancesProject'] = isset($aFinancesProject[0]) ? $aFinancesProject[0] : array();
            }

            //var_dump($aData['aLog']); die;

            return $this->render('WWSCThalamusBundle:Project:overview.html.twig', $aData);
        }
    }

    /**
     *  Method add.
     *
     *  This method is responsible for create new project
     */
    public function addAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'todos');
        $fProject = $this->createForm(new ProjectForm());
        $fProject->remove('company');
        if ('POST' == $request->getMethod()) {
            $fProject->bind($request);
            if ($fProject->isValid()) {
                if ($this->get('service.form_validation')->isDuplicateUrl($this->getUser()->getCompany()->getAbbreviation(), $fProject->getData()->getProjectId())){
                    $request->getSession()->getFlashBag()->add('status', 'error');
                    $request->getSession()->getFlashBag()->add('notice', 'Project with this number id already exists in your company');
                }else {
                    $fProject = $fProject->getData();
                    $em = $this->getDoctrine()->getManager();
                    $oAccount = $em->getRepository('WWSCThalamusBundle:Account')->find($this->container->get('session')->get('account')->id);
                    $fProject->addCompany($this->getUser()->getCompany());
                    $fProject->setIsBillableHours(1);
                    $fProject->addUser($this->getUser());
                    if ($oAccount->getPrimaryCompany() != $this->getUser()->getCompany()) {
                        $fProject->addCompany($oAccount->getPrimaryCompany());
                    }
                    if ($oAccount->getAccountOwner() != $this->getUser()) {
                        $fProject->addUser($oAccount->getAccountOwner());
                    }
                    $fProject->setResponsibleCompany($this->getUser()->getCompany());
                    $em->persist($fProject);
                    $em->flush();

                    return $this->redirect($this->generateUrl('wwsc_thalamus_project_overview', array('project' => $fProject->getSlug())));
                }
            }
        }

        return $this->render('WWSCThalamusBundle:Project:add.html.twig', array('form' => $fProject->createView()));
    }

    /**
     *  Method edit.
     *
     *  This method is responsible for edit project
     */
    public function editAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') || !$this->getUser()->getHasRoleProject($request->get('project'), false, 'all')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'todos');
        $em = $this->getDoctrine()->getManager();
        if ($oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if ($oProject->getResponsibleCompany()) {
                $aUsers = $oProject->getUsers(false, 'ROLE_PROVIDER');
            } else {
                $aUsers = array();
            }
            $fProject = $this->createForm(new ProjectForm($oProject->getAccount()->getCompany(), $aUsers, $oProject->getTasks()), $oProject);
            if ('POST' == $request->getMethod()) {
                $fProject->bind($request);
                if ($fProject->isValid()) {
                    $projectConfig = trim($fProject->getData()->getConfig());
                    if ($fProject->getData()->getProjectId() != $oProject->getProjectId() && $this->get('service.form_validation')->isDuplicateUrl($this->getUser()->getCompany()->getAbbreviation(), $fProject->getData()->getProjectId())){
                        $request->getSession()->getFlashBag()->add('status', 'error');
                        $request->getSession()->getFlashBag()->add('notice', 'Project with this number id already exists in your company');
                    }else if($projectConfig && '{}' != $projectConfig && null === json_decode($projectConfig)) {
                        $request->getSession()->getFlashBag()->add('status', 'error');
                        $request->getSession()->getFlashBag()->add('notice', 'Json config is incorrect.');
                    }else{
                        $fProject = $fProject->getData();
                        $em->persist($fProject);
                        $em->flush();
                        $request->getSession()->getFlashBag()->add('notice', 'Project has  been updated sucessfully');
                        $request->getSession()->getFlashBag()->add('status', 'success');

                        return $this->redirect($this->generateUrl('wwsc_thalamus_project_edit', array('project' => $oProject->getSlug())));
                    }
                }
            }

            return $this->render('WWSCThalamusBundle:Project:edit.html.twig', array('form' => $fProject->createView(), 'oProject' => $oProject));
        }
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for delete project
     */
    public function deleteAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') and !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $oProject->setIsDeleted(1);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Project has been delete sucessfully');
        $request->getSession()->getFlashBag()->add('status', 'success');

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
    }
}
