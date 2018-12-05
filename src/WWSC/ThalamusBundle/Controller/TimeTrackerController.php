<?php

namespace WWSC\ThalamusBundle\Controller;

use WWSC\ThalamusBundle\Entity\Task;
use WWSC\ThalamusBundle\Entity\TaskItem;
use WWSC\ThalamusBundle\Entity\TimeTracker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWSC\ThalamusBundle\WWSCThalamusBundle;

/**
 * Time tracker controler
 * In this controller describes the functions of display  trackers for project.
 */
class TimeTrackerController extends Controller {
    protected $sheetId;
    protected $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    /**
     *  Method list.
     *
     *  This method is responsible for display trackers for project
     */
    public function listAction(Request $request) {
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if ($request->getSession()->get('presentationMode') || $this->container->get('security.context')->isGranted('ROLE_CLIENT') || !$this->getUser()->getHasRoleProject($request->get('project'))) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            $request->getSession()->set('active_module', 'time');
            $fFilter = $this->createForm(new \WWSC\ThalamusBundle\Form\FilterTimeTrackerForm($this->getUser()->getLanguageCode()));
            $fFilter->bind($request);
            $aFilter = $fFilter->getData();
            $aFilter['integrate_child_records'] = false;
            $aFilter['group_by_public_id'] = false;
            if (!$request->get('filter_time')) {
                $aFilter['filter_hide_empty'] = 1;
                $aFilter['group_by_public_id'] = true;
                $aFilter['filter_person'] = '';
            } else {
                $aFilter['filter_person'] = $request->get('filter_time')['filter_person'];
            }
            if ($request->get('integrate_child_records')) {
                $aFilter['integrate_child_records'] = true;
            }
            if ($request->get('group_by_public_id')) {
                $aFilter['group_by_public_id'] = true;
            }
            if ($request->get('sort_agency_users')) {
                $aFilter['sort_agency_users'] = true;
            }
            if ($request->get('show_only_sums')) {
                $aTimeTracker = array();
                $aFilter['show_only_sums'] = true;
            } else {
                if ($request->get('group_by_task')) {
                    $aFilter['group_by_public_id'] = false;
                    $aTimeTracker = TimeTracker::getReportGropedByTask($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
                    $aFilter['group_by_task'] = true;
                } elseif ($aFilter['group_by_public_id']) {
                    $aTimeTracker = TimeTracker::getReportGropedByTask($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
                } else {
                    $aTimeTracker = TimeTracker::getReport($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
                    $aFilter['group_by_task'] = false;
                    $aFilter['group_by_public_id'] = false;
                }
            }
            $request->getSession()->set('aFilterTimeReport', $aFilter);

            return $this->render('WWSCThalamusBundle:TimeTracker:list.html.twig', array(
                'aTimeTracker' => $aTimeTracker,
                'aReportProjectGropedByCompanys' => TimeTracker::getReportGropedByCompany($oProject->getId(), $aFilter),
                'fFilter' => $fFilter->createView(),
                'aFilter' => $aFilter,
                'oProject' => $oProject,
                'aStates' => TaskItem::$states,
            ));
        }
    }

    public function timeAllProjectsAction(Request $request) {
        if ($request->getSession()->get('presentationMode') || $this->container->get('security.context')->isGranted('ROLE_CLIENT')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'time-all-projects');
        $fFilter = $this->createForm(new \WWSC\ThalamusBundle\Form\FilterTimeTrackerForm($this->getUser()->getLanguageCode()));
        $fFilter->bind($request);
        $aFilter = $fFilter->getData();
        $integrateChildRecords = false;
        if (!$request->get('filter_time')) {
            $aFilter['filter_hide_empty'] = 1;
            $aFilter['filter_person'] = '';
        } else {
            $aFilter['filter_person'] = $request->get('filter_time')['filter_person'];
        }

        if ($request->get('integrate_child_records')) {
            $integrateChildRecords = true;
        }

        if ($request->get('sort_agency_users')) {
            $aFilter['sort_agency_users'] = true;
        }
        if ($request->get('include_closed_projects')) {
            $aFilter['include_closed_projects'] = true;
        }
        if ($request->get('show_only_sums')) {
            $aTimeTracker = array();
            $aFilter['show_only_sums'] = true;
        } else {
            if ($request->get('group_by_task')) {
                $aFilter['group_by_public_id'] = false;
                $aTimeTracker = TimeTracker::getReportGropedByTask(false, $aFilter, $integrateChildRecords);
                $aFilter['group_by_task'] = true;
            } elseif ($request->get('group_by_public_id')) {
                $aFilter['group_by_public_id'] = true;
                $aTimeTracker = TimeTracker::getReportGropedByTask(false, $aFilter, $integrateChildRecords);
            } else {
                $aTimeTracker = TimeTracker::getReport(false, $aFilter, $integrateChildRecords);
                $aFilter['group_by_task'] = false;
            }
        }
        $aFilter['integrate_child_records'] = $integrateChildRecords;
        $request->getSession()->set('aFilterTimeReport', $aFilter);

        return $this->render('WWSCThalamusBundle:TimeTracker:time-all-projects.html.twig', array(
            'aTimeTracker' => $aTimeTracker,
            'fFilter' => $fFilter->createView(),
            'aUsersForFilterTime' => TimeTracker::getUsersForFilterTime(false, $aFilter),
            'aReportGropedByCompanies' => TimeTracker::getReportGropedByCompany(false, $aFilter),
            'aStates' => TaskItem::$states,
        ));
    }

    /**
     *  Method export trackers to csv.
     *
     *  This method is responsible for export trackers to csv
     */
    public function exportToCsvAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') && !$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $aFilter = $request->getSession()->get('aFilterTimeReport');
        if (1 == $request->get('ExportToGoogleSpreadSheet')) {
            $aFilter['project'] = $request->get('project');
            $request->getSession()->set('aFilterTimeReport', $aFilter);

            return $this->getGoogleClient();
        }
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $aFilter = $request->getSession()->get('aFilterTimeReport');
        $aReportProjectGropedByCompany = TimeTracker::getReportGropedByCompany($oProject->getId(), $request->getSession()->get('aFilterTimeReport'));
        $fileName = $oProject->getName().'-'.$oProject->getId().'_Timesheet_'.date('Ymd');
        $projectSlug = $request->get('project');
        $countryCompany = $this->getUser()->getCompany()->getCountry();
        $response = new StreamedResponse();
        if (isset($aFilter['show_only_sums'])) {
            $aTimeTracker = array();
        } else {
            if (isset($aFilter['group_by_task']) && $aFilter['group_by_task']) {
                $aFilter['group_by_public_id'] = false;
                $aTimeTracker = TimeTracker::getReportGropedByTask($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
            } elseif (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id']) {
                $aFilter['group_by_public_id'] = true;
                $aTimeTracker = TimeTracker::getReportGropedByTask($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
            } else {
                $aTimeTracker = TimeTracker::getReport($oProject->getId(), $aFilter, $aFilter['integrate_child_records']);
            }
        }

        return $this->insertDataToCSV($aFilter, $aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aTimeTracker, $response, $request, $fileName);
    }

    public function exportToCsvAccountAction(Request $request) {
        if (1 == $request->get('ExportToGoogleSpreadSheet') && $request->get('code')) {
            $aFilter = $request->getSession()->get('aFilterTimeReport');
            $projectSlug = $aFilter['project'];
            $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $aFilter['project']));
            $projectId = $oProject->getId();
            $exportToGoogle = true;
        }else{
            $projectId = false;
            $exportToGoogle = false;
            $projectSlug = $request->get('project');
        }
        $aFilter = $request->getSession()->get('aFilterTimeReport');
        if (isset($aFilter['show_only_sums'])) {
            $aTimeTracker = array();
        } else {
            if (isset($aFilter['group_by_task']) && $aFilter['group_by_task']) {
                $aFilter['group_by_public_id'] = false;
                $aTimeTracker = TimeTracker::getReportGropedByTask($projectId, $aFilter, $aFilter['integrate_child_records'], $exportToGoogle);
            } elseif (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id']) {
                $aFilter['group_by_public_id'] = true;
                $aTimeTracker = TimeTracker::getReportGropedByTask($projectId, $aFilter, $aFilter['integrate_child_records'], $exportToGoogle);
            } else {
                $aTimeTracker = TimeTracker::getReport($projectId, $aFilter, $aFilter['integrate_child_records'], $exportToGoogle);
            }
        }

        $aReportProjectGropedByCompany = TimeTracker::getReportGropedByCompany(false, $request->getSession()->get('aFilterTimeReport'), true);

        $response = new StreamedResponse();
        if (1 == $request->get('ExportToGoogleSpreadSheet') && $request->get('code')) {
            return $this->insertCSVtoGoogleSheet($aFilter, $aReportProjectGropedByCompany, $request->get('code'), $oProject, $aTimeTracker, $response);
        }
        $countryCompany = $this->getUser()->getCompany()->getCountry();
        $fileName = '_Timesheet_'.date('Ymd');
        $projectSlug = 'all';

        return $this->insertDataToCSVAccount($aFilter, $aReportProjectGropedByCompany, $this->getUser()->getCompany()->getCountry(), $projectSlug, $aTimeTracker, $response, $request, $fileName);
    }

    public function personalTimetrackingAction(Request $request) {
        if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'personal_timetracking');
        if ($request->get('date')) {
            $date = $request->get('date');
        } else {
            if ('de' == $this->getUser()->getLanguageCode()) {
                $date = date('d.m.Y');
            } else {
                $date = date('m/d/Y');
            }
        }

        if ('de' == $this->getUser()->getLanguageCode()) {
            $dateForTimeTracker = str_replace('/', '-', $date);
        } else {
            $dateForTimeTracker = $date;
        }

        $userId = $request->get('user') ?: null;

        if (1 == $request->get('ajax')) {
            $aPersonalTimetracking = TimeTracker::getPersonalTimetracking($dateForTimeTracker, false, $userId);

            return new JsonResponse($aPersonalTimetracking);
        }

        $aSumPersonalTrackedHours = TimeTracker::getSumPersonalTrackedHours('personal');
        $aSumCompanyTrackedHours = array();
        $aSumAccountTrackedHours = array();

        if ('ROLE_ACCOUNTING' == $this->getUser()->getRole()) {
            $aSumCompanyTrackedHours = TimeTracker::getSumPersonalTrackedHours('company');
            $aSumAccountTrackedHours = TimeTracker::getSumPersonalTrackedHours('account');
        }
        $aPersonalTimetracking = TimeTracker::getPersonalTimetracking();
        if (!$request->getSession()->get('userPersonalTimetracking')) {
            $request->getSession()->set('userPersonalTimetracking', $this->getUser()->getId());
        }
        $aTotalHours = TimeTracker::getPersonalTimetracking($dateForTimeTracker, true, $userId);

        return $this->render('WWSCThalamusBundle:TimeTracker:personal-timetracking.html.twig', array(
            'aSumPersonalTrackedHours' => $aSumPersonalTrackedHours,
            'aSumCompanyTrackedHours' => $aSumCompanyTrackedHours,
            'aSumAccountTrackedHours' => $aSumAccountTrackedHours,
            'aUsersForFilterTime' => TimeTracker::getUsersForFilterTime(false, $request->getSession()->get('userPersonalTimetracking')),
            'date' => $date,
            'aTotalHours' => $aTotalHours[0],
        ));
    }

