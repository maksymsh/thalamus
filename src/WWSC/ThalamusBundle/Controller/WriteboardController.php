<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Form\WriteboardForm;
use WWSC\ThalamusBundle\Entity\SubscribeEmail;

/**
 * Writeboard controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display task.
 */
class WriteboardController extends Controller {
    /**
     *  Method list.
     * 
     *  This method is responsible for display tasks and persons on  the page "To-dos"
     */
    public function listAction(Request $request) {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'writeboards');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if (0 == count($oProject->getWriteboards())) {
                return $this->render('WWSCThalamusBundle:Writeboard:empty-writeboards.html.twig', array('oProject' => $oProject));
            }

            return $this->render('WWSCThalamusBundle:Writeboard:list.html.twig', array('oProject' => $oProject));
        }
    }

    /**
     *  Method show comments for writeboard.
     *
     *  This method is responsible for display comments for writeboard.
     */
    public function showAction(Request $request) {
        if($oWriteboard = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->findOneBy(array('number' => $request->get('number'), 'active' => 1) , array('created' => 'DESC'))){
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oWriteboard->hasAccessToWriteboard() ) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $this->getRequest()->getSession()->set('active_module', 'writeboards');

            return $this->render('WWSCThalamusBundle:Writeboard:show.html.twig', array('oWriteboard' => $oWriteboard));
        }
    }

    /**
     *  Method show version  writeboard.
     *
     *  This method is responsible for display comments for writeboard.
     */
    public function showVersionAction(Request $request) {
        if($oWriteboard = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->find($request->get('id'))){
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oWriteboard->hasAccessToWriteboard() ) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }

            return new JsonResponse(array('html' => $this->renderView('WWSCThalamusBundle:Writeboard:writeboard-info.html.twig', array('oWriteboard' => $oWriteboard))));
        }
    }    

    /**
     *  Method add.
     *
     *  This method is responsible for create new task
     */
    public function addAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') || !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'writeboards');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $fWriteboard = $this->createForm(new WriteboardForm());
            if ('POST' == $request->getMethod()) {
                $fWriteboard->bind($request);
                if ($fWriteboard->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fWriteboard = $fWriteboard->getData();
                    $fWriteboard->setProject($oProject);
                    $fWriteboard->setActive(1);
                    $em->persist($fWriteboard);
                    $em->flush();
                    if(!$aSubspeople = $request->get('aSubspeople')){
                        $aSubspeople = array();
                    }
                    if($request->get('aFiles')){
                        \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $fWriteboard->getId(), $oProject, 'Writeboard');
                    }
                    $currentUserId = $this->getUser()->getId();
                    if(!array_key_exists($currentUserId, $aSubspeople)){
                        $aSubspeople[$currentUserId] = "{$currentUserId}";
                    }
                    SubscribeEmail::saveSubscribeEmail($aSubspeople, $fWriteboard->getNumber(), 'Writeboard');
                    $this->sendSubscribeEmail($fWriteboard, 'Writeboard', 'writeboard_message');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_project_writeboards', array('project' => $request->get('project'))));
                }
            }

            return $this->render('WWSCThalamusBundle:Writeboard:add.html.twig', array('form' => $fWriteboard->createView(), 'nameProject' => $oProject->getName(), 'aSubsCompanies' => $oProject->getSubspeople(), 'slugProject' => $request->get('project')));
        }
    }

    /**
     *  Method edit.
     *
     *  This method is responsible  for edit message
     */
    public function editAction(Request $request) {
        if($oWriteboard = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->find($request->get('id'))){
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oWriteboard->hasAccessToWriteboard()) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $fWriteboard = $this->createForm(new WriteboardForm());
            $formView = $fWriteboard->createView();
            if ('POST' == $request->getMethod()) {
                $fWriteboard->bind($request);
                if ($fWriteboard->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fWriteboard = $fWriteboard->getData();
                    $fWriteboard->setActive(1);
                    $fWriteboard->setProject($oWriteboard->getProject());
                    $fWriteboard->setNumber($oWriteboard->getNumber());
                    $fWriteboard->setVersion($oWriteboard->getVersion() + 1);
                    $em->persist($fWriteboard); 
                    $oWriteboard->setActive(0);
                    $oWriteboard->setSaveToLog(0);
                    $em->flush();
                    if($oWriteboard->getFiles()){
                        foreach ($oWriteboard->getFiles() as $oFile){
                            $cloneFiles = clone $oFile;
                            $cloneFiles->setSaveToLog(0);
                            $cloneFiles->setParent($fWriteboard->getId());
                            $em->persist($cloneFiles);
                            $em->flush();
                        }
                    }
                    if($request->get('aFiles')){
                        \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $fWriteboard->getId(), $fWriteboard->getProject(), 'Writeboard');
                    }

                    $this->sendSubscribeEmail($fWriteboard, 'Writeboard', 'writeboard_message');

                    return new JsonResponse(array('html' => $this->renderView('WWSCThalamusBundle:Writeboard:writeboard-info.html.twig', array('oWriteboard' => $fWriteboard))));
                }
                $output['error'] = 'The data were filed incorrectly!';

                return new JsonResponse($output);
        }

           return new JsonResponse(array('html' => $this->renderView('WWSCThalamusBundle:Writeboard:edit.html.twig', array('form' => $formView, 'slugProject' => $request->get('project'), 'oWriteboard' => $oWriteboard))));
        }
    }

    public function updateNameAction(Request $request) {
        if($oWriteboard = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->find($request->get('id'))){
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oWriteboard->hasAccessToWriteboard()) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $output = array();
            $em = $this->getDoctrine()->getManager();
            $oWriteboard->setName($request->get('name-writeboard'));
            $em->flush();
            $output['name'] = $request->get('name-writeboard');

            return new JsonResponse($output);

            $output['error'] = 'The data were filed incorrectly!';

            return new JsonResponse($output);
        }
    }

    /**
     *  Method delete.
     * 
     *  This method is responsible for delete task
     */
    public function deleteAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') || !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $aWriteboards = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->findBy(array('number' => $request->get('number')));
        foreach ($aWriteboards as $oWriteboard){
            $oWriteboard->setIsDeleted(1);
            $em->flush();
        }
        if ('GET' == $request->getMethod()) {
            return $this->redirect($this->generateUrl('wwsc_thalamus_project_writeboards', array('project' => $request->get('project'))));
        }

        return new Response(1);
    }

    public function sendSubscribeEmail($object, $type, $template){
         $subject = '['.$object->getProject()->getName().'] '.$type.' - '.$object->getName();
         $aUsers = $object->getActiveSubscribed('info');         
         foreach($aUsers['email'] as $userEmailKey => $userEmail){
            if($userEmailKey != $this->getUser()->getID()){
                if(isset($aUsers['lang'][$userEmailKey])){
                    $langTemplate = $aUsers['lang'][$userEmailKey];
                }else{
                    $langTemplate = 'en';
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setReplyTo(
                        $object->getReplyUID()
                        .'@'.$this->container->getParameter('auto_reply_email_domain')
                    )
                    ->setFrom($this->container->getParameter('admin_email'))
                    ->setContentType('text/html')
                    ->setTo($userEmail)
                    ->setBody($this->renderView('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template.'.txt.twig', array(
                        'oElement' => $object,
                        'aUsers' => $aUsers['name'],
                    )));
                $this->get('mailer')->send($message);
            }
        }
    }

    public function statusUserWriteboardAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $action = $request->get('action');
        $aUsers = $request->get('aUsers');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
                $oWriteboard = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Writeboard')->find($request->get('id'));
                if($aUsers){
                    if('add' == $action){
                        $aActiveSubscribed = $oWriteboard->getActiveSubscribed('id');
                        SubscribeEmail::saveSubscribeEmail(array_merge($aActiveSubscribed,$aUsers), $oWriteboard->getNumber(), 'Writeboard');
                    }else if('remove' == $action){
                        $aActiveSubscribed = $oWriteboard->getActiveSubscribed('id');
                        foreach($aUsers as $user){
                            unset($aActiveSubscribed[$user]);
                        }
                        SubscribeEmail::saveSubscribeEmail($aActiveSubscribed, $oWriteboard->getNumber(), 'Writeboard');
                    }
                }
            }
            $em->flush();

            return new \Symfony\Component\HttpFoundation\Response(1);
        }
}
