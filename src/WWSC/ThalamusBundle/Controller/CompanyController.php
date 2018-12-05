<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Company;
use WWSC\ThalamusBundle\Form\CompanyForm;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Company controler.
 *
 * In this controller describes the functions of adding, editing, deleting and display companies.
 */
class CompanyController extends Controller {
    /**
     * Method add.
     * 
     * This method is responsible for display modal window, add company on  the page "All People"
     * 
     * @return If successful creation of new company, redirect on page all people. When an error occurs an error message
     */
    public function addAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $fCompany = $this->createForm(new CompanyForm());
        if ('POST' == $request->getMethod()) {
            $fCompany->bind($request);
            if ($fCompany->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fCompany = $fCompany->getData();
                $fCompany->setAccount($this->getUser()->getCompany()->getAccount());
                $em->persist($fCompany);
                $em->flush();
                if ($request->get('project')) {
                    $oProject = $em->getRepository('WWSCThalamusBundle:Project')->find($request->get('project'));
                    $oProject->addCompany($fCompany);
                    $em->flush();

                    return $this->redirect($this->generateUrl('wwsc_thalamus_add_project_people', array('project' => $oProject->getSlug())));
                } else {
                    $request->getSession()->getFlashBag()->add('notice', 'Company has  been created sucessfull');
                    $request->getSession()->getFlashBag()->add('status', 'success');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
                }
            }
            $errors = $fCompany->getErrors();
            $request->getSession()->getFlashBag()->add('notice', $errors[0]->getMessage());
            $request->getSession()->getFlashBag()->add('status', 'error');

            return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
        }

        return $this->render('WWSCThalamusBundle:Company:add.html.twig', array('form' => $fCompany->createView()));
    }

    /**
     * Method edit.
     * 
     * This method is responsible for edit company
     * 
     * @return If successful updated  company, message about successfully updated company. When an error occurs an error message.
     */
    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('id'))) {
            if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && $this->getUser()->getCompany()->getId() != $request->get('id')
                    || !$oCompany->getAccount()->getChekUserForAccount($this->getUser(), true)) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $fCompany = $this->createForm(new CompanyForm(), $oCompany);
            if (1 == $oCompany->getPrimaryCompany() || !$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
                $fCompany->remove('roles');
            }
            if ('POST' == $request->getMethod()) {
                $fCompany->bind($request);
                if ($fCompany->isValid()) {
                    $fCompany = $fCompany->getData();
                    $em->persist($fCompany);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('notice', 'Company has been updated sucessfully');
                    $request->getSession()->getFlashBag()->add('status', 'success');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_company_edit', array('id' => $request->get('id'))));
                }
            }

            return $this->render('WWSCThalamusBundle:Company:edit.html.twig', array('form' => $fCompany->createView(), 'company' => $oCompany));
        }
    }

    public function timeTrackTodayAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        return new JsonResponse(array('timeTrackToday' => \WWSC\ThalamusBundle\Entity\TimeTracker::getTimeTrackToday('company')));
    }

     public function getUsersAction(Request $request) {
         $em = $this->getDoctrine()->getManager();
        if ($oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($request->get('id'))) {
            return new JsonResponse(array('selectUser' => $this->renderView('WWSCThalamusBundle:Company:select-users.html.twig', array('aUsers' => $oCompany->getUsers()))));
        }
    }

    /**
     *  Method delete.
     * 
     * This method is responsible for delete company
     * 
     * @return If successful deleteed  company, message about successfully deleted company.
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $oCompany = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Company')->find($request->get('id'));
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') || !$oCompany->getAccount()->getChekUserForAccount($this->getUser(), true)) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($oCompany->getProjects()) {
            foreach ($oCompany->getProjects() as $oProject) {
                $oProject->removeCompany($oCompany);
            }
        }
        $oCompany->setAccount(NULL);
        $oCompany->setIsDeleted(1);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Company has been success removed');
        $request->getSession()->getFlashBag()->add('status', 'success');

        return $this->redirect($this->generateUrl('wwsc_thalamus_account_all_people'));
    }
}
