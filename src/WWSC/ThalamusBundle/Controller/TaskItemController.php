<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Task;
use WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\Form\TaskItemForm;

/**
 * Task Item controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display item for task.
 */
class TaskItemController extends Controller
{
    /**
     *  Method add.
     *
     *  This method is responsible for create new item  for task.
     */
    public function addAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->container->get('security.context')->isGranted('ROLE_CLIENT')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('task'));
        $aRecurringTaskList = \WWSC\ThalamusBundle\Entity\TaskItem::getArrayRecurringTaskList($oTask->getProject()->getId(), $oTask->getId());
        $fTaskItem = $this->createForm(new TaskItemForm($oTask->getProject()->getUsers(), $aRecurringTaskList));
        if ('POST' == $request->getMethod()) {
            $fTaskItem->bind($request);
            if ($fTaskItem->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fTaskItem = $fTaskItem->getData();
                $fTaskItem = $fTaskItem->setTask($oTask);
                $em->persist($fTaskItem);
                if ($oTask->getRecursive()) {
                    $fTaskItem = $fTaskItem->setRecursive(1);
                    $fTaskItem->setDaysWeeklyOfRecursion($request->get('days_weekly_of_recursion'));
                }
                $em->flush();
                if ($oTask->getRecursive()) {
                    if ($aSubspeople = $request->get('aSubspeople')) {
                        \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $fTaskItem->getId(), 'TaskItem');
                    }
                } else {
                    if ($fTaskItem->getResponsible()->getId()) {
                        $responsibleId = $fTaskItem->getResponsible()->getId();
                        $userId = $this->getUser()->getId();

                        $aSubspeople = array();
                        $aSubspeople[$responsibleId] = "{$responsibleId}";

                        if ($responsibleId != $userId) {
                            $aSubspeople[$userId] = "{$userId}";
                        }

                        \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $fTaskItem->getId(), 'TaskItem');
                    }
                }

                if ((!$fTaskItem->getResponsible() || 'ROLE_PROVIDER' != $fTaskItem->getResponsible()->getCompany()->getRoles())
                    && 'ROLE_CLIENT' == $this->getUser()->getCompany()->getRoles()
                ) {
                    $this->sendMailAboutCreateNewTask($fTaskItem, 'new_task_created');
                }

                if ($this->getUser()->getId() != $fTaskItem->getResponsible()->getId()) {
                    $this->sendMailAboutCreateNewTask($fTaskItem);
                }

                $data = array(
                    'projectSlug' => $oTask->getProject()->getSlug(),
                    'taskId' => $oTask->getId(),
                    'aItem' => $fTaskItem->getInfo(),
                    'status' => 0,
                );

                return new JsonResponse(array('fastTrack' => $fTaskItem->getFastTrack(), 'aDaysWeekly' => TaskItem::$aDaysWeekly, 'htmlItem' => $this->renderView('WWSCThalamusBundle:TaskItem:item-show.html.twig', $data)));
            } else {
                return new JsonResponse(array('error' => 'incorrect data'));
            }
        }

        return new JsonResponse(array('htmlItemForm' => $this->renderView('WWSCThalamusBundle:TaskItem:add.html.twig', array('form' => $fTaskItem->createView(), 'oTask' => $oTask, 'aDaysWeekly' => TaskItem::$aDaysWeekly))));
    }

    /**
     *  Method edit.
     *
     *  This method is responsible for edit item  for task.
     */
    public function editAction(Request $request)
    {
        $oItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));
        $responsibleTask = $oItem->getResponsible()->getId();
        $aRecurringTaskList = \WWSC\ThalamusBundle\Entity\TaskItem::getArrayRecurringTaskList($oItem->getTask()->getProject()->getId(), $oItem->getTask()->getId());
        $fTaskItem = $this->createForm(new TaskItemForm($oItem->getTask()->getProject()->getUsers(), $aRecurringTaskList), $oItem);
        $layout = 'todos';
        if ($request->get('layout')) {
            $layout = $request->get('layout');
        }
        if ('POST' == $request->getMethod()) {
            $fTaskItem->bind($request);
            if ($fTaskItem->isValid()) {
                $fTaskItem = $fTaskItem->getData();
                $em = $this->getDoctrine()->getManager();
                if ($oItem->getTask()->getRecursive()) {
                    $fTaskItem->setDaysWeeklyOfRecursion($request->get('days_weekly_of_recursion'));
                }
                $em->persist($fTaskItem);
                $em->flush();
                if ($responsibleTask != $fTaskItem->getResponsible()->getId()) {
                    $this->sendMailAboutCreateNewTask($fTaskItem);
                }
                if ($oItem->getTask()->getRecursive()) {
                    if ($oItem->getActiveSubscribed() != $request->get('aSubspeople')) {
                        \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($request->get('aSubspeople'), $oItem->getId(), 'TaskItem');
                    }
                }
                $aSubspeople = $oItem->getActiveSubscribed();
                if ($aSubspeople && !array_key_exists($oItem->getResponsible()->getId(), $aSubspeople)) {
                    $aSubspeople[$oItem->getResponsible()->getId()] = "{$oItem->getResponsible()->getId()}";
                    \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $oItem->getId(), 'TaskItem');
                }
                if ('comment' == $layout) {
                    return $this->render('WWSCThalamusBundle:TaskItem:comment-header-task-info.html.twig', array('oItem' => $oItem));
                }
                $data = array(
                    'projectSlug' => $oItem->getTask()->getProject()->getSlug(),
                    'taskId' => $oItem->getTask()->getId(),
                    'aDaysWeekly' => TaskItem::$aDaysWeekly,
                    'aItem' => $oItem->getInfo(),
                    'status' => $fTaskItem->getStatus(),
                );

                return $this->render('WWSCThalamusBundle:TaskItem:item-show.html.twig', $data);
            }
            $errors = $fTaskItem->getErrors();
            $output = array();
            $output['error'] = $errors[0]->getMessage();

            return new JsonResponse($output);
        }

        return new JsonResponse(array(
            'htmlItemForm' => $this->renderView('WWSCThalamusBundle:TaskItem:edit.html.twig',
                array(
                    'form' => $fTaskItem->createView(),
                    'aDaysWeekly' => TaskItem::$aDaysWeekly,
                    'oItem' => $oItem,
                    'layout' => $layout,
                )),
        ));
    }

    /**
     *  Method change status.
     *
     *  This method is responsible for change status for item task.
     */
    public function changeStatusAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));
        if (1 == $request->get('status')) {
            $this->closingTask($request->get('id'));
            $status = 1;
        } else {
            $oTaskItem->setStatus($request->get('status'), false);
            $oTaskItem->setSortNewElem();
            if ('CLOSED' == $oTaskItem->getState()) {
                $oTaskItem->setState('IN_PROGRESS');
            }
            $em->flush();
            $status = 0;
        }
        $data = array(
            'projectSlug' => $oTaskItem->getTask()->getProject()->getSlug(),
            'taskId' => $oTaskItem->getTask()->getId(),
            'aDaysWeekly' => TaskItem::$aDaysWeekly,
            'aItem' => $oTaskItem->getInfo(),
            'status' => $status,
        );

        return $this->render('WWSCThalamusBundle:TaskItem:item-show.html.twig', $data);
    }

    public function closingTaskViaMailAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->closingTask($request->get('id'));

        return $this->redirect($this->generateUrl('wwsc_thalamus_project_task_item_comments', array(
            'id' => $request->get('id'),
            'task' => $request->get('task'),
            'project' => $request->get('project'),
        ), true));
    }

    public function closingTask($idTask)
    {
        $em = $this->getDoctrine()->getManager();
        $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($idTask);
        $oTaskItem->setStatus(1, false);
        $oTaskItem->setSort(0);
        $oTaskItem->setState('CLOSED', false);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $message = 'Task was closed by ' . $this->getUser()->getFirstName() . ' ' . $this->getUser()->getLastName();
        $oComment = new \WWSC\ThalamusBundle\Entity\Comment();
        $oComment->setDescription($message);
        $oComment->setUserCreated($this->getUser());
        $oComment->setParentId($oTaskItem->getId());
        $oComment->setType('TaskItem');
        $em->persist($oComment);
        $em->flush();

        \WWSC\ThalamusBundle\Entity\SubscribeEmail::sendSubscribeEmail($oComment, 'TaskItem', false, false);
    }

    /**
     *  Method comments for task item.
     *
     *  This method is responsible for display comments for item task.
     */
    public function commentsAction(Request $request)
    {
        $projectSlug = $request->get('project');
        if (!$this->getUser()->getHasRoleProject($projectSlug)) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'todos');
        /**
         * @var TaskItem $oItem
         */
        $oItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));
        if($oItem instanceof TaskItem){
            if (!(($this->container->get('security.context')->isGranted('ROLE_PROVIDER')) ||
                ($oItem->getTask()->getVisibleClient() && $this->container->get('security.context')->isGranted('ROLE_CLIENT')) ||
                ($oItem->getTask()->getVisibleFreelancer() && $this->container->get('security.context')->isGranted('ROLE_FREELANCER')))
            ) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }

            $oItem->saveLastVisitToTask();
            $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')
                ->findOneBy(array('slug' => $projectSlug));
            $comments = $oItem->getComments();

            return $this->render('WWSCThalamusBundle:TaskItem:comments.html.twig', array(
                    'oItem' => $oItem,
                    'googleDriveFolderId' => $oProject->getGoogleDriveFolderId(),)
            );
        } else {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
    }

    public function selectedRelationsTaskAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('item'));
        if ('POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();
            $oChildTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('child-task'));
            $oChildTask->setParent($oItem->getId());
            $em->flush();

            return new JsonResponse(array('status' => 'true', 'html' => $this->renderView('WWSCThalamusBundle:TaskItem:relations-task.html.twig', array('oItem' => $oItem))));
        }

        return new JsonResponse(array('html' => $this->renderView('WWSCThalamusBundle:TaskItem:selected-relations-task.html.twig', array('oItem' => $oItem))));
    }

    public function taskResponsibleAction(Request $request)
    {
        if ($oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('id'))) {
            return new JsonResponse(array('html' => $this->renderView('WWSCThalamusBundle:TaskItem:task-item-responsible.html.twig', array('oTask' => $oTask))));
        }
    }

    /**
     *  Method comments for task item.
     *
     *  This method is responsible for display comments for item task.
     */
    public function formAddChildAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('item'));
        $aRecurringTaskList = \WWSC\ThalamusBundle\Entity\TaskItem::getArrayRecurringTaskList($oItem->getTask()->getProject()->getId(), $oItem->getTask()->getId());
        $fTaskItem = $this->createForm(new TaskItemForm($oItem->getTask()->getProject()->getUsers(), $aRecurringTaskList));
        if ('POST' == $request->getMethod()) {
            $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('task-list-id'));
            $fTaskItem->bind($request);
            if ($fTaskItem->isValid()) {
                $em = $this->getDoctrine()->getManager();
                /**
                 * @var TaskItem $fTaskItem
                 */
                $fTaskItem = $fTaskItem->getData();
                $fTaskItem->setParent($oItem->getId());
                $fTaskItem->setTask($oTask);

                $em->persist($fTaskItem);
                if ($oTask->getRecursive()) {
                    $fTaskItem = $fTaskItem->setRecursive(1);
                }
                $em->flush();

                $responsibleId = $fTaskItem->getResponsible()->getId();
                $userId = $this->getUser()->getId();

                $aSubspeople[$responsibleId] = "{$responsibleId}";

                if ($responsibleId != $userId) {
                    $aSubspeople[$userId] = "{$userId}";
                }

                \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $fTaskItem->getId(), 'TaskItem');

                return new JsonResponse(array('status' => 'true', 'html' => $this->renderView('WWSCThalamusBundle:TaskItem:relations-task.html.twig', array('oItem' => $oItem))));
            } else {
                return new JsonResponse(array('error' => 'incorrect data'));
            }
        }

        return new JsonResponse(array('htmlItemForm' => $this->renderView('WWSCThalamusBundle:TaskItem:add-relations-task.html.twig', array('form' => $fTaskItem->createView(), 'oItem' => $oItem))));
    }

    public function deleteRelationTaskAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($request->get('id')) {
            $em = $this->getDoctrine()->getManager();
            $oItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));
            $oItem->setParent(NULL);
            $em->flush();

            return new JsonResponse(array('status' => true));
        }
    }

    /**
     *  Method Reported Hours for task item.
     *
     *  This method is responsible for display sum reported hours task item
     */
    public function getReportedHoursAction(Request $request)
    {
        $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));

        return new Response($oTaskItem->getSumHoursTimeTracker());
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for delete item task
     */
    public function deleteAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('id'));
        $oTaskItem->setIsDeleted(1);
        $em->flush();

        return new Response(1);
    }

    public function sendMailAboutCreateNewTask($oTask, $template = 'task_assigned_user')
    {
        if ('new_task_created' == $template) {
            $subject = 'NEW TASK CREATED ' . '#' . $oTask->getId() . ' ' . $oTask->getDescription();
            $email = $oTask->getTask()->getProject()->getProjectleader()->getEmail();
            $data = array('oElement' => $oTask);
            $langTemplate = $oTask->getTask()->getProject()->getProjectleader()->getLanguageCode();
        } else {
            $subject = '[' . $oTask->getTask()->getProject()->getName() . '] Notification Email: ' . $oTask->getDescription();
            $email = $oTask->getResponsible()->getEmail();
            $data = array('oElement' => $oTask, 'roleUser' => $oTask->getResponsible()->getCompany()->getRoles());
            $langTemplate = $oTask->getResponsible()->getLanguageCode();
        }

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->container->getParameter('admin_email'))
            ->setReplyTo(
                $oTask->getReplyUID()
                . '@' . $this->container->getParameter('auto_reply_email_domain')
            )
            ->setContentType('text/html')
            ->setTo($email)
            ->setBody($this->renderView('WWSCThalamusBundle:Mail:' . $langTemplate . '/' . $template . '.txt.twig', $data));
        $this->container->get('mailer')->send($message);
    }

    public function shortTaskLinkAction(Request $request)
    {
        $taskId = str_replace('#', '', $request->get('task'));
        if ($oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('task'))) {
            return $this->redirect($this->generateUrl('wwsc_thalamus_project_task_item_comments', array(
                'id' => $oTaskItem->getId(),
                'task' => $oTaskItem->getTask()->getId(),
                'project' => $oTaskItem->getTask()->getProject()->getSlug(),
            ), true));
        }
    }

    public function showShortInfoTaskAction(Request $request)
    {
        if ($oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('task'))) {
            $status = $oTaskItem->getState() ? $oTaskItem->getStateValue() . ' - ' : '';
            if (!$this->getUser()->getHasRoleProject($oTaskItem->getTask()->getProject()->getSlug())) {
                return new JsonResponse(array('infoTask' => 'Access to this area is restricted'));
            }
            if (!(($this->container->get('security.context')->isGranted('ROLE_PROVIDER')) ||
                ($oTaskItem->getTask()->getVisibleClient() && $this->container->get('security.context')->isGranted('ROLE_CLIENT')) ||
                ($oTaskItem->getTask()->getVisibleFreelancer() && $this->container->get('security.context')->isGranted('ROLE_FREELANCER')))
            ) {
                return new JsonResponse(array('infoTask' => 'Access to this area is restricted'));
            }

            return new JsonResponse(array(
                'infoTask' => $oTaskItem->getDescription() . ' | ' . $status . $oTaskItem->getResponsible()->getFirstName() . ' ' . $oTaskItem->getResponsible()->getLastName(),
            ));
        }

        return new JsonResponse(false);
    }

    public function getGoogleClient($code = false)
    {
        $client = new \Google_Client();
        $client->setClientId($this->container->getParameter('google_client_id'));
        $client->setClientSecret($this->container->getParameter('google_client_secret'));
        $client->setRedirectUri($this->getRequest()->getSchemeAndHttpHost() . '/create-google-drive-folder');
        $client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://docs.google.com/feeds/', 'https://www.googleapis.com/auth/spreadsheets'));
        $client->setAccessType('offline');
        if ($code) {
            $accessToken = $client->fetchAccessTokenWithAuthCode($code);
            $client->setAccessToken($accessToken);

            return $client;
        }
        $authUrl = $client->createAuthUrl();

        return $this->redirect($authUrl);
    }

    public function createGoogleDriveFolderAction(Request $request)
    {
        if ($request->get('code')) {
            $client = $this->getGoogleClient($request->get('code'));
            $driveService = new \Google_Service_Drive($client);

            $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')
                ->findOneBy(['id' => $request->getSession()->get('item_id_google')]);
            $oProject = $oTaskItem->getTask()->getProject();

            try {
                $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                        'name' => '#' . $oTaskItem->getId() . ' - ' . $oTaskItem->getDescription(),
                        'mimeType' => 'application/vnd.google-apps.folder',
                        'parents' => [$oProject->getGoogleDriveFolderId()],)
                );

                $file = $driveService->files->create($fileMetadata, array(
                    'fields' => 'id',));

                $oTaskItem->setGoogleDriveItemFolderId($file->getId());
                $em = $this->getDoctrine()->getManager();
                $em->persist($oTaskItem);
                $em->flush();
            } catch (\Exception $e) {
                $request->getSession()->getFlashBag()
                    ->add('notice',
                        $this->get('translator')->trans('Google drive folder has not been created. Please check Project Folder ID or choose another Google account.')
                    );
                $request->getSession()->getFlashBag()->add('status', 'error');
            }

            return $this->redirectToRoute('wwsc_thalamus_project_task_item_comments',
                [
                    'project' => $oProject->getSlug(),
                    'task' => $oTaskItem->getTask()->getId(),
                    'id' => $oTaskItem->getId(),
                ]
            );
        } else {
            if ($request->get('item')) {
                $request->getSession()->set('item_id_google', $request->get('item'));

                return $this->getGoogleClient();
            } else {
                $request->getSession()->getFlashBag()
                    ->add('notice',
                        $this->get('translator')->trans('Google drive folder has not been created, please try again')
                    );
                $request->getSession()->getFlashBag()->add('status', 'error');

                return $this->redirect($request->headers->get('referer'));
            }
        }
    }
}
