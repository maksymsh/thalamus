<?php

namespace WWSC\ThalamusBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskAPIController.
 */
class TaskAPIController extends BaseRestController
{
    /**
     * Get a list tasks.
     *
     * @Rest\Get("/taskList/{id}/tasks")
     * @Rest\View()
     * @ApiDoc(
     *     section="Task List",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getTasksAction($id)
    {
        if(!$oTask = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Task')->find($id)){
            return $this->baseSerialize('Task is not found', 404);
        }

        return $this->baseSerialize( $oTask->getTaskItem(0, false, false,  false, false, 1000));
    }

    /**
     * Get a single task.
     *
     * @param int $id
     *
     * @return array
     *
     * @Rest\Get("tasks/{id}")
     * @Rest\View()
     * @ApiDoc(
     *     section="Task",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getTaskAction($id)
    {
        if (is_null($oTaskItem = $this->getRepository('WWSCThalamusBundle:TaskItem')->find($id))) {
            return $this->baseSerialize('Item is not found', 404);
        }

        if (!$this->get('service.api')->checkPermission('TaskItem', $oTaskItem)) {
            return $this->baseSerialize("You don't have permissions. Access to this area is restricted", 403);
        }

        return $this->baseSerialize($oTaskItem->getInfoViaAPI());
    }

    /**
     * Get last added task.
     *
     * @return array
     *
     * @Rest\Get("/last-added-task")
     * @Rest\View()
     * @ApiDoc(
     *     section="Task",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getLastAddedTaskAction()
    {
        return $this->baseSerialize($this->getUser()->getLastTask());
    }

    /**
     * Save task via screenshot tool.
     *
     * @return array
     *
     * @Rest\Post("/save-task-via-screenshot-tool")
     * @Rest\View()
     * @ApiDoc(
     *     section="Screenshot Tool",
     *     input={"class"="WWSC\ThalamusBundle\Form\API\TaskAPIForm", "name"=""},
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function saveTaskViaScreenshotToolAction(Request $request)
    {
        if(!$this->getUser()->getProjectForScreenshotTool() || !$oProject = $this->getRepository('WWSCThalamusBundle:Project')->find($this->getUser()->getProjectForScreenshotTool())){
            return $this->baseSerialize(['data' => 'Project is not found'], 404);
        }
        $form = $this->handleForm($request, new \WWSC\ThalamusBundle\Form\API\TaskAPIForm());
        if(isset($form['errors'])) {
            return $this->baseSerialize($form, 404);
        }
        $form['taskList'] = $oProject->getPostTaskViaEmail();
        $form['assign'] = $oProject->getProjectleader('id');
        if ($attachments = $request->get('attachments')) {
            $form['attachments'] = json_decode($request->get('attachments'), true);
        }
        $result = $this->get('service.api')->saveTaskViaScreenshotTool($form);

        return $this->baseSerialize($result['data'], $result['code']);
    }
}
