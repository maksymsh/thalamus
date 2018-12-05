<?php

namespace WWSC\ThalamusBundle\Controller;

use Proxies\__CG__\WWSC\ThalamusBundle\Entity\TaskItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Form\CommentForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWSC\ThalamusBundle\WWSCThalamusBundle;
use ZipArchive;
/**
 * Comment controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display comment.
 */
class CommentController extends Controller
{
    /**
     *  Method add.
     *
     *  This method is responsible for create new comment
     *
     * @return If successful creation of new comment, returned template info about a new comment(method ajax) on  the page  "comments to task item". When an error occurs an error message
     */
    public function addAction(Request $request)
    {
        $oParent = $this->getDoctrine()->getRepository('WWSCThalamusBundle:'.$request->get('type'))->find($request->get('parent'));
        $fComment = $this->createForm(new CommentForm());
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $isTimeTracker = false;
        if ('TaskItem' == $request->get('type') && ($this->container->get('security.context')->isGranted('ROLE_PROVIDER') || $this->container->get('security.context')->isGranted('ROLE_FREELANCER'))) {
            if ($oParent->getTask()->getIsTimeTracker()) {
                $isTimeTracker = true;
                $fComment->add('time_tracker', new \WWSC\ThalamusBundle\Form\TimeTrackerForm());
            }
        }
        if ('POST' == $request->getMethod()) {

            $output = array();
            $fComment->bind($request);
            if ($fComment->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $fComment = $fComment->getData();
                $desc = strtolower($fComment->getDescription());

                if ('true' == $request->get('confirmMsg') && $desc && (false !== strpos($desc, 'screenshot') || false !== strpos($desc, 'attached')) && !$request->get('aFiles')) {
                    return new JsonResponse(array('confirm' => true, 'message' => 'Are you sure to not attach any files to this comment?'));
                }

                $fComment->setDescription(htmlspecialchars($fComment->getDescription()));
                $fComment->setParentId($oParent->getId());
                $fComment->setType($request->get('type'));
                $em->persist($fComment);
                $notSendResponsible = false;

                if ($isTimeTracker) {
                    $fComment->getTimeTracker()->setComment($fComment);
                }

                if ('TaskItem' == $request->get('type')) {
                    if (!is_null($taskItemData = $request->get('wwsc_thalamusbundle_task_item'))) {
                        if ($oParent->getState() != $taskItemData['state'] || $oParent->getResponsible()->getId() != $taskItemData['responsible']) {
                            if (array_key_exists('state', $taskItemData)) {
                                $oParent->setState($taskItemData['state'], false);
                            }
                            if (array_key_exists('responsible', $taskItemData)) {
                                $user = $em->getRepository('WWSCThalamusBundle:User')->find($taskItemData['responsible']);
                                $oParent->setResponsible($user, false);
                            }
                            $notSendResponsible = true;
                        }
                    }
                    $oParent->saveLastVisitToTask();
                }

                $em->flush();

                if ($request->get('aFiles')) {
                    \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $fComment->getId(), $oProject, 'Comment');
                }

                if ($notSendResponsible) {
                    \WWSC\ThalamusBundle\Entity\SubscribeEmail::sendSubscribeEmail($fComment, 'TaskItem', $taskItemData['responsible']);
                }

                if ('Message' != $request->get('type') && !$aSubspeople = $request->get('aSubspeople')) {
                    $aSubspeople = array();
                }
                
                if ('TaskItem' != $request->get('type')) {
                    $aSubspeople = $fComment->getParentInfo()->getActiveSubscribed();
                }

                if (!array_key_exists($this->getUser()->getId(), $aSubspeople)) {
                    $aSubspeople[$this->getUser()->getId()] = "{$this->getUser()->getId()}";
                }

                if ($fComment->getParentInfo()->getActiveSubscribed() != $aSubspeople) {
                    \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail(
                        $aSubspeople, $fComment->getParentInfo()->getId(), $request->get('type')
                    );
                    $output['notificationSidebar'] = $this->renderView(
                        'WWSCThalamusBundle:SubscribeEmail:comments_notification-sidebar.html.twig', array(
                            'oParent' => $fComment->getParentInfo(),
                            'type' => $request->get('type'),
                            'slugProject' => $request->get('project'),
                        )
                    );
                }
                if ($fComment->getParentInfo()->getActiveSubscribed()) {
                    \WWSC\ThalamusBundle\Entity\SubscribeEmail::sendSubscribeEmail($fComment, 'Comment', false, $notSendResponsible);
                }
                $output['htmlComment'] = $this->renderView('WWSCThalamusBundle:Comment:comment-info.html.twig', array('oComment' => $fComment, 'slugProject' => $request->get('project')));
                $output['commentID'] = $fComment->getId();

                return new JsonResponse($output);
            }
            $errors = $fComment->getErrors();
            $output['error'] = $errors[0]->getMessage();

            return new JsonResponse($output);

        }

