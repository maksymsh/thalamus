<?php

namespace WWSC\ThalamusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WWSC\ThalamusBundle\Entity\Comment;
use WWSC\ThalamusBundle\Entity\Files;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WWSC\ThalamusBundle\Entity\Message;
use WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\ImapMailbox\ImapMailbox;

class ParsePostRunCommand extends ContainerAwareCommand
{
    public $is_inline_images;

    protected function configure()
    {
        $this->is_inline_images = false;
        $this
            ->setName('post:parse')
            ->setDescription('IMAP parse (cron)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('IMAP parse (cron)');
        $container = $this->getContainer();
        $ATTACHMENTS_DIR = __DIR__.'/../../../../web/uploads/files/';
        $mailBox = $container->getParameter('parse_imap_host');
        $mailBox = '{'.$mailBox.'/novalidate-cert}INBOX';
        $flag = 'thalamus_parser';
        $filter = 'UNKEYWORD "'.$flag.'"';
        $mailbox = new ImapMailbox($mailBox, $container->getParameter('parse_imap_login'), $container->getParameter('parse_imap_password'), $ATTACHMENTS_DIR, 'utf-8');
        if($messagesIds = $mailbox->searchMailbox($filter)){
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            foreach ($messagesIds as $messageId) {
                /*if($messageId > 109769) ){
                        $messageInfo = $mailbox->getMail($messageId);
                        if($messageInfo->fromAddress != "root@thalamus.io"){
                            echo $messageInfo->date. " == FROM:".$messageInfo->fromAddress." TO:".$messageInfo->mailUid." /n \n";
                        }
                    }*/
                $messageInfo = $mailbox->getMail($messageId);
                if($messageTo = $messageInfo->mailUid){
                    $messageFrom = $messageInfo->fromAddress;
                    $oSendUser = $em->getRepository('WWSCThalamusBundle:User')->findOneBy(array('email' => $messageFrom));
                    $componentsMailBox = explode('_', $messageTo);
                    $mailTitle = $messageInfo->subject;
                    //$mailContent = $messageInfo->textHtml;
                    $mailContentText = $messageInfo->textPlain;
                    $typeDocument = 'text';
                    if('' == trim($mailContentText)){
                        $mailContentText = $messageInfo->textHtml;
                        $typeDocument = 'html';
                    }
                    $mailAttachments = $messageInfo->getAttachments();
                    $aReplyUID = explode('@', $messageTo);
                    $replyUID = $aReplyUID[0];
                    $componentsMailBox = explode('_', $replyUID);
                    switch ($componentsMailBox[0]) {
                        case 'm':
                            if ($oObj = $em->getRepository('WWSCThalamusBundle:Message')
                                ->findOneBy(array('replyUID' => $replyUID))
                            ) {
                                $project = $oObj->getProject();
                                if($oSendUser && $oSendUser->getHasRoleProject($project->getSlug(), true)){
                                    $oUser = $oSendUser;
                                } else {
                                    $oUser = $project->getAccount()->getAccountOwner();
                                }
                                $this->addComment($oUser, $oObj, $mailContentText, $mailAttachments, $messageId, $project,
                                    'Comment', true, $typeDocument
                                );
                            }
                            break;
                        case 'ti':
                            if ($oObj = $em->getRepository('WWSCThalamusBundle:TaskItem')
                                ->findOneBy(array('replyUID' => $replyUID))
                            ) {
                                $project = $oObj->getTask()->getProject();
                                if($oSendUser) {
                                    $oUser = $oSendUser;
                                } else {
                                    $oUser = $project->getAccount()->getAccountOwner();
                                }
                                $this->addComment($oUser, $oObj, $mailContentText, $mailAttachments, $messageId, $project,
                                    'Comment' ,true, $typeDocument
                                );
                            }
                            break;
                        case 'pm':
                            $replyUID = explode('_', $replyUID);
                            if ($oObj = $em->getRepository('WWSCThalamusBundle:Project')
                                ->findOneBy(array('replyUID' => $replyUID[1]))
                            ) {
                                $project = $oObj;
                                if($oSendUser && $oSendUser->getHasRoleProject($project->getSlug(), true)){
                                    $oUser = $oSendUser;
                                }else{
                                    $oUser = $project->getAccount()->getAccountOwner();
                                }
                                $this->addMessage($oUser, $oObj, $mailTitle, $mailContentText, $mailAttachments, $messageId, $project, 'Message');
                            }
                            break;
                        default :
                            if ($oObj = $em->getRepository('WWSCThalamusBundle:Project')
                                ->findOneBy(array('replyUIDTask' => $replyUID))
                            ) {
                                $project = $oObj;
                                if($project->getPostTaskViaEmail()){
                                    $aMatches = null;
                                    $tid = false;
                                    if(preg_match('/^T-ID:[0-9]{2,20}/', $mailTitle, $aMatches)){
                                        $aMatches = explode(':',$aMatches[0]);
                                        $tid = $aMatches[1];
                                        $mailTitle = str_replace('T-ID:'.$tid, '', $mailTitle);
                                    }
                                    if(!$tid || !$oTask = $em->getRepository('WWSCThalamusBundle:Task')->find($tid)){
                                        $oTask = $em->getRepository('WWSCThalamusBundle:Task')->find($oObj->getPostTaskViaEmail());
                                    }
                                    if($oSendUser) {
                                        $oUser = $oSendUser;
                                    } else {
                                        $oUser = $project->getAccount()->getAccountOwner();
                                    }
                                    if($oTask = $this->addTask($oUser, $oObj, $mailTitle, $mailContentText, $oTask, $messageId, $project, $mailAttachments, $typeDocument)){
                                        if((!$oTask->getResponsible() || 'ROLE_PROVIDER' != $oTask->getResponsible()->getCompany($project->getAccount()->getId())->getRoles())
                                            && 'ROLE_CLIENT' == $oUser->getCompany($project->getAccount()->getId())->getRoles()){
                                            $this->responseMessageToEmail($oTask->getTask()->getProject()->getProjectleader()->getEmail(), $oTask, '','new_task_created');
                                        }
                                        if($oTask->getResponsible()->getId() != $oTask->getUserCreated()->getId()){
                                            $this->responseMessageToEmail($oTask->getResponsible()->getEmail(), $oTask, $mailContentText,  'task_assigned_user');
                                            $this->responseMessageToEmail($oTask->getUserCreated()->getEmail(), $oTask, $mailContentText,  'task_assigned_user');
                                        }else{
                                            $this->responseMessageToEmail($oTask->getUserCreated()->getEmail(), $oTask, $mailContentText, 'response-created-task-via-email');
                                        }
                                    }
                                }
                            }
                            break;
                    }
                }
                $mailbox->setFlag(array($messageId), $flag);
            }
        }
        $output->writeln('IMAP parse (cron). Finish !');
    }

    private function clearHistory( $messageBody, $type = 'text', $mailAttachments = false, $messageId = false ){

        if('text' == $type) {

            if(false !== strpos($messageBody,'Fügen Sie Ihre Antwort bitte OBERHALB DIESER ZEILE ein um einen weiteren Kommentar zu dieser Aufgabe hinzuzufügen')) {
                $messageBody = explode('Fügen Sie Ihre Antwort bitte OBERHALB DIESER ZEILE ein um einen weiteren Kommentar zu dieser Aufgabe hinzuzufügen', $messageBody);
            } else {
                $messageBody = explode('Reply ABOVE THIS LINE to add a comment to this message', $messageBody);
            }

        } else {

            if(false !== strpos($messageBody,'<div class="gmail_extra">')) {
                $messageBody = explode('<div class="gmail_extra">', $messageBody);
            } else if(false !== strpos($messageBody,'<div name="quote"') ){
                $messageBody = explode('<div name="quote"', $messageBody);
            }

        }

        $messageBody = reset($messageBody);
        $messageBody = ltrim($messageBody,'<html><head></head><body><div style="font-family: Verdana;font-size: 12.0px;"><div>');
        $messageBody = str_replace('<div>&nbsp;', '', $messageBody);
        $messageBody = trim($messageBody, "\n");

        if(false !== strpos($messageBody,'reply@thalamus.io<mailto:reply@thalamus.io>') ){
            $messageBody = explode("\n", trim($messageBody));
            if(false !== strpos(end($messageBody),'reply@thalamus.io<mailto:reply@thalamus.io>') ){
                array_pop($messageBody);
            }
            $messageBody = implode("\n", $messageBody);
        }

        if(false !== strpos($messageBody,'<reply@thalamus.io>')){
            $messageBody = explode('<reply@thalamus.io>', trim($messageBody));
            $messageBody = reset($messageBody);
            $messageBody = explode("\n", trim($messageBody));
            array_pop($messageBody);
            $messageBody = implode("\n", $messageBody);
        }

        /*inline image*/
        if($mailAttachments){
            if($messageBody = preg_replace("/\[image:([^\:]+)\]/i", '{src_img}', $messageBody)){
                if(false !== strpos($messageBody,'{src_img}')){
                    $this->is_inline_images = true;
                    $messageBody = explode ('{src_img}', $messageBody);
                    $aIiImgs = array_values($mailAttachments);
                    foreach($messageBody as $key => $val){
                        if($key < count($messageBody) - 1 ){
                            if(isset($aIiImgs[$key])) {
                                $newNameImg = substr($aIiImgs[$key]->name, -6, 6);
                                $fileSrc = $messageId.'_'.$aIiImgs[$key]->id.'_'.$newNameImg;
                                $messageBody[$key] = $val.'{img_src} ![](https://thalamus.io/uploads/comment/'.$fileSrc.' "")';
                            }
                        }
                    }
                    $messageBody = implode('{img_src}',$messageBody);
                    $messageBody = str_replace('{img_src}','',$messageBody);
                }
            }
        }

        return $messageBody;
    }

    private function addMessage($oUser, $oObj, $mailTitle, $mailContent, $mailAttachments, $messageId, $project, $typePhoto){
        if (isset($oUser)) {
            $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
            $this->getContainer()->get('security.context')->setToken($token);
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            if ($oObj) {
                $oMessage = new Message();
                $oMessage->setDescription($this->clearHistory($mailContent));
                $oMessage->setUserCreated($oUser);
                $oMessage->setProject($oObj);
                $oMessage->setTitle($mailTitle);
                $em->persist($oMessage);
                $em->flush();
                $this->downloadAttachments($mailAttachments, $messageId, $project, $typePhoto, $oMessage->getId());
            }
        }
    }

    private function addTask($oUser, $oObj, $mailTitle, $mailContent, $oTask, $messageId, $project, $mailAttachments, $typeDocument = 'text'){
        if (isset($oUser)) {
            $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
            $this->getContainer()->get('security.context')->setToken($token);
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $aMatches = null;
            if(preg_match('/(^|\s)@[a-zA-Z0-9_.+-]{2,250}/', $mailTitle, $aMatches)){
                $aMatches = explode('@',$aMatches[0]);
                $userResponsible = $aMatches[1];
                $mailTitle = str_replace('@'.$userResponsible,'',$mailTitle);
                $userResponsible = $userResponsible.'@';
                $aRoles = array('ROLE_PROVIDER');
                if(1 == $oTask->getVisibleClient()){
                    $aRoles[] = 'ROLE_CLIENT';
                }
                if(1 == $oTask->getVisibleFreelancer()){
                    $aRoles[] = 'ROLE_FREELANCER';
                }
                if(!$oUserResponsible = $oTask->getProject()->getUserByFirstPartEmail($userResponsible, $aRoles)){
                    $oUserResponsible = $oUser;
                }
            }else{
                $oUserResponsible = $oUser;
            }

            if ($oObj) {
                $oTaskItem = new TaskItem();
                $oTaskItem->setDescription($mailTitle);
                $oTaskItem->setUserCreated($oUser);
                $oTaskItem->setTask($oTask);
                $oTaskItem->setStatus(0);
                $oTaskItem->setResponsible($oUserResponsible);
                $em->persist($oTaskItem);
                $em->flush();
                $aSubspeople = array();
                $aSubspeople[$oUserResponsible->getId()] = $oUserResponsible->getId();
                if(!isset($aSubspeople[$oUser->getId()])){
                    $aSubspeople[$oUser->getId()] = $oUser->getId();
                }

                \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $oTaskItem->getId(), 'TaskItem');
                $this->addComment($oUser, $oTaskItem, $mailContent, $mailAttachments, $messageId, $project, 'Comment', false, $typeDocument );

                return $oTaskItem;
            }
        }
    }

