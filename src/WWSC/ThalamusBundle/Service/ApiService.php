<?php

namespace WWSC\ThalamusBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class ApiService
{
    protected $container;
    protected $em;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
    }

    public function getModel($model)
    {
        switch ($model) {
            case 'project':
                $model = 'Project';
                break;
            case 'item':
                $model = 'TaskItem';
                break;
            default:
                $model = false;
        }

        return $model;
    }

    public function getRestApiConfig()
    {
        if (!$obj = $this->em->getRepository('WWSCThalamusBundle:Client')->getApiClient()) {
            return false;
        }

        return [
            'client_id' => $obj->getClientId(),
            'client_secret' => $obj->getSecret(),
        ];
    }

    public function saveTaskViaScreenshotTool($data)
    {
        $oUser = $this->container->get('security.context')->getToken()->getUser();
        if (!$data['taskList'] || !$oTaskList = $this->em->getRepository('WWSCThalamusBundle:Task')->find($data['taskList'])) {
            return ['code' => 404, 'data' => 'Task List is not found'];
        }
        if (!$oResponsible = $this->em->getRepository('WWSCThalamusBundle:User')->find($data['assign'])) {
            return ['code' => 404, 'data' => 'Responsible user is not found'];
        }
        $this->em->getConnection()->beginTransaction();
        if (!$data['title']) {
            return ['code' => 404, 'data' => 'Task title should not be blank.'];
        }
        if ('true' == $data['fastTrack']) {
            $fastTrack = 1;
        } else {
            $fastTrack = 0;
        }
        $oTask = new \WWSC\ThalamusBundle\Entity\TaskItem();
        $oTask->setDescription($data['title']);
        $oTask->setUserCreated($oUser);
        $oTask->setTask($oTaskList);
        $oTask->setFastTrack($fastTrack);
        $oTask->setState('READY_FOR_BRIEFING');
        $oTask->setStatus(0);
        $oTask->setResponsible($oResponsible);
        $this->em->persist($oTask);
        $this->em->flush();
        $idTask = $oTask->getId();
        if (!$idComment = $this->saveComment($data, $idTask)) {
            $this->em->getConnection()->rollback();

            return ['code' => 404, 'data' => 'Comment not  created, please try again.'];
        }
        $urlTask = $this->container->get('router')->generate(
                'wwsc_thalamus_project_task_item_comments', [
                'project' => $oTask->getTask()->getProject()->getSlug(),
                'task' => $oTask->getTask()->getId(),
                'id' => $idTask,
            ], true)."#c_{$idComment}";

        $returnData = [
            'url' => $urlTask,
            'id' => $idTask,
            'name' => $oTask->getDescription(),
        ];
        $this->em->getConnection()->commit();

        return ['code' => 200, 'data' => $returnData];
    }

    public function saveCommentViaScreenshotTool($data)
    {
        $this->em->getConnection()->beginTransaction();
        if (!$oTask = $this->em->getRepository('WWSCThalamusBundle:TaskItem')->find($data['task'])) {
            return ['code' => 404, 'data' => 'Item is not found'];
        }
        if (!$this->checkPermission('TaskItem', $oTask)) {
            return ['code' => 404, 'data' => "You don't have permissions. Access to this area is restricted"];
        }
        if ('true' == $data['fastTrack']) {
            $fastTrack = 1;
        } else {
            $fastTrack = 0;
        }
        //$oTask->setDescription($data["title"]);
        $oTask->setFastTrack($fastTrack);
        $this->em->flush();
        if (!$idComment = $this->saveComment($data, $oTask->getId())) {
            $this->em->getConnection()->rollback();

            return ['code' => 404, 'data' => 'Comment not  created, please try again.'];
        }
        $idTask = $oTask->getId();
        $urlTask = $this->container->get('router')->generate(
                'wwsc_thalamus_project_task_item_comments', [
                'project' => $oTask->getTask()->getProject()->getSlug(),
                'task' => $oTask->getTask()->getId(),
                'id' => $idTask,
            ], true)."#c_{$idComment}";

        $returnData = [
            'url' => $urlTask,
            'id' => $idTask,
            'name' => $oTask->getDescription(),
        ];

        $this->em->getConnection()->commit();

        return ['code' => 200, 'data' => $returnData];
    }

    public function saveComment($params, $taskId)
    {
        $oUser = $this->container->get('security.context')->getToken()->getUser();
        $oComment = new \WWSC\ThalamusBundle\Entity\Comment();
        $oComment->setDescription($params['description']);
        $oComment->setUserCreated($oUser);
        $oComment->setParentId($taskId);
        $oComment->setType('TaskItem');
        $this->em->persist($oComment);
        $this->em->flush();
        if (!$this->saveFile($params, $oComment->getId())) {
            return false;
        }

        return $oComment->getId();
    }

    public function saveFile($params, $commentId)
    {
        $error = false;
        $oUser = $this->container->get('security.context')->getToken()->getUser();
        $oProject = $this->em->getRepository('WWSCThalamusBundle:Project')->find($oUser->getProjectForScreenshotTool());
        $fileName = $commentId.'_'.substr(md5(uniqid(rand(), true)), 0, 15).'.png';
        $fileSrc = 'uploads/files/'.$fileName;
        $aFiles = array();
        if (!$this->base64_to_jpeg($params['image'], $fileSrc)) {
            $error = true;
        }
        $aFiles[$fileName] = [
            'original_name' => $fileName,
            'size' => filesize($fileSrc),
            'name' => $fileName,
        ];
        if (isset($params['annotations']) && $params['annotations']){
            $aFiles[$fileName]['annotations'] = $params['annotations'];
        }
        if (isset($params['attachments']) && is_array($params['attachments']) && count($params['attachments']) > 0) {
            foreach ($params['attachments'] as $aAttachment) {
                if (!isset($aAttachment['base64_data_encoded']) || !isset($aAttachment['name'])) {
                    $error = true;
                } else {
                    $fileName = $commentId.'_'.substr(md5(uniqid(rand(), true)), 0, 15).'.png';
                    $fileSrc = 'uploads/files/'.$fileName;
                    if (!$this->base64_to_jpeg($aAttachment['base64_data_encoded'], $fileSrc)) {
                        $error = true;
                    } else {
                        $aFiles[$fileName] = array('original_name' => $aAttachment['name'], 'size' => filesize($fileSrc), 'name' => $fileName);
                    }
                }
            }
        }
        if (!$error) {
            \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($aFiles, $commentId, $oProject, 'Comment');

            return true;
        }

        return false;
    }

    public function base64_to_jpeg($base64_string, $output_file)
    {
        try {
            $fp = fopen($output_file, 'wb');
            $data = explode(',', $base64_string);
            $data = base64_decode($data[1]);
            fwrite($fp, $data);
            fclose($fp);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getSubscribers($model, $obj)
    {
        $aSubspeoples = [];
        switch ($model) {
            case 'Project':
                $aSubspeoples = $obj->getSubspeople();
                break;
            case 'Task':
                $aComSubspeoples = $obj->getProject()->getSubspeople();
                $i = 0;
                foreach ($aComSubspeoples as $aComp) {
                    if ('ROLE_PROVIDER' == $aComp['role'] || (1 == $obj->getVisibleClient() && 'ROLE_CLIENT' == $aComp['role'])
                        || (1 == $obj->getVisibleFreelancer() && 'ROLE_FREELANCER' == $aComp['role'])
                    ) {
                        foreach ($aComp['people'] as $key => $people) {
                            $aSubspeoples[$i]['id'] = $key;
                            $aSubspeoples[$i]['name'] = $people;
                            ++$i;
                        }
                    }
                }
                break;
        }

        return $aSubspeoples;
    }

    public function checkPermission($model, $obj)
    {
        $oUser = $this->container->get('security.context')->getToken()->getUser();
        switch ($model) {
            case 'Project':
                return $oUser->getHasRoleProject($obj->getSlug());
                break;
            case 'TaskItem':
                if ($oUser->getHasRoleProject($obj->getTask()->getProject()->getSlug())) {
                    if (!(($this->container->get('security.context')->isGranted('ROLE_PROVIDER')) ||
                        ($obj->getTask()->getVisibleClient() && $this->container->get('security.context')->isGranted('ROLE_CLIENT')) ||
                        ($obj->getTask()->getVisibleFreelancer() && $this->container->get('security.context')->isGranted('ROLE_FREELANCER')))
                    ) {
                        return false;
                    } else {
                        return true;
                    }
                }
                break;
            default:
                return false;
        }
    }

    public function getRestTokenAfterAuthorization($oUser)
    {
        if (!$params = $this->getRestApiConfig()) {
            return false;
        }

        $grantRequest = new Request(array(
            'client_id' => $params['client_id'],
            'client_secret' => $params['client_secret'],
            'grant_type' => 'https://thalamus.io/api/v1/login',
            'username' => $oUser->getUsername(),
            'password' => $oUser->getPassword(),
        ));

        try {
            $tokenResponse = $this->container->get('fos_oauth_server.server')->grantAccessToken($grantRequest);
            $result = json_decode($tokenResponse->getContent(), true);
        }catch (\Exception $e) {
            return false;
        }
        if (!isset($result['access_token'])) {
            return false;
        }

        return $result['access_token'];
    }
}