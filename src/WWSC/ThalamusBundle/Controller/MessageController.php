<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Form\MessageForm;
use WWSC\ThalamusBundle\WWSCThalamusBundle;
use WWSC\ThalamusBundle\Entity\SubscribeEmail;
/**
 * Message controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display messages.
 */
class MessageController extends Controller {
    /**
     *  Method list.
     * 
     *  This method is responsible for display tasks and persons on  the page "Messages"
     */
    public function listAction(Request $request) {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'messages');
        if($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))){
            if (0 == count($oProject->getMessages())) {
                return $this->render('WWSCThalamusBundle:Message:empty-messages.html.twig', array('slugProject' => $oProject->getSlug(), 'nameProject' => $oProject->getName()));
            }
            $aCategory = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => 'MESSAGE',
            ));

            return $this->render('WWSCThalamusBundle:Message:expanded-view.html.twig', array('slugProject' => $oProject->getSlug(), 'nameProject' => $oProject->getName(), 'aCategory' => $aCategory, 'aMessages' => $oProject->getMessages($request->get('cat'))));
        }
    }

    /**
     *  Method add.
     *
     *  This method is responsible for create new message
     */
    public function addAction(Request $request) {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'messages');
        if($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))){
            $aCategory = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => 'MESSAGE',
            ));
            $fMessage = $this->createForm(new MessageForm($aCategory));
            $formView = $fMessage->createView();
            $formView->children['category']->vars['choices'][] = new \Symfony\Component\Form\Extension\Core\View\ChoiceView (null, 'add!', '— add a new category —');
            if ('POST' == $request->getMethod()) {
                $fMessage->bind($request);
                if ($fMessage->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fMessage = $fMessage->getData();
                    $fMessage->setProject($oProject);
                    $em->persist($fMessage);
                    $em->flush();
                    if($request->get('aFiles')){
                        \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $fMessage->getId(), $oProject, 'Message');
                    }
                    if(!$aSubspeople = $request->get('aSubspeople')){
                        $aSubspeople = array();
                    }
                    $currentUserId = WWSCThalamusBundle::getContainer()
                        ->get('security.context')->getToken()->getUser()->getId();
                    if(!array_key_exists($currentUserId, $aSubspeople)){
                        $aSubspeople[$currentUserId] = "{$currentUserId}";
                    }
                    SubscribeEmail::saveSubscribeEmail($aSubspeople, $fMessage->getId(), 'Message');
                    $this->sendSubscribeEmail($fMessage, 'Message','subscribe_message');

                    return $this->redirect($this->generateUrl('wwsc_thalamus_project_message_comments', array('project' => $request->get('project'), 'id' => $fMessage->getId())));
                }
            }

            return $this->render('WWSCThalamusBundle:Message:add.html.twig', array('form' => $formView, 'nameProject' => $oProject->getName(), 'slugProject' => $oProject->getSlug(), 'aSubsCompanies' => $oProject->getSubspeople()));
        }
    }

    /**
     *  Method edit.
     *
     *  This method is responsible  for edit message
     */
    public function editAction(Request $request) {
        if($oMessage = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Message')->find($request->get('id'))){
            $aCategoryFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oMessage->getProject()->getId(),
                'type' => 'MESSAGE',
            ));
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oMessage->hasAccessToMessage()) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $fMessage = $this->createForm(new MessageForm($aCategoryFile), $oMessage);
            $formView = $fMessage->createView();
            $formView->children['category']->vars['choices'][] = new \Symfony\Component\Form\Extension\Core\View\ChoiceView (null, 'add!', '— add a new category —');
            if ('POST' == $request->getMethod()) {
                $fMessage->bind($request);
                if ($fMessage->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fMessage = $fMessage->getData();
                    $em->persist($fMessage);
                    $em->flush();     
                    if($request->get('aFiles')){
                        \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $oMessage->getId(), $oMessage->getProject(),'Message');
                    }
                    if($fMessage->getActiveSubscribed() != $request->get('aSubspeople')){
                        \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($request->get('aSubspeople'), $fMessage->getId(), 'Message');
                    }

                    if($request->get('notify_about_changes')){
                        $this->sendSubscribeEmail($fMessage, 'Message','subscribe_change_message');
                    }

                    return $this->redirect($this->generateUrl('wwsc_thalamus_project_message_comments', array('project' => $request->get('project'), 'id' => $oMessage->getId())));
                }
            }

            return $this->render('WWSCThalamusBundle:Message:edit.html.twig', array('form' => $formView, 'slugProject' => $request->get('project'), 'oMessage' => $oMessage));
        }
    }

    /**
     *  Method delete.
     * 
     *  This method is responsible for delete message
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $oMessage = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Message')->find($request->get('id'));
        if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oMessage->hasAccessToMessage()) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oMessage->setIsDeleted(1);
        $em->flush();

        return $this->redirect($this->generateUrl('wwsc_thalamus_project_messages', array('project' => $request->get('project'))));
    }

    /**
     *  Method show comments for message.
     *
     *  This method is responsible for display comments for message.
     */
    public function commentsAction(Request $request) {
        if($oMessage = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Message')->find($request->get('id'))){
            if (!$this->getUser()->getHasRoleProject($request->get('project')) || !$oMessage->hasAccessToMessage() ) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $this->getRequest()->getSession()->set('active_module', 'messages');

            return $this->render('WWSCThalamusBundle:Message:comments.html.twig', array('oMessage' => $oMessage));
        }
    }

    /**
     *  Method show guid for message.
     *
     *  This method is responsible for display guid for message.
     */
    public function guidMessagesAction(Request $request){
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));

        return $this->render('WWSCThalamusBundle:Message:guid-messages.html.twig', array('oProject' => $oProject));
    }

    /**
     *  Method send message to email.
     *
     *  The method responsible for  sending  message  to users who have subscribed to message
     */   
    public function sendSubscribeEmail($object, $type, $template){
         $subject = '['.$object->getProject()->getName().'] '.$type;
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
}