    private function addComment($oUser, $oObj, $mailContent, $mailAttachments, $messageId, $project, $typePhoto, $sendSubscribeEmail = true, $typeDocument = 'text'){
        if (isset($oUser)) {
            $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
            $this->getContainer()->get('security.context')->setToken($token);
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $description = $this->clearHistory($mailContent, $typeDocument, $mailAttachments, $messageId);

            if (trim($description) && $oObj) {
                $oComment = new Comment();
                $oComment->setDescription($description);
                $oComment->setUserCreated($oUser);
                $oComment->setParentId($oObj->getId());
                $rc = new \ReflectionClass(get_class($oObj));
                $oComment->setType($rc->getShortName());
                $em->persist($oComment);
                $em->flush();
                if(count($mailAttachments) > 0){
                    $this->downloadAttachments($mailAttachments, $messageId, $project, $typePhoto, $oComment->getId());
                }
                if($sendSubscribeEmail){
                    $this->sendSubscribeEmail($oComment);
                }
            }
        }
    }

    private function downloadAttachments($mailAttachments, $messageId, $oProject, $type, $parentId){
        foreach ($mailAttachments as $mailAttachment){
            $newNameImg = substr($mailAttachment->name, -6, 6);
            $fileSrc = $messageId.'_'.$mailAttachment->id.'_'.$newNameImg;
            $aSrcFile = explode('/' , $mailAttachment->filePath);
            $aSrcFile[count($aSrcFile) - 1] = $fileSrc;
            $newSrcFile = implode('/',$aSrcFile);
            if($this->is_inline_images && false !== strpos($mailAttachment->id, 'ii_') ){
                $newSrcFile = str_replace('/files/','/comment/', $newSrcFile);
                rename($mailAttachment->filePath, $newSrcFile);
            }else{
                if(false === strpos($mailAttachment->name,'.prod.outlook.com')){
                    rename($mailAttachment->filePath, $newSrcFile);
                    $newFile = new Files();
                    $newFile->setName($mailAttachment->name);
                    $newFile->setFileSrc($fileSrc);
                    $newFile->setFileSize(filesize($newSrcFile));
                    $newFile->setProject($oProject);
                    $newFile->setParent($parentId);
                    $newFile->setType($type);
                    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
                    $em->persist($newFile);
                    $em->flush();
                }
            }
        }
    }