    public function addPersonalTimetrackingAction(Request $request) {
        if ('POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();
            $aFormData = $request->get('personal-timetracking');
            if (!$aFormData['task']) {
                return new Response(0);
            }
            if ('de' == $this->getUser()->getLanguageCode()) {
                $date = date('Y-m-d', strtotime(str_replace('/', '-', $aFormData['date'])));
            } else {
                $date = date('Y-m-d', strtotime($aFormData['date']));
            }
            $startDate = $date.' '.$aFormData['start-time'];
            $endDate = $date.' '.$aFormData['end-time'];
            $newComment = new \WWSC\ThalamusBundle\Entity\Comment();
            $newComment->setType('TaskItem');
            $newComment->setCreated(new \DateTime($endDate));
            $newComment->setUpdated(new \DateTime($endDate));
            $newComment->setParentId($aFormData['task']);
            $em->persist($newComment);
            $newTimetracking = new \WWSC\ThalamusBundle\Entity\TimeTracker();
            $newTimetracking->setComment($newComment);

            $newTimetracking->setBillable(isset($aFormData['billable']) ? 1 : 0);

            $newTimetracking->setDate($date);
            $newTimetracking->setDescription($aFormData['comment-description']);

            // Check for start date should be more than end date
            if (strtotime($startDate) > strtotime($endDate)) {
                return new Response(0);
            }

            // Getting time difference
            $timeStrtotime = strtotime($endDate) - strtotime($startDate);
            $time = date('H:i', strtotime('-1 hour', $timeStrtotime));
            $newTimetracking->setDescription($aFormData['comment-description']);
            $newTimetracking->setDate(new \DateTime($endDate));
            $newTimetracking->setTime($time);

            $em->persist($newTimetracking);
            $em->flush();
            if ('ROLE_ACCOUNTING' == $this->getUser()->getRole() && isset($aFormData['responsible-user'])) {
                $em = $this->getDoctrine()->getManager();
                $oUser = $em->getRepository('WWSCThalamusBundle:User')->find($aFormData['responsible-user']);
                $newTimetracking->setUserResponsible($oUser);
                $em->flush();
            }
            if ($newTimetracking->getId()) {
                $aSumPersonalTrackedHours = TimeTracker::getSumPersonalTrackedHours();
                $aSumCompanyTrackedHours = array();
                $aSumAccountTrackedHours = array();
                if ('ROLE_ACCOUNTING' != $this->getUser()->getRole()) {
                    $aSumCompanyTrackedHours = TimeTracker::getSumPersonalTrackedHours('company');
                    $aSumAccountTrackedHours = TimeTracker::getSumPersonalTrackedHours('account');
                }
                $aTotalHours = TimeTracker::getPersonalTimetracking($date, true);

                return new JsonResponse(
                    array(
                        'aTotalHours' => $aTotalHours[0],
                        'status' => 1,
                        'aSumPersonalTrackedHours' => $this->renderView('WWSCThalamusBundle:TimeTracker:table-tracked-hours.html.twig', array(
                            'aSumPersonalTrackedHours' => $aSumPersonalTrackedHours,
                            'aSumCompanyTrackedHours' => $aSumCompanyTrackedHours,
                            'aSumAccountTrackedHours' => $aSumAccountTrackedHours,
                        )),
                    ));
            } else {
                return new JsonResponse(array('status' => 1));
            }
        }

        $today = new \DateTime('now');
        $todayDate = $today->format('Y-m-d H:i:s');
        //$lastTimeTrackerDate = $todayDate;

        $user = $this->getUser()->getId();
        $sql = "
            SELECT * FROM time_tracker 
            WHERE `person_id` = :id
            AND `time` <> 0 
            ORDER BY date DESC 
            LIMIT 1
        ";

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $run = $connection->prepare($sql);
        $run->bindValue('id', $user);
        $run->execute();
        $lastTimeTracker = $run->fetchAll();

        if (count($lastTimeTracker) > 0) {

            // If in current month
            if(date('m', strtotime($lastTimeTracker[0]['date'])) == date('m', strtotime($todayDate))) {

                // If last record was today or not
                if(date('d', strtotime($lastTimeTracker[0]['date'])) < date('d', strtotime($todayDate))) {
                    $lastTimeTrackerDate = $todayDate;
                } else {
                    $lastTimeTrackerDate = $lastTimeTracker[0]['date'];
                }

            } else {

                $lastTimeTrackerDate = $todayDate;

            }

        }

        return new JsonResponse(array('htmlBox' => $this->renderView('WWSCThalamusBundle:TimeTracker:add-personal-timetracking.html.twig', array('date' => $request->get('date'), 'lastTimeTrackerDate' => $lastTimeTrackerDate))));
    }

