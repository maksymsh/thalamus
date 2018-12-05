<?php

namespace WWSC\ThalamusBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommentFormType.
 */
class CommentAPIController extends BaseRestController
{
    /**
     * Save comment via screenshot tool.
     *
     * @return array
     *
     * @Rest\Post("/save-comment-via-screenshot-tool")
     * @Rest\View()
     * @ApiDoc(
     *     section="Screenshot Tool",
     *     input={"class"="WWSC\ThalamusBundle\Form\API\CommentAPIForm", "name"=""},
     *     headers={
     *       {"name"="authorization", "description"="Bearer {api-key}", "required"="true"}
     *     }
     * )
     */
    public function saveCommentViaScreenshotToolAction(Request $request)
    {
        if(!$oProject = $this->getRepository('WWSCThalamusBundle:Project')->find($this->getUser()->getProjectForScreenshotTool())){
            return ['code' => 404, 'data' => 'Project is not found'];
        }
        $form = $this->handleForm($request, new \WWSC\ThalamusBundle\Form\API\CommentAPIForm());
        if(isset($form['errors'])) {
            return $this->baseSerialize($form, 404);
        }
        $form['assign'] = $oProject->getProjectleader('id');
        if ($attachments = $request->get('attachments')) {
            $form['attachments'] = json_decode($request->get('attachments'), true);
        }
        $result = $this->get('service.api')->saveCommentViaScreenshotTool($form);

        return $this->baseSerialize($result['data'], $result['code']);
    }
}