    public function sendSubscribeEmail($object) {
        if ('Message' == $object->getType()) {
            $subject = 'Re:['.$object->getParentInfo()->getProject()->getName().'] '.$object->getParentInfo()->getTitle();
            $template = 'subscribe_comment_to_message.txt.twig';
            $priotity = 3;
            $aUsers = $object->getParentInfo()->getActiveSubscribed('info');
        } elseif ('TaskItem' == $object->getType()) {
            $subject = 'Re:['.$object->getParentInfo()->getTask()->getProject()->getName().'] '.$object->getParentInfo()->getDescription();
            $template = 'subscribe_comment_to_task.txt.twig';
            $priotity = $object->getParentInfo()->getFastTrack() ? 2 : 3;
            $aUsers = $object->getParentInfo()->getActiveSubscribed('info', $object->getPrivate());
        }
        if($aUsers){
            if('TaskItem' == $object->getType()){
                if (false !== ($keyResponsible = array_search($object->getUserCreated()->getEmail(), $aUsers['email']))) {
                    unset($aUsers['email'][$keyResponsible]);
                }
            }
            foreach ($aUsers['email'] as $userEmailKey => $userEmail) {
                $aData = array(
                    'oElement' => $object,
                    'aUsers' => $aUsers['name'],
                    'roleUser' => '',
                );
                if(isset($aUsers['lang'][$userEmailKey])){
                    $langTemplate = $aUsers['lang'][$userEmailKey];
                }else{
                    $langTemplate = 'en';
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($this->getContainer()->getParameter('admin_email'))
                    ->setReplyTo(
                        $object->getParentInfo()->getReplyUID()
                        .'@'.$this->getContainer()->getParameter('auto_reply_email_domain')
                    )
                    ->setContentType('text/html')
                    ->setPriority($priotity)
                    ->setTo($userEmail)
                    ->setBody($this->getContainer()->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template, $aData));
                $this->getContainer()->get('mailer')->send($message);
            }
        }
    }

    public function responseMessageToEmail($email, $oTask, $mailContentText, $template = 'task_assigned_user') {
        if('new_task_created' == $template) {
            $subject = 'NEW TASK CREATED '.'#'.$oTask->getId().' '.$oTask->getDescription();
            $langTemplate = $oTask->getTask()->getProject()->getProjectleader()->getLanguageCode();
        }else {
            $subject = '['.$oTask->getTask()->getProject()->getName().'] Notification Email: '.$oTask->getDescription();
            $langTemplate = $oTask->getResponsible()->getLanguageCode();
        }
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->getContainer()->getParameter('admin_email'))
            ->setReplyTo(
                $oTask->getReplyUID()
                .'@'.$this->getContainer()->getParameter('auto_reply_email_domain')
            )
            ->setContentType('text/html')
            ->setTo($email)
            ->setBody($this->getContainer()->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template.'.txt.twig', array('oElement' => $oTask, 'commentText' => $this->clearHistory($mailContentText))));
        $this->getContainer()->get('mailer')->send($message);
    }
}