    public function editPersonalTimetrackingAction(Request $request) {
        $oTimeTracking = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:TimeTracker')->find($request->get('id'));

        if ('POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();
            $aFormData = $request->get('personal-timetracking');
            if (!$aFormData['comment']) {
                return new Response(0);
            }
            $date = date('Y-m-d', strtotime($oTimeTracking->getDateForm()));

            $oTimeTracking->setDescription($aFormData['comment']);
            $startDate = $date.' '.$aFormData['start-time'];
            $endDate = $date.' '.$aFormData['end-time'];
            if (strtotime($startDate) > strtotime($endDate)) {
                return new Response(0);
            }
            $timeStrtotime = strtotime($endDate) - strtotime($startDate);
            $time = date('H:i', strtotime('-1 hour', $timeStrtotime));
            $oTimeTracking->setDate(new \DateTime($endDate));
            $oTimeTracking->setTime($time);
            if ('ROLE_ACCOUNTING' == $this->getUser()->getRole() && isset($aFormData['responsible-user'])) {
                $oUser = $em->getRepository('WWSCThalamusBundle:User')->find($aFormData['responsible-user']);
                $oTimeTracking->setUserResponsible($oUser);
            }
            $oTimeTracking->setBillable(isset($aFormData['billable']) ? 1 : 0);
            $em->persist($oTimeTracking);
            $em->flush();
            if ($oTimeTracking->getId()) {
                $aSumPersonalTrackedHours = TimeTracker::getSumPersonalTrackedHours();
                $aTotalHours = TimeTracker::getPersonalTimetracking($date, true);
                $aSumCompanyTrackedHours = array();
                $aSumAccountTrackedHours = array();
                if ('ROLE_ACCOUNTING' != $this->getUser()->getRole()) {
                    $aSumCompanyTrackedHours = TimeTracker::getSumPersonalTrackedHours('company');
                    $aSumAccountTrackedHours = TimeTracker::getSumPersonalTrackedHours('account');
                }

                return new JsonResponse(
                    array(
                        'aTotalHours' => $aTotalHours[0],
                        'status' => 1,
                        'aSumPersonalTrackedHours' => $this->renderView('WWSCThalamusBundle:TimeTracker:table-tracked-hours.html.twig', array(
                            'aSumPersonalTrackedHours' => $aSumPersonalTrackedHours,
                            'aSumCompanyTrackedHours' => $aSumCompanyTrackedHours,
                            'aSumAccountTrackedHours' => $aSumAccountTrackedHours,
                        )),
                    ));
            } else {
                return new JsonResponse(array('status' => 1));
            }
        }

        return new JsonResponse(array(
            'htmlBox' => $this->renderView('WWSCThalamusBundle:TimeTracker:edit-personal-timetracking.html.twig', array('oTimeTracking' => $oTimeTracking)),
        ));
    }

    public function cangePersonalTimetrackingAjaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $oTimeTracking = $em->getRepository('WWSCThalamusBundle:TimeTracker')->find($request->get('id'));
        if ('POST' == $request->getMethod()) {
            $startTime = $request->get('startTime');
            $endTime = $request->get('endTime');
            $timeStrtotime = strtotime($endTime) - strtotime($startTime);
            $time = date('H:i', strtotime('-1 hour', $timeStrtotime));
            $createdDate = date('Y-m-d H:i', strtotime($endTime));
            $oTimeTracking->setDate(new \DateTime($createdDate));
            $oTimeTracking->setTime($time);
            $oTimeTracking->getComment()->setUpdated(new \DateTime($createdDate));
            $em->flush();
        }

