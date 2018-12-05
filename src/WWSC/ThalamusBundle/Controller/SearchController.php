<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\SearchHistory;
/**
 * File controler.
 *
 * In this controller describes the functions of registration new account and display pages dashboard, To-Dos, Calendar, Settings, Templates for account.
 */
class SearchController extends Controller {
    /**
     *  Method add.
     *
     *  This method is responsible for show page multiupload files.
     */
    public function searchProjectAction(Request $request) {
        if ('all' != $request->get('project') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $aSearchHistory = array();
        if('all' != $request->get('project')){
            $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
            $projectId = $oProject->getId();
            $projectSearch = $projectId;
            $projectSlug = $oProject->getSlug();
            $projectIds = false;
        }else{
            $projectSlug = 'all';
            $projectId = 'all';
            $projectSearch = NULL;
            if(!$projectIds = implode(',', $this->getUser()->getProjectsForAccount(true))){
                $projectIds = 0;
            }
        }
        $aSearchResults = array();
        if($request->get('search')){
            $getScope = $request->get('scope') ? $request->get('scope') : null;
            if(!$this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:SearchHistory')->findOneBy(array(
                'project_id' => $projectSearch,
                'user' => $this->getUser()->getId(),
                'search' => trim($request->get('search')),
                ))){
                SearchHistory::saveSearchHistory(trim($request->get('search')), $getScope, $projectSearch);
            }
            $aSearchHistory = SearchHistory::getSearchHistory($projectSearch);
            if('all' == $projectId){
               $whereProject = 'IN ('.$projectIds.')';
               $joinProject = '';
               $slectProject = ', p.name as project_name, p.slug as project_slug, comp.name as company_name';
            }else{
               $whereProject = '= '.$projectId;
               $joinProject = '';
               $slectProject = '';
            }
            $userId = $this->getUser()->getId();
            $companyId = $this->getUser()->getCompany()->getId();
            $companyRoles = $this->getUser()->getCompany()->getRoles();
            $aScopes = array('task', 'taskitem', 'comment', 'writeboard', 'files');
            foreach ($aScopes as $scope){
                if(!$getScope || $getScope == $scope){
                    $scope = ucfirst($scope);
                    $searchFunc = 'searchBy'.$scope;
                    $aSearchResults[$scope] = $this->$searchFunc($request->get('search'), $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId);
                }
            }
        }
        return $this->render('WWSCThalamusBundle:Search:search.html.twig', array(
            'projectSlug' => $projectSlug,
            'projectId' => $projectId,
            'aSearchResults' => $aSearchResults,
            'aSearchHistory' => $aSearchHistory,
            ));
    }

    public function searchByComment($search, $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId){
        if ('ROLE_PROVIDER' != $companyRoles) {
            'ROLE_CLIENT' == $companyRoles ? $whereTask = ' and t.visible_client = 1' : $whereTask = ' and t.visible_freelancer = 1';
            $joinCommentMessage = "join subscribe_email as se on (se.type = 'Message' and se.parent = m.id  and m.project_id {$whereProject} )
                                   join company_user as com_user ON (se.user_id = com_user.user_id and com_user.company_id = $companyId)";
        }else{
            $whereTask = '';
            $joinCommentMessage = '';
        }
        if('all' == $projectId){
            $joinMessageProject = ' join project as p on(p.id = m.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
            $joinTaskProject = ' join project as p on(p.id = t.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
        }else{
            $joinMessageProject = '';
            $joinTaskProject = '';
        }

       $sql = "SELECT c.type as comment_type, c.parent_id as comment_parent_id, c.created as created_date, c.description as comment_description,
                u.last_name as user_first_name, u.last_name as user_last_name, t.id as task_id  {$slectProject} 
                FROM comment as c
                join fos_user as u on (c.user_created_id = u.id and c.is_deleted = 0 )
                join taskitem as ti on (c.type = 'TaskItem' and c.parent_id = ti.id and ti.is_deleted = 0 )
                join task as t on (ti.task_id = t.id and t.is_deleted = 0 and t.project_id ".$whereProject.$whereTask.')
                '.$joinTaskProject."    
                WHERE MATCH(c.description) AGAINST('".$search."') ORDER BY c.created DESC"; 
       $aCommentTask = $this->container->get('database_connection')->query($sql)->fetchAll();

       return $aCommentTask;
    }

     public function searchByTaskitem($search, $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId){
        if ('ROLE_PROVIDER' != $companyRoles) {
            'ROLE_CLIENT' == $companyRoles ? $whereTask = ' and t.visible_client = 1' : $whereTask = ' and t.visible_freelancer = 1';
        }else{
            $whereTask = '';
        }
        if('all' == $projectId){
            $joinTaskProject = ' join project as p on(p.id = t.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
        }else{
            $joinTaskProject = '';
        }
        $sql = "SELECT ti.id as task_item_id, ti.description as task_description, ti.task_id as task_id, ti.created as created_date,
                u.last_name as user_first_name, u.last_name as user_last_name  {$slectProject} 
                FROM taskitem as ti
                join fos_user as u on (ti.user_created_id = u.id and ti.is_deleted = 0 )
                join task as t on (ti.task_id = t.id and t.is_deleted = 0 and t.project_id  ".$whereProject.$whereTask.')
                '.$joinTaskProject."
                WHERE MATCH(ti.description) AGAINST('".$search."') or ti.id = '".$search."' ORDER BY ti.created DESC";

       $aResults = $this->container->get('database_connection')->query($sql)->fetchAll();

       return $aResults;
    }

    public function searchByTask($search, $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId){
        if ('ROLE_PROVIDER' != $companyRoles) {
            'ROLE_CLIENT' == $companyRoles ? $whereTask = ' and t.visible_client = 1' : $whereTask = ' and t.visible_freelancer = 1';
        }else{
            $whereTask = '';
        }        
        if('all' == $projectId){
            $joinTaskProject = ' join project as p on(p.id = t.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
        }else{
            $joinTaskProject = '';
        }
        $sql = "SELECT t.id as task_id, t.description as tasklist_description, t.name as tasklist_title, t.created as created_date,
                u.last_name as user_first_name, u.last_name as user_last_name  {$slectProject} 
                FROM task as t
                join fos_user as u on (t.user_created_id = u.id and t.is_deleted = 0 )
                ".$joinTaskProject."
                WHERE MATCH(t.name, t.description) AGAINST('".$search."') or t.id = '".$search."' and t.is_deleted = 0 and t.project_id  ".$whereProject.$whereTask.'  ORDER BY t.created DESC';

       $aResults = $this->container->get('database_connection')->query($sql)->fetchAll();

       return $aResults;
    }

    public function searchByWriteboard($search, $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId){
        if ('ROLE_PROVIDER' != $companyRoles) {
             $joinWriteboard = "join subscribe_email as se on (se.type = 'Writeboard' and se.parent = w.number and se.user_id = {$userId}  and w.project_id  {$whereProject} )";
        }else{
            $joinWriteboard = '';
        }
        if('all' == $projectId){
            $joinWriteboardProject = ' join project as p on(p.id = w.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
        }else{
            $joinWriteboardProject = '';
        }
        $sql = "SELECT w.number as writeboard_number, w.description as writeboard_description, w.name as writeboard_title, w.created as created_date,
                u.last_name as user_first_name, u.last_name as user_last_name  {$slectProject} 
                FROM writeboard as w
                join fos_user as u on (w.user_created_id = u.id and w.is_deleted = 0 )
                ".$joinWriteboard.'
                '.$joinWriteboardProject."
                WHERE MATCH(w.name, w.description) AGAINST('".$search."') and w.is_deleted = 0 and w.project_id  ".$whereProject.'  ORDER BY w.created DESC'; 
       $aResults = $this->container->get('database_connection')->query($sql)->fetchAll();

       return $aResults;
    }

    public function searchByFiles($search, $userId, $companyId, $companyRoles, $whereProject, $slectProject, $projectId){
        if ('ROLE_PROVIDER' != $companyRoles) {
             $joinCommentMessage = "join subscribe_email as se on (se.type = 'Message' and se.parent = m.id  and m.project_id  $whereProject )
                                     join company_user as com_user ON (se.user_id = com_user.user_id and com_user.company_id = $companyId)";                          
             'ROLE_CLIENT' == $companyRoles ? $whereTask = ' and t.visible_client = 1' : $whereTask = ' and t.visible_freelancer = 1';
        }else{
            $joinCommentMessage = '';
            $whereTask = '';
        }
        if('all' == $projectId){
            $joinMessageProject = ' join project as p on(p.id = m.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
            $joinTaskProject = ' join project as p on(p.id = t.project_id and p.is_deleted = 0 ) join company as comp on(p.responsible_company_id = comp.id) ';
        }else{
            $joinMessageProject = '';
            $joinTaskProject = '';
        }
        $sql = "SELECT f.id as file_id, f.description as file_description, f.name as file_name, f.created as created_date,
                u.last_name as user_first_name, u.last_name as user_last_name  {$slectProject} 
                FROM task as t join  taskitem as ti on(ti.task_id = t.id and t.project_id  ".$whereProject.' and t.is_deleted = 0  '.$whereTask.") 
                join comment as c  on (c.type = 'TaskItem' and c.parent_id = ti.id and ti.is_deleted = 0)
                join files as f  on (f.type = 'Comment' and f.parent = c.id and f.is_deleted = 0)
                join fos_user as u on (f.user_created_id = u.id and f.is_deleted = 0 )
                ".$joinTaskProject."
                WHERE MATCH(f.name, f.description) AGAINST('".$search."') and f.is_deleted = 0 and f.project_id  ".$whereProject.'  ORDER BY f.created DESC'; 

       $aFilesCommentTask = $this->container->get('database_connection')->query($sql)->fetchAll();

       $sql = "SELECT f.id as file_id, f.description as file_description, f.name as file_name, f.created as created_date,
                u.last_name as user_first_name, u.last_name as user_last_name  {$slectProject} 
                FROM  message as m join company_user as cu on (m.user_created_id = cu.user_id and m.is_deleted = 0  and m.project_id  ".$whereProject." and ( (cu.company_id = $companyId  AND m.private = 1) OR m.private = 0))
                {$joinCommentMessage}
                join comment as c on (c.type = 'Message' and c.parent_id = m.id and c.is_deleted = 0)  
                join files as f  on (f.type = 'Comment' and f.parent = c.id and f.is_deleted = 0)
                join fos_user as u on (f.user_created_id = u.id and f.is_deleted = 0 )
                ".$joinMessageProject."
                WHERE MATCH(f.name, f.description) AGAINST('".$search."') and f.is_deleted = 0 and f.project_id  ".$whereProject.'  ORDER BY f.created DESC'; 

       $aFilesCommentMessage = $this->container->get('database_connection')->query($sql)->fetchAll();

       $aResults = $aFilesCommentTask + $aFilesCommentMessage;

       return $aResults;
    }            

     public function clearSearchHistoryAction(Request $request) {
         if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            SearchHistory::clearSearchHistory($oProject->getId());
        }

        return $this->redirect($this->generateUrl('wwsc_thalamus_project_search', array('project' => $request->get('project'))));
     }
}
