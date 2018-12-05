<?php

namespace WWSC\ThalamusBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ProjectAPIController.
 */
class ProjectAPIController extends BaseRestController
{
    /**
     * Get a single project.
     *
     * @param int $id
     *
     * @return array
     *
     * @Rest\Get("projects/{id}")
     * @Rest\View()
     * @ApiDoc(
     *     section="Project",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getProjectAction($id)
    {
        if (is_null($oProject = $this->getRepository('WWSCThalamusBundle:Project')->find($id))) {
            return $this->baseSerialize('Project is not found', 404);
        }

        if (!$this->get('service.api')->checkPermission('Project', $oProject)) {
            return $this->baseSerialize("You don't have permissions. Access to this area is restricted", 403);
        }

        return $this->baseSerialize($oProject->getInfoViaAPI());
    }

    /**
     * Get  list projects.
     *
     * @return array
     *
     * @Rest\Get("projects")
     * @Rest\View()
     * @ApiDoc(
     *     section="Project",
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function getProjectsAction()
    {
        $aProjects = $this->getUser()->getProjectsForAccount(false, false, true);

        return $this->baseSerialize($aProjects);
        //return $this->baseSerialize(call_user_func_array("array_merge",$aProjects));
    }
}