        return new Response(1);
    }

    public function getTasksProjectForSelectAction(Request $request) {
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->find($request->get('project'));

        return new JsonResponse(
            array(
            'htmlBox' => $this->renderView('WWSCThalamusBundle:Project:get-tasks-project-for-select.html.twig', array('aTasks' => $oProject->getTasksProjectForSelect())),
            'isBillableHours' => $oProject->getIsBillableHours(),
            )
        );
    }

    public function getUsersForSelectAction(Request $request) {
        $oTask = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:TaskItem')->find($request->get('task'));

        return new JsonResponse(array('htmlBox' => $this->renderView('WWSCThalamusBundle:TaskItem:task-item-responsible.html.twig', array(
            'oTask' => $oTask->getTask(),
        ))));
    }

    public function insertDataToCSV($aFilter, $aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aTimeTracker, $response, $request, $fileName) {
        $aColumns = array('Public-ID', 'Task-ID', 'Public_ID-Title', 'Task-Title', 'Description', 'Fast-track', 'Date', 'Hours', 'Time', 'Billable', 'Task-List', 'Company', 'Person', 'Task-Url', 'Status');
        if (isset($aFilter['show_only_sums'])) {
            $response->setCallback(
                function () use ($aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aColumns, $aFilter) {
                    $handle = fopen('php://output', 'r+');
                    fputcsv($handle, $aColumns, ',');
                    if ($aReportProjectGropedByCompany) {
                        foreach ($aReportProjectGropedByCompany as $oReportProjectGropedByCompany) {
                            $data = array(
                                '', '', '', '', '', '',
                                $this->getUser()->formatHours($oReportProjectGropedByCompany['total']),
                                '', '', '',
                                $oReportProjectGropedByCompany['name'],
                                '', '', '',
                            );
                            fputcsv($handle, $data, ',');
                        }
                    }
                    fclose($handle);
                }
            );
        } else {
            $response->setCallback(
                function () use ($aTimeTracker, $aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aColumns, $aFilter) {
                    $handle = fopen('php://output', 'r+');
                    fputcsv($handle, $aColumns, ',');
                    $activeProject = false;
                    foreach ($aTimeTracker as $oTimeTracker) {
                        if (isset(TaskItem::$states[$oTimeTracker['state']])) {
                            $state = TaskItem::$states[$oTimeTracker['state']];
                        } else {
                            $state = '';
                        }

                        if ((isset($aFilter['group_by_task']) && $aFilter['group_by_task']) || (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])) {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['total']);
                            $dateTrack = $oTimeTracker['last_track'];
                            $compName = 1 == $oTimeTracker['count_comp'] ? $oTimeTracker['comp_name'] : '';
                            $personName = 1 == $oTimeTracker['count_person'] ? $oTimeTracker['person'] : '';
                            $description = 1 == $oTimeTracker['count_tt'] ? $this->getUser()->encodingString($oTimeTracker['description']) : '';
                        } else {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['time']);
                            $dateTrack = $oTimeTracker['date'];
                            $compName = $oTimeTracker['comp_name'];
                            $personName = $oTimeTracker['person'];
                            $description = str_replace('"', '\'', $this->getUser()->encodingString($oTimeTracker['description']));
                        }

                        $data = array();
                        $data[] = $oTimeTracker['parent'] ? $oTimeTracker['parent'] : $oTimeTracker['task_id'];
                        $data[] = $oTimeTracker['task_id'];
                        $data[] = mb_convert_encoding(str_replace('"', '\'', $this->getUser()->encodingString($oTimeTracker['parent_name'])), 'ISO-8859-1', 'UTF-8');
                        $data[] = mb_convert_encoding(str_replace('"', '\'', $this->getUser()->encodingString($oTimeTracker['task_name'])), 'ISO-8859-1', 'UTF-8');
                        $data[] = mb_convert_encoding(str_replace('"', '\'', $description), 'ISO-8859-1', 'UTF-8');
                        $data[] = 1 == $oTimeTracker['fast_track'] ? 'yes' : 'no';

                        if ('de' == $this->getUser()->getLanguageCode()) {
                            $hoursTrack = str_replace('.',',', $hoursTrack);
                        }

                        $data[] = date('d.m.y', strtotime($dateTrack));
                        $data[] = $hoursTrack;
                        $data[] = date('H:i', strtotime($dateTrack));
                        $data[] = 1 == $oTimeTracker['billable'] ? 'yes' : 'no';
                        $oTimeTracker['list_name'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $this->getUser()->encodingString($oTimeTracker['list_name']));
                        $data[] = iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace('"', '\'', $oTimeTracker['list_name']));
                        $data[] = $compName;
                        $data[] = $personName;
                        $data[] = $this->getRequest()->getSchemeAndHttpHost().$this->generateUrl(
                                'wwsc_thalamus_project_task_item_comments', array(
                                    'project' => $projectSlug,
                                    'task' => $oTimeTracker['list_id'],
                                    'id' => $oTimeTracker['task_id'],
                                )
                            );
                        $data[] = $state;

                        fputcsv($handle, $data, ',');
                    }
                    if ($aReportProjectGropedByCompany) {
                        foreach ($aReportProjectGropedByCompany as $oReportProjectGropedByCompany) {
                            $data = array(
                                '', '', '', '', '', '',
                                $this->getUser()->formatHours($oReportProjectGropedByCompany['total']),
                                '', '', '',
                                $oReportProjectGropedByCompany['name'],
                                '', '', '',
                            );
                            fputcsv($handle, $data, ',');
                        }
                    }
                    fclose($handle);
                }
            );
        }

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set(
            'Content-Disposition', 'attachment; filename="'.$fileName.'.csv"'
        );

        return $response;
    }

    public function insertDataToCSVAccount($aFilter, $aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aTimeTracker, $response, $request, $fileName) {
        $aColumns = array('Public-ID', 'Task-ID', 'Task-Title', 'Description', 'Fast-track', 'Date', 'Hours', 'Time', 'Billable', 'Task-List', 'Project', 'Company', 'Person', 'Task-Url', 'Status');
        if (isset($aFilter['show_only_sums'])) {
            $response->setCallback(
                function () use ($aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aColumns, $aFilter) {
                    $handle = fopen('php://output', 'r+');
                    fputcsv($handle, $aColumns, ',');
                    if ($aReportProjectGropedByCompany) {
                        foreach ($aReportProjectGropedByCompany as $projectSlug => $aReportProject) {
                            if ('projects_total' != $projectSlug) {
                                foreach ($aReportProjectGropedByCompany[$projectSlug]['company'] as $oReportProjectGropedByCompany) {
                                    $data = array(
                                        '', '', '', '', '', '',
                                        $this->getUser()->formatHours($oReportProjectGropedByCompany['total']),
                                        '', '', '', '',
                                        $oReportProjectGropedByCompany['name'],
                                        '', '', '',
                                    );
                                    fputcsv($handle, $data, ',');
                                }

                                $data = array(
                                    '', '', '', '', '', '',
                                    $this->getUser()->formatHours($aReportProject['total_billable']),
                                    '', 'yes', '',
                                    $aReportProject['project_name'],
                                    '', '', '', '',
                                );
                                fputcsv($handle, $data, ',');

                                $data = array(
                                    '', '', '', '', '', '',
                                    $this->getUser()->formatHours($aReportProject['total_nonbillable']),
                                    '', 'no', '',
                                    $aReportProject['project_name'],
                                    '', '', '', '',
                                );

                                fputcsv($handle, $data, ',');
                                fputcsv($handle, array(), ',');
                            }
                        }
                        $data = array(
                            '', '', '', '', '', '',
                            $this->getUser()->formatHours($aReportProjectGropedByCompany['projects_total']['sum']),
                            '', '', '',
                            'Total',
                            '', '', '', '',
                        );
                        fputcsv($handle, $data, ',');
                        $data = array(
                            '', '', '', '', '', '',
                            $this->getUser()->formatHours($aReportProjectGropedByCompany['projects_total']['billable']),
                            '', 'yes', '', '', '', '', '', '',
                        );
                        fputcsv($handle, $data, ',');
                        $data = array(
                            '', '', '', '', '', '',
                            $this->getUser()->formatHours($aReportProjectGropedByCompany['projects_total']['nonbillable']),
                            '', 'no', '', '', '', '', '', '',
                        );
                        fputcsv($handle, $data, ',');
                    }
                    fclose($handle);
                }
            );
        } else {
            $response->setCallback(
                function () use ($aTimeTracker, $aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aColumns, $aFilter) {
                    $handle = fopen('php://output', 'r+');
                    fputcsv($handle, $aColumns, ',');
                    $activeProject = false;
                    foreach ($aTimeTracker as $oTimeTracker) {
                        $pSlug = $oTimeTracker['project_slug'];
                        if ($activeProject && $activeProject != $pSlug) {
                            foreach ($aReportProjectGropedByCompany[$activeProject]['company'] as $aReportGropedByCompany) {
                                $data = array(
                                    '', '', '', '', '', '',
                                    $this->getUser()->formatHours($aReportGropedByCompany['total']),
                                    '', '', '', '',
                                    $aReportGropedByCompany['name'],
                                    '', '', '', '',
                                );
                                fputcsv($handle, $data, ',');
                            }
                            $activeProject ? $activeProjectSlug = $activeProject : $activeProjectSlug = $pSlug;
                            $data = array(
                                '', '', '', '', '', '',
                                $this->getUser()->formatHours($aReportProjectGropedByCompany[$activeProjectSlug]['project_total']),
                                '', '', '',
                                $aReportProjectGropedByCompany[$activeProjectSlug]['project_name'],
                                '', '', '', '', '',
                            );
                            fputcsv($handle, $data, ',');
                        }
                        if (isset(TaskItem::$states[$oTimeTracker['state']])) {
                            $state = TaskItem::$states[$oTimeTracker['state']];
                        } else {
                            $state = '';
                        }
                        if ((isset($aFilter['group_by_task']) && $aFilter['group_by_task']) || (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])) {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['total']);
                            $dateTrack = $oTimeTracker['last_track'];
                            $compName = 1 == $oTimeTracker['count_comp'] ? $oTimeTracker['comp_name'] : '';
                            $personName = 1 == $oTimeTracker['count_person'] ? $oTimeTracker['person'] : '';
                            $description = 1 == $oTimeTracker['count_tt'] ? $this->getUser()->encodingString($oTimeTracker['description']) : '';
                        } else {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['time']);
                            $dateTrack = $oTimeTracker['date'];
                            $compName = $oTimeTracker['comp_name'];
                            $personName = $oTimeTracker['person'];
                            $description = $this->getUser()->encodingString($oTimeTracker['description']);
                        }
                        $data = array();
                        $data[] = $oTimeTracker['parent'] ? $oTimeTracker['parent'] : $oTimeTracker['task_id'];
                        $data[] = $oTimeTracker['task_id'];
                        $data[] = mb_convert_encoding(str_replace('"', '\'', $this->getUser()->encodingString($oTimeTracker['task_name'])), 'ISO-8859-1', 'UTF-8');
                        $data[] = mb_convert_encoding(str_replace('"', '\'', $description), 'ISO-8859-1', 'UTF-8');
                        $data[] = 1 == $oTimeTracker['fast_track'] ? 'yes' : 'no';
                        $data[] = date('d.m.y', strtotime($dateTrack));
                        $data[] = $hoursTrack;
                        $data[] = date('H:i', strtotime($dateTrack));
                        $data[] = 1 == $oTimeTracker['billable'] ? 'yes' : 'no';
                        $oTimeTracker['list_name'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $this->getUser()->encodingString($oTimeTracker['list_name']));
                        $data[] = iconv('UTF-8', 'ISO-8859-1', str_replace('"', '\'', $oTimeTracker['list_name']));
                        $data[] = $oTimeTracker['project_name'];
                        $data[] = $compName;
                        $data[] = $personName;
                        $data[] = $this->getRequest()->getSchemeAndHttpHost().$this->generateUrl(
                                'wwsc_thalamus_project_task_item_comments', array(
                                    'project' => $projectSlug,
                                    'task' => $oTimeTracker['list_id'],
                                    'id' => $oTimeTracker['task_id'],
                                )
                            );
                        $data[] = $state;
                        fputcsv($handle, $data, ',');
                        $activeProject = $oTimeTracker['project_slug'];
                    }
                    if ($activeProject) {
                        foreach ($aReportProjectGropedByCompany[$activeProject]['company'] as $aReportGropedByCompany) {
                            $data = array(
                                '', '', '', '', '', '',
                                $this->getUser()->formatHours($aReportGropedByCompany['total']),
                                '', '', '', '',
                                $aReportGropedByCompany['name'],
                                '', '', '', '',
                            );
                        }
                        fputcsv($handle, $data, ',');

                        $data = array(
                            '', '', '', '', '', '',
                            $this->getUser()->formatHours($aReportProjectGropedByCompany[$activeProject]['project_total']),
                            '', '', '',
                            $aReportProjectGropedByCompany[$activeProject]['project_name'],
                            '', '', '', '', '',
                        );
                        fputcsv($handle, $data, ',');
                    }
                    fclose($handle);
                }
            );
        }

        $request->getSession()->set('aFilterTimeReport', false);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set(
            'Content-Disposition', 'attachment; filename="temp/'.$fileName.'.csv"'
        );

        return $response;
    }

    public function insertCSVtoGoogleSheet($aFilter, $aReportProjectGropedByCompany, $code, $oProject, $aTimeTracker, $response) {
        // Define BOOL Parameter for Grouped-Sheets or not

        $taskGroupingIsActive = FALSE;
        if (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])
        {
            $taskGroupingIsActive = TRUE;
        }

        if (FALSE == $taskGroupingIsActive)
        {
            // Header für Detail-Ansicht
            $aColumns = array('', 'Nr', 'Task-Titel', 'Beschreibung', 'Fast-Track', 'Zeit in h', 'Datum', 'Status', 'Person', 'Bereich', 'Firma', 'Komment-URL', 'Original-Task', 'Original-Zeit', 'Abrechenbar');
        }
        else {
            //ToDo for later: Columns for "Merge by public id" -done
            $aColumns = array('', 'Nr', 'Titel', 'Fast-Track', 'Status', 'Zeit in h', '', ' ', '', '', '', '');
        }

        $projectSlug = $oProject->getSlug();
        $titleSheet = $oProject->getName().'-Stundenaufstellung  '.date('d/m/Y');
        $countryCompany = $this->getUser()->getCompany()->getCountry();

        //ToDo-4: German date format (SPAN and Month) -done

        $oDateTo = $this->getUser()->convertDateFormat($aFilter['filter_date_to'], 'object');
        $oDateFrom = $this->getUser()->convertDateFormat($aFilter['filter_date_from'], 'object');

        $dateFrom = $this->getUser()->convertDateFormat($aFilter['filter_date_from'], 'month-of-timespan');
        $dateTo = $this->getUser()->convertDateFormat($aFilter['filter_date_to'], 'month-of-timespan');
        $monthOfTimespan = $dateFrom;
        if ($dateFrom != $dateTo) {
            $monthOfTimespan = $dateFrom.' - '.$dateTo;
        }
        $titleSheet = $oProject->getName().'-Stundenaufstellung  '.$monthOfTimespan;
        $countTimeTracker = count($aTimeTracker);
        $monthOfTimespanRow = array('', 'Angefallene Aufwände im Zeitraum  '.$oDateFrom->format('d.m.Y').'-'.$oDateTo->format('d.m.Y'), '', '', '', '', '', '', $monthOfTimespan);
        if (isset($aFilter['show_only_sums'])) {
            $response->setCallback(
                function () use ($aReportProjectGropedByCompany, $countryCompany, $projectSlug, $aColumns, $aFilter) {
                    $handle = fopen('php://output', 'r+', false, stream_context_create( array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
                    fputcsv($handle, $aColumns, ',');
                    if ($aReportProjectGropedByCompany) {
                        foreach ($aReportProjectGropedByCompany as $oReportProjectGropedByCompany) {
                            if(isset($oReportProjectGropedByCompany['total'])) {
                                $data = array(
                                    '', '', '', '', '', '',
                                    $this->getUser()->formatHours($oReportProjectGropedByCompany['total']),
                                    '', '', '',
                                    $oReportProjectGropedByCompany['name'],
                                    '', '', '',
                                );
                                fputcsv($handle, $data, ',');
                            }
                        }
                    }
                    fclose($handle);
                }
            );
        } else {
            $response->setCallback(
                function () use ($aTimeTracker, $countTimeTracker, $aReportProjectGropedByCompany, $countryCompany, $oProject, $aColumns, $aFilter, $monthOfTimespanRow) {
                    $projectSlug = $oProject->getSlug();
                    $taskGroupingIsActive = FALSE;
                    if (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])
                    {
                        $taskGroupingIsActive = TRUE;
                    }
                    $handle = fopen('php://output', 'r+', false, stream_context_create( array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '=IMAGE("'.$this->getRequest()->getSchemeAndHttpHost().'/uploads/company/'.$this->getUser()->getCompany()->getLogo().'"; 1)');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', $oProject->getResponsibleCompany()->getName(), '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('',  $oProject->getName(), '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', 'Vertragszeitraum:', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', 'Kontingent-Übertrag aus dem Vormonat:', '', '', '', 9999);
                    fputcsv($handle, $data, ',');
                    $data = array('', 'Im aktuellen Abrechnungszeitraum genutzt:', '', '', '', '=F'.($countTimeTracker + 20));
                    fputcsv($handle, $data, ',');
                    $data = array('', '', '', '', '', '');
                    fputcsv($handle, $data, ',');
                    $data = array('', 'Verfügbares Restkontingent:  ', '', '', '', '=F12-F13');
                    fputcsv($handle, $data, ',');
                    $data = array('');
                    fputcsv($handle, $data, ',');
                    $data = array('');

                    fputcsv($handle, $data, ',');

                    fputcsv($handle, $monthOfTimespanRow, ',');

                    // Insert the colomn titles
                    fputcsv($handle, $aColumns, ',');

                    $activeProject = false;
                    foreach ($aTimeTracker as $oTimeTracker) {
                        if ((isset($aFilter['group_by_task']) && $aFilter['group_by_task']) || (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])) {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['total']);
							$hoursOriginal = $this->getUser()->formatHours($oTimeTracker['hours_original']);
                            $dateTrack = $oTimeTracker['last_track'];
                            $compName = 1 == $oTimeTracker['count_comp'] ? $oTimeTracker['comp_name'] : '';
                            $personName = 1 == $oTimeTracker['count_person'] ? $oTimeTracker['person'] : '';
                            $description = 1 == $oTimeTracker['count_tt'] ? $this->getUser()->encodingString($oTimeTracker['description']) : '';
                        } else {
                            $hoursTrack = $this->getUser()->formatHours($oTimeTracker['time']);
							$hoursOriginal = $this->getUser()->formatHours($oTimeTracker['hours_original']);
                            $dateTrack = $oTimeTracker['date'];
                            $compName = $oTimeTracker['comp_name'];
                            $personName = $oTimeTracker['person'];
                            $description = $this->getUser()->encodingString($oTimeTracker['description']);
                        }
                        $data = array();
                        // empty cell
                        $data[] = '';

                        //parent-Task-ID
                        $parentTaskId = $oTimeTracker['parent'] ? $oTimeTracker['parent'] : $oTimeTracker['task_id'];
                        $data[] = '=HYPERLINK("'.$this->getRequest()->getSchemeAndHttpHost().$this->generateUrl(
                                'wwsc_thalamus_project_task_item_comments', array(
                                'project' => $projectSlug,
                                'task' => $oTimeTracker['list_id'],
                                'id' => $parentTaskId,
                            )).'";"'.$parentTaskId.'")';

                        //parent-Task-Title
                        $data[] = $this->getUser()->encodingString($oTimeTracker['parent_name']);

                        // Task-ID
                        /*
                        $data[] = '=HYPERLINK("' . $this->getRequest()->getSchemeAndHttpHost() . $this->generateUrl(
                                "wwsc_thalamus_project_task_item_comments", array(
                                "project" => $projectSlug,
                                "task" => $oTimeTracker["list_id"],
                                "id" => $oTimeTracker["task_id"]
                            )) . '";"' . $oTimeTracker["task_id"] . '")';
                        // Task-Title
                        $data[] = $this->getUser()->encodingString($oTimeTracker['task_name']);
                        */

                        // Fast-Track

                        /**
                         * State
                         */
                        // Set parent status to all child tasks
                        if($oTimeTracker['parent'] !== null) {

                            /**
                             * @var TaskItem $getParent
                             */
                            $parentId = (int)$oTimeTracker['parent'];
                            $getParent = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->findBy(['id'=>$parentId]);
                            $currentStatus = $getParent[0]->getState();

                        } else {

                            $currentStatus = $oTimeTracker['state'];

                        }

                        // Convert status format to readable
                        $convertedStatus = \WWSC\ThalamusBundle\Entity\TaskItem::statusConvert($currentStatus);

                        // States array
                        $aState = \WWSC\ThalamusBundle\Entity\TaskItem::$states;

                        if (FALSE == $taskGroupingIsActive)
                        {
                            $data[] = $description;
                            $data[] = 1 == $oTimeTracker['fast_track'] ? 'ja' : 'nein';
                        }
                        else {
                            $data[] = 1 == $oTimeTracker['fast_track'] ? 'ja' : 'nein';

                            // State
                            $data[] = $convertedStatus;

                        }

                        // State

                        // ToDo-5 Calculate the right value for each duration correct -done
                        // Rules for all "Merged rows":
                        // 1. If an task is marked as FAST-TRACK multiply the duration by 1.5 (e.g. 10 minutes ⇒ 15 minutes)
                        // 2. Round now every entry to the next 15 minutes (eg. 7 minutes ⇒ 15 minutes, 44 minutes ⇒ 45 minutes, 15 minutes ⇒ 15 minutes)
                        // 3. only count entry that are marked as BILLABLE = TRUE / YES

                        // If an task is marked as FAST-TRACK multiply the duration by 1.5 (e.g. 10 minutes ⇒ 15 minutes)

                        $hoursTrack = str_replace(',', '.', $hoursTrack);

                        $hoursTrack = (float) $hoursTrack;

                        if (1 != $oTimeTracker['billable']) {
                            $hoursTrack = 0;
                        }
                        $hoursTrack = str_replace('.',',', $hoursTrack);
                        $data[] = $hoursTrack;

                        if (FALSE == $taskGroupingIsActive)
                        {
                            // Date
                            $data[] = date('d.m.y', strtotime($dateTrack));
                            // State
                            $data[] = $convertedStatus;
                            // Person
                            $data[] = $personName;
                            //emtpy Row
                            $data[] = '';
                            // Company Name
                            $data[] = $oTimeTracker['comp_name'];

                            // comment-link
                            if ((isset($aFilter['group_by_task']) && $aFilter['group_by_task']) || (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])) {
                                $data[] = '=HYPERLINK("'.$this->getRequest()->getSchemeAndHttpHost().$this->generateUrl(
                                        'wwsc_thalamus_project_task_item_comments', array(
                                        'project' => $projectSlug,
                                        'task' => $oTimeTracker['list_id'],
                                        'id' => $oTimeTracker['task_id'],
                                    )).'";"comment-link")';
                            } else {
                                $data[] = '=HYPERLINK("'.$this->getRequest()->getSchemeAndHttpHost().$this->generateUrl(
                                        'wwsc_thalamus_project_task_item_comments', array(
                                        'project' => $projectSlug,
                                        'task' => $oTimeTracker['list_id'],
                                        'id' => $oTimeTracker['task_id'],
                                    )).'#c_'.$oTimeTracker['comment_id'].'";"'.$oTimeTracker['comment_id'].'")';
                            }

                            // Task-Title
                            $data[] = $this->getUser()->encodingString($oTimeTracker['task_name']);

                            // Original-time-spent
                            $data[] = $hoursOriginal;

                            //Billable
                            $data[] = 1 == $oTimeTracker['billable'] ? 'ja' : 'nein';
                        }

                        fputcsv($handle, $data, ',');
                    }

                    if ($aReportProjectGropedByCompany) {
                        foreach ($aReportProjectGropedByCompany as $oReportProjectGropedByCompany) {
                            /*
                                $data = array('');
                                fputcsv($handle, $data, ',');
                                $data = array(
                                    '', '', '', '', 'Stunden',
                                    $this->getUser()->formatHours($oReportProjectGropedByCompany['total']), '',
                                    $oReportProjectGropedByCompany['name']);
                                fputcsv($handle, $data, ',');
                            */
                            $data = array(
                                '', 'Summe aller im Abrechnungsmonat angefallenen Aufwände // Stunden', '', '', '', '=SUM(F20:F'.(19 + $countTimeTracker).')', '', '', '', '', '', '', '', FALSE == $taskGroupingIsActive ? '=SUM(N20:N'.(19 + $countTimeTracker).')' : '',
                            );
                        }
                        fputcsv($handle, $data, ',');
                        $data = array('');
                        fputcsv($handle, $data, ',');
                        $data = array('');
                        fputcsv($handle, $data, ',');
                        $data = array('');
                        fputcsv($handle, $data, ',');
                        $data = array('Benötigen Sie mehr Informationen zu einem Task?');
                        fputcsv($handle, $data, ',');
                        $data = array('Dann haben Sie jetzt zwei Möglichkeiten:
1. Klicken Sie auf den Link in der Spalte "Nr". Dieser führt direkt zur detaillierten Beschreibung und zum weiteren Verlauf dieser Aufgabe.
2. Oder Sie kontaktieren uns und wir helfen gerne weiter. Tel.: +49 211 781 789 70', '', '', '', '', '');
                        fputcsv($handle, $data, ',');
                        $data = array('Stand:', date('d.m/y'), '', '', '', '');
                        fputcsv($handle, $data, ',');

                        if (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])
                        {
                            $data = array('Grouping by Public-ID');
                            fputcsv($handle, $data, ',');
                        }
                        else {
                            $data = array('Kein Grouping aktiviert.');
                            fputcsv($handle, $data, ',');
                        }
                    }
                    fclose($handle);
                }
            );
        }
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set(
            'Content-Disposition', 'attachment; filename="dataForGoogleSpreadsheet.csv"'
        );

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        return $this->importCSVtoGoogleSreadsheet($response, $content, $code, $countTimeTracker, $titleSheet,$aFilter);
    }

    public function getGoogleClient($code = false) {
        $client = new \Google_Client();
        $client->setClientId($this->container->getParameter('google_client_id'));
        $client->setClientSecret($this->container->getParameter('google_client_secret'));
        $client->setRedirectUri($this->getRequest()->getSchemeAndHttpHost().'/time/export_to_csv_account?ExportToGoogleSpreadSheet=1');
        $client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://docs.google.com/feeds/', 'https://www.googleapis.com/auth/spreadsheets'));
        $client->setAccessType('offline');
        if($code){
            $accessToken = $client->fetchAccessTokenWithAuthCode($code);
            $client->setAccessToken($accessToken);

            return $client;
        }
        $authUrl = $client->createAuthUrl();

        return $this->redirect($authUrl);
    }

    public function importCSVtoGoogleSreadsheet($response = false, $content = false, $code, $rowCount, $titleFile,$aFilter) {
        // Define BOOL Parameter for Grouped-Sheets or not
        $taskGroupingIsActive = FALSE;
        if (isset($aFilter['group_by_public_id']) && $aFilter['group_by_public_id'])
        {
            $taskGroupingIsActive = TRUE;
        }

        $client = $this->getGoogleClient($code);
        $service = new \Google_Service_Drive($client);
        try {
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                //ToDo1: Adjust the title of the Google-Drive-Name -done
                'name' => $titleFile,
                'mimeType' => 'application/vnd.google-apps.spreadsheet', ));

            // $content = file_get_contents($fileUrl, false, stream_context_create($arrContextOptions));
            $file = $service->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => 'text/csv',
                'uploadType' => 'multipart',
                'fields' => 'id', ));
            $serviceSheet = new \Google_Service_Sheets($client);
            $spreadsheetId = $file->id;
            $spreadsheet = $serviceSheet->spreadsheets->get($spreadsheetId);

            $spreadsheet_locale = $spreadsheet->getProperties()->locale;

            $separator = 'en' != $spreadsheet_locale ? ',' : '.';

            $sheetId = $spreadsheet->sheets[0]->properties->sheetId;
            $fontSizeLarge = 16;
            $fontSizeSmall = 12;
            $requests = array();
            $this->sheetId = $sheetId;

            //Format Company name
            $requests[] = $this->formatCell('B7', [
                'fontSize' => $fontSizeLarge,
                'bold' => true,
            ]);

            //Format project name
            $requests[] = $this->formatCell('B8', [
                'fontSize' => $fontSizeLarge,
            ]);

            //Format Verfügbares Restkontingent
            $requests[] = $this->formatCell('B15:F15', [
                'fontSize' => $fontSizeSmall,
                'bold' => true,
                'backgroundColor' => 0.80,
            ]);

            //Format Angefallener Zeitraum
            $requests[] = $this->formatCell('B18:F18', [
                'fontSize' => $fontSizeSmall,
            ]);

            //Format Columns title
            if (FALSE == $taskGroupingIsActive)
            {
                $lastColData = 'O';
                $lastColorIndex = 'J';
            }
            else {
                $lastColData = 'F';
                $lastColorIndex = 'F';
            }

            //Format Columns title
            $requests[] = $this->formatCell("B19:{$lastColData}19", [
                'fontSize' => $fontSizeSmall,
                'bold' => true,
                'backgroundColor' => 0.80,
            ]);

            $requests[] = $this->formatCell('F12', [
                'numberFormat' => 'number',
                'numberPattern' => '.00',
            ]);

            //Format of the content-rows
            $color = 0.90;

            $requests[] = $this->formatCell("B20:{$lastColorIndex}".($rowCount + 20), [
                'fontSize' => $fontSizeSmall,
                'foregroundColor' => 0,
                'backgroundColor' => $color,
                'verticalAlignment' => 'top',
            ]);

			if (FALSE == $taskGroupingIsActive)
			{
                $requests[] = $this->formatCell('C20:C'.($rowCount + 20), [
                    'breakIntoNewLine' => true,
                    'fontSize' => $fontSizeSmall,
                    'backgroundColor' => $color,
                ]);

                $requests[] = $this->formatCell('D20:D'.($rowCount + 20), [
                    'fontSize' => $fontSizeSmall,
                    'bold' => true,
                    'backgroundColor' => $color,
                    'verticalAlignment' => 'top',
                ]);

                $requests[] = $this->formatCell('E20:E'.($rowCount + 20), [
                    'fontSize' => $fontSizeSmall,
                    'foregroundColor' => 0,
                    'backgroundColor' => $color,
                    'horizontalAlignment' => 'center',
                    'verticalAlignment' => 'top',
                ]);

                $requests[] = $this->formatCell('K20:O'.($rowCount + 20), [
                    'fontSize' => $fontSizeSmall,
                    'foregroundColor' => 0,
                    'backgroundColor' => 0.6,
                    'verticalAlignment' => 'top',
                ]);

				$requests[] = $this->formatCell('N20:N'.($rowCount + 20), [
				'fontSize' => $fontSizeSmall,
				'foregroundColor' => 0,
				'backgroundColor' => 0.6,
                'numberFormat' => 'number',
                'numberPattern' => '0.00',
                'verticalAlignment' => 'top',
                ]);

                $requests[] = $this->formatCell('G20:G'.($rowCount + 20), [
                    'fontSize' => $fontSizeSmall,
                    'foregroundColor' => 0,
                    'backgroundColor' => $color,
                    'horizontalAlignment' => 'right',
                    'verticalAlignment' => 'top',
                    'numberFormat' => 'date',
                    'numberPattern' => 'dd.mm.yyyy',
                ]);
			}
			else {
                $requests[] = $this->formatCell('D20:D'.($rowCount + 20), [
                    'fontSize' => $fontSizeSmall,
                    'foregroundColor' => 0,
                    'backgroundColor' => $color,
                    'horizontalAlignment' => 'center',
                    'verticalAlignment' => 'top',
                ]);

                $requests[] = $this->formatCell('C20:C'.($rowCount + 20), [
                    'breakIntoNewLine' => true,
                    'fontSize' => $fontSizeSmall,
                    'bold' => true,
                    'backgroundColor' => $color,
                ]);
            }

            $requests[] = $this->formatCell('F20:F'.($rowCount + 20), [
                'fontSize' => $fontSizeSmall,
                'backgroundColor' => $color,
                'numberFormat' => 'number',
                'numberPattern' => '0.00',
                'verticalAlignment' => 'top',
            ]);

            //Get price values and replace decimal separator depending on spreadsheet locale ("," for de and "." for en)
            $separatorOld = 'en' != $spreadsheet_locale ? '.' : ',';
            $values = $serviceSheet->spreadsheets_values->get($spreadsheetId, 'F20:F'.($rowCount + 20))->getValues();

            foreach ($values as $key => &$value) {
                $value[0] = str_replace($separatorOld, $separator, $value[0]);
            }

            $body = new \Google_Service_Sheets_ValueRange(array(
                'values' => $values,
            ));
            $params = array(
                'valueInputOption' => 'USER_ENTERED',
            );
            $serviceSheet->spreadsheets_values->update($spreadsheetId, 'F20:F'.($rowCount + 20), $body, $params);

            $values = $serviceSheet->spreadsheets_values->get($spreadsheetId, 'F'.($rowCount + 20))->getValues();

            foreach ($values as $key => &$value) {
                $value[0] = '=SUM(F20:F'.($rowCount + 19).')';
            }
            $body = new \Google_Service_Sheets_ValueRange(array(
                'values' => $values,
            ));
            $serviceSheet->spreadsheets_values->update($spreadsheetId, 'F'.($rowCount + 20), $body, $params);

            //Format of the Footer
            $requests[] = $this->formatCell('B'.($rowCount + 20).':F'.($rowCount + 20), [
                'fontSize' => $fontSizeSmall,
                'foregroundColor' => 1,
                'bold' => true,
                'backgroundColor' => 0.32,
            ]);

            //Format of the Footer Total price cell
            $requests[] = $this->formatCell('F'.($rowCount + 20), [
                'fontSize' => $fontSizeSmall,
                'bold' => true,
                'foregroundColor' => 1,
                'backgroundColor' => 0.32,
                'numberFormat' => 'number',
                'numberPattern' => '0.00',
            ]);

			if (FALSE == $taskGroupingIsActive)
			{
                $values = $serviceSheet->spreadsheets_values->get($spreadsheetId, 'N20:N'.($rowCount + 20))->getValues();

                foreach ($values as $key => &$value) {
                    $value[0] = str_replace($separatorOld, $separator, $value[0]);
                }

                $body = new \Google_Service_Sheets_ValueRange(array(
                    'values' => $values,
                ));
                $params = array(
                    'valueInputOption' => 'USER_ENTERED',
                );
                $serviceSheet->spreadsheets_values->update($spreadsheetId, 'N20:N'.($rowCount + 20), $body, $params);

                $values = $serviceSheet->spreadsheets_values->get($spreadsheetId, 'N'.($rowCount + 20))->getValues();

                foreach ($values as $key => &$value) {
                    $value[0] = '=SUM(N20:N'.($rowCount + 19).')';
                }
                $body = new \Google_Service_Sheets_ValueRange(array(
                    'values' => $values,
                ));
                $serviceSheet->spreadsheets_values->update($spreadsheetId, 'N'.($rowCount + 20), $body, $params);

				$requests[] = $this->formatCell('N'.($rowCount + 20), [
				'bold' => true,				
                'fontSize' => $fontSizeSmall,
                'backgroundColor' => 0.6,
                'foregroundColor' => 1,
                'numberFormat' => 'number',
                'numberPattern' => '0.00',
				]);
			}

            //merged cells for logo
            $mergeCellRequest = new \Google_Service_Sheets_MergeCellsRequest();
            $mergedRange = new \Google_Service_Sheets_GridRange();
            $mergedRange->setSheetId($sheetId);
            $mergedRange->setStartRowIndex(1);
            $mergedRange->setEndRowIndex(5);
            $mergedRange->setStartColumnIndex(1);
            $mergedRange->setEndColumnIndex(3);
            $mergeCellRequest->setRange($mergedRange);
            $mergeCellRequest->setMergeType('MERGE_ALL');
            $requestMerge = new \Google_Service_Sheets_Request();
            $requestMerge->setMergeCells($mergeCellRequest);
            $requests[] = $requestMerge;

            //Logo horizontal alignment
            /*$requests[] = $this->formatCell('B2:C5', [
                'fontSize' => $fontSizeSmall,
                'horizontalAlignment' => 'center',
                'verticalAlignment' => 'middle'
            ]);*/

            // Column C auto width
            $requests[] = [
               /* "autoResizeDimensions" => [
                    "dimensions" => [
                        "sheetId" => $sheetId,
                        "dimension" => "COLUMNS",
                        "startIndex" => 2,
                        "endIndex"=> 3
                    ]
                ]
                */
                'updateDimensionProperties' => [
                'range' => [
                    'sheetId' => $sheetId,
                      'dimension' => 'COLUMNS',
                      'startIndex' => 2,
                      'endIndex' => 3,
                    ],
                    'properties' => [
                        'pixelSize' => 385,
                    ],
                    'fields' => 'pixelSize',
                 ],
            ];

            $requests[] = $this->formatCell('I18', [
                'numberFormat' => 'date',
                'numberPattern' => 'mmmm yyy',
            ]);

            //todo: trying to set stripped background
            /*$requests[] = [
                'addConditionalFormatRule' => [
                    'rule' => [
                        'ranges' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 20,
                            'endRowIndex' => 30,
                            'startColumnIndex' => 5,
                            'endColumnIndex' => 6
                        ],
                        'booleanRule' => [
                            'condition' => [
                                'type' => 'CUSTOM_FORMULA',
                                'values' => [
                                    [
                                        'userEnteredValue' => '=ISODD(2)'
                                    ]
                                ]
                            ],
                            'format' => [
                                'backgroundColor' => [
                                    'red' => 0.5
                                ]
                            ]
                        ]
                    ],
                    'index' => 1
                ]
            ];*/

            $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
                'requests' => $requests,
            ));
            $serviceSheet->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            return $this->redirect('https://docs.google.com/spreadsheets/d/'.$spreadsheetId);
        } catch (\Exception $e) {
            echo 'An error occurred: '.$e->getMessage();
        }
    }

    public function formatCell($cells, $options = array()){
        $letters_flip = array_flip($this->letters);

        $sheetId = $this->sheetId;

        if(is_array($cells) && 4 === count($cells)){
            $rowStart = $cells[0];
            $rowEnd = $cells[1];
            $colStart = $cells[2];
            $colEnd = $cells[3];
        } else {
            $cells = explode(':', $cells);

            if(1 == count($cells)){
                $column_index = (int) $letters_flip[substr($cells[0], 0, 1)];
                $row_index = (int) substr($cells[0], 1);

                $rowStart = $row_index - 1;
                $rowEnd = $rowStart + 1;
                $colStart = $column_index;
                $colEnd = $colStart + 1;
            } elseif(2 == count($cells)) {
                $left_top_column_index = (int) $letters_flip[substr($cells[0], 0, 1)];
                $left_top_row_index = (int) substr($cells[0], 1);
                $right_bottom_column_index = (int) $letters_flip[substr($cells[1], 0, 1)];
                $right_bottom_row_index = (int) substr($cells[1], 1);

                $rowStart = $left_top_row_index - 1;
                $rowEnd = $right_bottom_row_index;
                $colStart = $left_top_column_index;
                $colEnd = $right_bottom_column_index + 1;
            }
        }

        $fields = 'userEnteredFormat(textFormat, backgroundColor, horizontalAlignment, verticalAlignment, numberFormat, wrapStrategy)';

        $cellFormat = new \Google_Service_Sheets_CellFormat();

        //text style
        $textFormat = new \Google_Service_Sheets_TextFormat();
        if(isset($options['fontSize'])){
            $textFormat->setFontSize($options['fontSize']);
        }
        if(isset($options['bold'])){
            $textFormat->setBold($options['bold']);
        }

        if(isset($options['backgroundColor'])) {
            $backgroundColor = new \Google_Service_Sheets_Color();

            if(!is_array($options['backgroundColor'])){
                $options['backgroundColor'] = [$options['backgroundColor'], $options['backgroundColor'], $options['backgroundColor']];
            }

            $backgroundColor->setRed($options['backgroundColor'][0]);
            $backgroundColor->setGreen($options['backgroundColor'][1]);
            $backgroundColor->setBlue($options['backgroundColor'][2]);
            $cellFormat->setBackgroundColor($backgroundColor);
        }

        if(isset($options['foregroundColor'])) {
            $foregroundColor = new \Google_Service_Sheets_Color();

            if(!is_array($options['foregroundColor'])){
                $options['foregroundColor'] = [$options['foregroundColor'], $options['foregroundColor'], $options['foregroundColor']];
            }

            $foregroundColor->setRed($options['foregroundColor'][0]);
            $foregroundColor->setGreen($options['foregroundColor'][1]);
            $foregroundColor->setBlue($options['foregroundColor'][2]);
            $textFormat->setForegroundColor($foregroundColor);
        }

        $cellFormat->setTextFormat($textFormat);

        if(isset($options['breakIntoNewLine']) && $options['breakIntoNewLine']){
            $cellFormat->setWrapStrategy('wrap');
        }

        //Alignments
        if(isset($options['horizontalAlignment'])) {
            $cellFormat->setHorizontalAlignment($options['horizontalAlignment']);
        }
        if(isset($options['verticalAlignment'])) {
            $cellFormat->setVerticalAlignment($options['verticalAlignment']);
        }

        //Number format
        if(isset($options['numberFormat'])){
            $numberFormat = new \Google_Service_Sheets_NumberFormat();
            $numberFormat->setType($options['numberFormat']);
            if(isset($options['numberPattern']))
                $numberFormat->setPattern($options['numberPattern']);
            $cellFormat->setNumberFormat($numberFormat);
        }

        $cellData = new \Google_Service_Sheets_CellData();

        $cellData->setUserEnteredFormat($cellFormat);

        //$rowData = new \Google_Service_Sheets_RowData();
        //$rowData->setValues([$cellData]);
        //$rows[] = $rowData;

        $gridRange = new \Google_Service_Sheets_GridRange();
        $gridRange->setSheetId($sheetId);
        $gridRange->setStartRowIndex($rowStart);
        $gridRange->setEndRowIndex($rowEnd);
        $gridRange->setStartColumnIndex($colStart);
        $gridRange->setEndColumnIndex($colEnd);

        $repeatCell = new \Google_Service_Sheets_RepeatCellRequest();
        $repeatCell->setRange($gridRange);
        $repeatCell->setFields($fields);
        $repeatCell->setCell($cellData);

        //$updateCellsRequest = new \Google_Service_Sheets_UpdateCellsRequest();
        //$updateCellsRequest->setFields($fields);
        //$updateCellsRequest->setRows($rows);
        //$updateCellsRequest->setRange($gridRange);

        $request = new \Google_Service_Sheets_Request();
        //$request->setUpdateCells($updateCellsRequest);
        $request->setRepeatCell($repeatCell);

        return $request;
    }
}
