<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WWSC\ThalamusBundle\Entity\Comment;
use WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\Entity\Files;

/**
 * Project controler.
 *
 * In this controller describes the functions of adding, editing, deleting and display project,
 * and display pages Overview, Messages, To-Dos, Calendar, Writeboards, Files for project.
 */
class APIController extends Controller
{
    public function indexAction(Request $request)
    {
        header('Access-Control-Allow-Origin: *');

        $params = array();
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true);
        }
        if('getLastAddedTask' == $request->get('method')){
            $params = array('login' => $request->get('login'), 'password' => $request->get('password'));
        }

        if(!$this->checkAuthorizationUser($request, $params)){
            return new JsonResponse(array('status' => false, 'message' => 'Bad credentials'));
        }
        $method = $request->get('method');
        if('login' == $method){
            return new JsonResponse(array('status' => true));
        }
        if(!method_exists($this, $method)){
            return new JsonResponse(array('status' => false, 'message' => 'method not found'));
        }

        return new JsonResponse ($this->$method($params));
    }

    public function getAccounts($params)
    {
        $aAccounts = array();
        foreach($this->getUser()->getCompanies() as $key => $oCompany){
            $aAccounts[$key]['id'] = $oCompany->getAccount()->getId();
            $aAccounts[$key]['name'] = $oCompany->getAccount()->getName();
        }

        return array('status' => true,  'data' => $aAccounts);
    }

    public function getProjects($params)
    {
        $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($params['account']);
        if(!$aProjects = $oAccount->getProjects('API')){
            return array('status' => false, 'message' => 'no projects found');
        }

        return array('status' => true, 'data' => $aProjects);
    }

    public function getTaskList($params)
    {
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->find($params['project']);
        if(!$critTask = $oProject->getTasks()){
            return array('status' => false, 'message' => 'In this project did not match any tasks of list');
        }
        $aTasks = array();
        foreach($critTask as $key => $oTask){
            $aTasks[$key]['id'] = $oTask->getId();
            $aTasks[$key]['name'] = $oTask->getName();
        }

        return array('status' => true, 'data' => $aTasks);
    }

    public function getTasks($params)
    {
        $oTask = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Task')->find($params['taskList']);

        if(!$critTask = $oTask->getTaskItem(0, false, false,  false, false, 1000)){
            return new JsonResponse(array('status' => false, 'message' => 'In this tasks of list did not match any tasks'));
        }
        $aTasks = array();
        foreach($critTask as $key => $oTaskItem){
            $aTasks[$key]['id'] = $oTaskItem->getId();
            $aTasks[$key]['name'] = $oTaskItem->getDescription();
        }

        return array('status' => true, 'data' => $aTasks);
    }

    public function getSubscribers($params)
    {
        $oTask = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Task')->find($params['taskList']);
        $aComSubspeoples = $oTask->getProject()->getSubspeople();
        $aSubspeoples = array();
        $i = 0;
        foreach ($aComSubspeoples as $aComp){
            if ('ROLE_PROVIDER' == $aComp['role'] || (1 == $oTask->getVisibleClient() && 'ROLE_CLIENT' == $aComp['role'])
                || (1 == $oTask->getVisibleFreelancer() && 'ROLE_FREELANCER' == $aComp['role'])){
                foreach ($aComp['people'] as $key => $people){
                    $aSubspeoples[$i]['id'] = $key;
                    $aSubspeoples[$i]['name'] = $people;
                    ++$i;
                }
                //$aSubspeoples = $aSubspeoples + $aComp["people"];
            }
        }

        return array('status' => true, 'data' => $aSubspeoples);
    }

    public function saveTask($params)
    {
        $aErrors = array();
        $aNumberField = array('account', 'project', 'taskList', 'assign');
        foreach ($params as $param => $val){
            if(!in_array($param, array('title', 'task', 'fastTrack', 'attachments')) || ('comment' == $params['type'] && 'title' != $param) && ('task' == $params['type'] && 'task' != $param ) ){
                if(('' == trim($val))){
                    $aErrors[] = 'Indicated incorrect  value  '.$param;
                }else{
                    if (in_array($param, $aNumberField) && !is_numeric($val)) {
                        $aErrors[] = 'Indicated incorrect  value  '.$param;
                    }
                }
            }
        }
        if(count($aErrors) > 0){
            return array('status' => false, 'data' => implode(" \n ",$aErrors));
        }
        $oResponsible = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:User')->find($params['assign']);
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $fastTrack = $params['fastTrack'] ? 1 : 0;
            if('task' == $params['type']){
                $oTaskList = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Task')->find($params['taskList']);
                $oTask = new TaskItem();
                $oTask->setDescription($params['title']);
                $oTask->setUserCreated($this->getUser());
                $oTask->setTask($oTaskList);
                $oTask->setFastTrack($fastTrack);
                $oTask->setStatus(0);
                $oTask->setResponsible($oResponsible);
                $em = $this->getDoctrine()->getManager();
                $em->persist($oTask);
                $em->flush();
                $taskId = $oTask->getId();
            }else{
                $em = $this->getDoctrine()->getManager();
                $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($params['task']);
                $oTask->setResponsible($oResponsible);
                $oTask->setFastTrack($fastTrack);
                $em->flush();
                $taskId = $oTask->getId();
            }
         if(!$this->saveComment($params, $oTask->getId())){
             $em->getConnection()->rollback();

             return array('status' => true, 'data' => 'Comment not  created, please try again.');
         }
         $em->getConnection()->commit();

         return array('status' => true, 'data' => 'Comment was successfully created.');
        } catch (Exception $e) {
            $em->getConnection()->rollback();

            return array('status' => true, 'data' => 'Comment not  created, please try again.');
        }
    }

    public function saveComment($params, $taskId)
    {
        $oComment = new Comment();
        $oComment->setDescription($params['description']);
        $oComment->setUserCreated($this->getUser());
        $oComment->setParentId($taskId);
        $oComment->setType('TaskItem');
        $em = $this->getDoctrine()->getManager();
        $em->persist($oComment);
        $em->flush();

        return $this->saveFile($params, $oComment->getId());
    }

    public function saveFile($params, $commentId ){
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->find($params['project']);
        $fileName = $commentId.'_'.substr(md5(uniqid(rand(), true)), 0, 15).'.png';
        $fileSrc = 'uploads/files/'.$fileName;
        if($this->base64_to_jpeg($params['image'], $fileSrc)){
            $aFiles = array();
            if(isset($params['attachments']) && count($params['attachments']) > 0){
                foreach ($params['attachments'] as $aAttachment){
                    $aFiles[$aAttachment['name']] = $aAttachment;
                }
            }
            $aFiles[$fileName] = array('original_name' => $fileName,  'size' => filesize($fileSrc), 'name' => $fileName);
            \WWSC\ThalamusBundle\Entity\Files::saveAttachmentFiles($aFiles, $commentId, $oProject, 'Comment');

            return true;
        }

        return false;
    }

    public function base64_to_jpeg($base64_string, $output_file) {
        $fp = fopen($output_file, 'wb');
        $data = explode(',', $base64_string);
        $data = base64_decode($data[1]);
        fwrite($fp, $data);
        fclose($fp);

        return true;
    }

    public function getLastAddedTask($params)
    {
        return $this->getUser()->getLastTask();
    }

    public function checkAuthorizationUser($request, $params)
    {
        $login = $params['login'];
        $password = $params['password'];
        if ($login && $password) {
            $userManager = $this->get('fos_user.user_manager');
            $oUser = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:User')->findOneBy(array('email' => $login));
            if(!$oUser){
                return false;
            }
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($oUser);
            $accountID = isset($params['account']) ? $params['account'] : $oUser->getLastLoggedAccount();
            $oAccount = $oAccount = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Account')->find($accountID);
            $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
            if($encoder->isPasswordValid($oUser->getPassword(),$password, $oUser->getSalt())){
                $oUser->setRoles(array($oUser->getCompany()->getRoles()));
                $userManager->updateUser($oUser);
                $token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles());
                $this->container->get('security.context')->setToken($token);

                return true;
            }
        }

        return false;
    }

    public function readAction(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        if(!$this->getUser()) {
            if (empty($content = $request->getContent())) {
                return new JsonResponse(array('status' => false, 'message' => 'Bad credentials'));
            }
            $params = json_decode($content, true);
            if (!$this->checkAuthorizationUser($request, $params)) {
                return new JsonResponse(array('status' => false, 'message' => 'Bad credentials'));
            }
        }
        if(!$model = $this->get('service.api')->getModel($request->get('model'))){
            return new JsonResponse(array('status' => false, 'message' => 'Bad request'));
        }
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('WWSCThalamusBundle:'.$model)->find($id);
        if(!$obj){
            return new JsonResponse(array('status' => false, 'message' => 'Bad request'));
        }
        if (!$this->get('service.api')->checkPermission($model, $obj)) {
            return new JsonResponse(array('status' => false, 'message' => 'Bad credentials'));
        }
        $response = new JsonResponse($obj->getInfoViaAPI());
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        return  $response;
    }
}