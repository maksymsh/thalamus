<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\Form\TaskForm;

/**
 * Task controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display task.
 */
class TaskController extends Controller
{
    /**
     *  Method myTodos.
     *
     *  This method is responsible for display tasks and persons on  the page "My To dos"
     */
    public function myTodosAction(Request $request)
    {
        $this->getRequest()->getSession()->set('active_module', 'my-todos');
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($request->getSession()->get('account')->id);
        $aFilter = array(
            'filter_responsible' => 'u_' . $this->getUser()->getId(),
            'filter_due' => '',
            'hide_close_task' => true,
        );

        return $this->render('WWSCThalamusBundle:Task:my-todos.html.twig', array(
            'aFilter' => $aFilter,
            'taskItemStates' => TaskItem::$states,
            'oAccount' => $oAccount,
        ));
    }

    /**
     *  Method list.
     *
     *  This method is responsible for display tasks and persons on  the page "To-dos"
     */
    public function listAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $request->getSession()->set('active_module', 'todos');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if (0 == count($oProject->getTasks())) {
                return $this->render('WWSCThalamusBundle:Task:empty-todos.html.twig', array('oProject' => $oProject));
            }
            if ('reorder' == $request->get('action')) {
                if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
                    return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
                }
                $template = 'reorder-list.html.twig';

                return $this->render('WWSCThalamusBundle:Task:reorder-list.html.twig', array(
                    'aTasks' => $oProject->getTasks(),
                    'oProject' => $oProject,
                    'taskItemStates' => TaskItem::$states,
                ));
            }
            if ($request->get('filter_tasks')) {
                $request->getSession()->set('aFilterTask', $request->get('filter_tasks'));
            }

            $fFilterTask = $this->createForm(new \WWSC\ThalamusBundle\Form\FilterTaskForm());
            $fFilterTask->submit($request->getSession()->get('aFilterTask'));

            return $this->render('WWSCThalamusBundle:Task:list.html.twig', array(
                'fFilterTask' => $fFilterTask->createView(),
                'aFilter' => $request->getSession()->get('aFilterTask'),
                'oProject' => $oProject,
                'taskItemStates' => TaskItem::$states,
            ));
        }
    }

    public function searchByIdAction(Request $request)
    {
        if ($oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('search-task-id'))) {
            return $this->redirect($this->generateUrl('wwsc_thalamus_project_task_item_comments', array(
                'project' => $oTaskItem->getTask()->getProject()->getSlug(),
                'task' => $oTaskItem->getTask()->getId(),
                'id' => $oTaskItem->getId(),
            )));
        }

        return $this->render('WWSCThalamusBundle:Other:not-found.html.twig');
    }

    public function getClosedTaskItemsAction(Request $request)
    {
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('id'));
        $aTaskItems = $oTask->getTaskItem(false, 1, $request->get('offset'), 10);

        return $this->render('WWSCThalamusBundle:Task:show-closed-task-items.html.twig', array(
            'aTaskItems' => isset($aTaskItems['CLOSED']) ? $aTaskItems['CLOSED'] : array(),
            'taskId' => $oTask->getId(),
            'projectSlug' => $oProject->getSlug(),
        ));
    }

    /**
     *  Method show.
     *
     *  This method is responsible for display current task.
     */
    public function showAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('id'));
            if (!($this->container->get('security.context')->isGranted('ROLE_PROVIDER') || ($this->container->get('security.context')->isGranted('ROLE_CLIENT') && 1 == $oTask->getVisibleClient()) || ($this->container->get('security.context')->isGranted('ROLE_FREELANCER') && 1 == $oTask->getVisibleFreelancer()))) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $this->getRequest()->getSession()->set('active_module', 'todos');
            $fFilterTask = $this->createForm(new \WWSC\ThalamusBundle\Form\FilterTaskForm());
            if ($request->get('filter_tasks')) {
                $request->getSession()->set('aFilterTask', $request->get('filter_tasks'));
            }
            $fFilterTask->bind($request->getSession()->get('aFilterTask'));
            $aTask = array(
                'info' => $oTask->getInfo(),
                'taskitems' => $oTask->getTaskItem($request->getSession()->get('aFilterTask')),
            );

            return $this->render('WWSCThalamusBundle:Task:show.html.twig', array(
                'projectSlug' => $oProject->getSlug(),
                'projectName' => $oProject->getName(),
                'subspeople' => $oProject->getSubspeople(),
                'aTask' => $aTask,
                'aTaskListSelect' => $oProject->getTaskList(),
                'aFilter' => $request->getSession()->get('aFilterTask'),
                'fFilterTask' => $fFilterTask->createView(),)
            );
        }
    }

    /**
     *  Method add.
     *
     *  This method is responsible for create new task
     */
    public function addAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $this->getRequest()->getSession()->set('active_module', 'todos');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $fTask = $this->createForm(new TaskForm());
            if ('POST' == $request->getMethod()) {
                $fTask->bind($request);
                if ($fTask->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fTask = $fTask->getData();
                    $fTask->setProject($oProject);
                    $em->persist($fTask);
                    $em->flush();

                    return $this->redirect($this->generateUrl('wwsc_thalamus_project_task_show', array('project' => $request->get('project'), 'id' => $fTask->getId())));
                }
            }

            return $this->render('WWSCThalamusBundle:Task:add.html.twig', array('form' => $fTask->createView(), 'nameProject' => $oProject->getName(), 'slugProject' => $request->get('project')));
        }
    }

    /**
     *  Method edit.
     *
     *  This method is responsible  for edit task
     */
    public function editAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('id'));
        $fTask = $this->createForm(new TaskForm(), $oTask);
        if ('POST' == $request->getMethod()) {
            $fTask->bind($request);
            if ($fTask->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fTask = $fTask->getData();
                $em->persist($fTask);
                $em->flush();

                return new JsonResponse(array('htmlTask' => $this->renderView('WWSCThalamusBundle:Task:task-info.html.twig', array('projectSlug' => $oTask->getProject()->getSlug(),
                    'aTask' => array(
                        'id' => $fTask->getId(),
                        'name' => $fTask->getName(),
                        'visible_client' => $fTask->getVisibleClient(),
                        'visible_freelancer' => $fTask->getVisibleFreelancer(),
                        'description' => $fTask->getDescription(),
                    ),
                ))));
            }
        }

        return new JsonResponse(array('htmlTaskForm' => $this->renderView('WWSCThalamusBundle:Task:edit.html.twig', array('form' => $fTask->createView(), 'oTask' => $oTask))));
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for delete task
     */
    public function deleteAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('id'));
        $oTask->setIsDeleted(1);
        $em->flush();
        if ('GET' == $request->getMethod()) {
            return $this->redirect($this->generateUrl('wwsc_thalamus_project_todos', array('project' => $request->get('project'))));
        }

        return new Response(1);
    }
}
