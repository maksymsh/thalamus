<?php

namespace WWSC\ThalamusBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class APIController.
 */
class TaskListAPIController extends BaseRestController
{
    /**
     * Get  task lists.
     *
     * @return array
     *
     * @Rest\Get("/tasklists")
     * @Rest\View()
     * @ApiDoc(
     *     section="Task List",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getTaskListsAction()
    {
        if(!$projectId = $this->getUser()->getProjectForScreenshotTool()){
            return $this->baseSerialize("Project for screenshot Tool is not selected, you can select this project in section 'my info'.", 404);
        }
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->find($projectId);
        $aTasks = array();
        foreach($oProject->getTasks() as $key => $oTask){
            $aTasks[$key]['id'] = $oTask->getId();
            $aTasks[$key]['name'] = $oTask->getName();
        }

        return $this->baseSerialize($aTasks);
    }

    /**
     * Get subscribers of task.
     *
     * @param int $id
     *
     * @return array
     *
     * @Rest\Get("/tasklists/{id}/subscribers")
     * @Rest\View()
     * @ApiDoc(
     *     section="Task List",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getSubscribersAction($id)
    {
        if(!$oTask = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Task')->find($id)){
            return $this->baseSerialize('Task is not found', 404);
        }

        return $this->baseSerialize($this->get('service.api')->getSubscribers('Task', $oTask));
    }
}