        return $this->render('WWSCThalamusBundle:Comment:add.html.twig', array(
            'form' => $fComment->createView(),
            'type' => $request->get('type'),
            'oParent' => $oParent,
            'slugProject' => $request->get('project'),
            'aTaskItemStates' => TaskItem::$states,
        ));
    }

    /**
     *  Method edit.
     *
     *  This method is responsible  for edit comment
     *
     * @return If successful updated  comment, returned template info about updated comment(method ajax) on  the page  "comments to task item". When an error occurs an error message
     */
    public function editAction(Request $request)
    {
        $oComment = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Comment')->find($request->get('id'));
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $oComment->setDescription(htmlspecialchars_decode($oComment->getDescription()));
        $fComment = $this->createForm(new CommentForm(), $oComment);
        $isBillableHours = $oProject->getIsBillableHours();
        if ($oTimeTracker = $oComment->getTimeTracker()) {
            $isBillableHours = $oTimeTracker->getBillable();
            $fComment->add('time_tracker', new \WWSC\ThalamusBundle\Form\TimeTrackerForm());
        }
        if ('POST' == $request->getMethod()) {
            $output = array();
            $fComment->bind($request);
            if ($fComment->isValid()) {

                $fComment = $fComment->getData();
                $em = $this->getDoctrine()->getManager();
                $fComment->setDescription(htmlspecialchars($fComment->getDescription()));
                $em->persist($fComment);
                $notSendResponsible = false;
                if ('TaskItem' == $oComment->getType()) {
                    if (!is_null($taskItemData = $request->get('wwsc_thalamusbundle_task_item'))) {
                        $taskItem = $oComment->getParentInfo();
                        if ($taskItem->getState() != $taskItemData['state'] || $taskItem->getResponsible()->getId() != $taskItemData['responsible']) {
                            if (array_key_exists('state', $taskItemData)) {
                                $taskItem->setState($taskItemData['state'], false);
                            }
                            if (array_key_exists('responsible', $taskItemData)) {
                                $user = $em->getRepository('WWSCThalamusBundle:User')->find($taskItemData['responsible']);
                                $taskItem->setResponsible($user, false);
                            }
                            \WWSC\ThalamusBundle\Entity\SubscribeEmail::sendSubscribeEmail($oComment, 'TaskItem', $taskItemData['responsible']);
                            $notSendResponsible = true;
                        }
                    }
                    $oComment->getParentInfo()->saveLastVisitToTask();
                }
                $em->flush();
                if ($request->get('aFiles')) {
                    \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($request->get('aFiles'), $fComment->getId(), $oProject, 'Comment');
                }
                if ('TaskItem' == $fComment->getType()) {
                    if ($fComment->getParentInfo()->getActiveSubscribed() != $request->get('aSubspeople')) {
                        \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($request->get('aSubspeople'), $fComment->getParentInfo()->getId(), 'TaskItem');
                        $output['notificationSidebar'] = $this->renderView('WWSCThalamusBundle:SubscribeEmail:comments_notification-sidebar.html.twig', array('oParent' => $fComment->getParentInfo(), 'type' => 'TaskItem', 'slugProject' => $request->get('project')));
                    }
                }
                $output['htmlComment'] = $this->renderView('WWSCThalamusBundle:Comment:comment-info.html.twig', array('oComment' => $fComment, 'slugProject' => $request->get('project')));

                return new JsonResponse($output);

            }
            $errors = $fComment->getErrors();
            $output = array();
            $output['error'] = $errors[0]->getMessage();

            return new JsonResponse($output);
        }

        return $this->render('WWSCThalamusBundle:Comment:edit.html.twig', array(
            'form' => $fComment->createView(),
            'isBillableHours' => $isBillableHours,
            'slugProject' => $request->get('project'),
            'oComment' => $oComment,
            'aTaskItemStates' => TaskItem::$states,
        ));
    }

    public function downloadAllFilesAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oComment = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Comment')->find($request->get('id'));
        $archive_file_name = $oComment->getParentId().'_Thalamus.zip';
        ini_set('max_execution_time', 300);
        $zip = new ZipArchive();
        if (true === $zip->open($archive_file_name, ZIPARCHIVE::CREATE)) {
            try {
                foreach ($oComment->getFiles() as $oFile) {
                    $file_src = $this->getParameter('web_dir').$oFile->getFileSrc();
                    if(file_exists($file_src)){
                        $zip->addFile($file_src, $oFile->getName());
                    }
                }
                if($zip->numFiles < 1){
                    return $this->redirect($request->headers->get('referer'));
                }
                $zip->close();
                header('Pragma: public');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: public');
                header('Content-Description: File Transfer');
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$archive_file_name.'"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: '.filesize($archive_file_name));
                ob_end_flush();
                @readfile($archive_file_name);
                unlink($archive_file_name);

                return $this->redirect($request->headers->get('referer'));
            }catch (\Exception $e) {
                $zip->close();
                unlink($archive_file_name);

                return $this->redirect($request->headers->get('referer'));
            }
        }
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for deletecomment
     *
     * @return If successful deleteed  comment, delete this comment (method jquery) on  the page  "comments to task item"
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oComment = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Comment')->find($request->get('id'));
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && 'TaskItem' == $oComment->getType()) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $oComment->setIsDeleted(1);
        $em->flush();

        return new Response(1);
    }
}
