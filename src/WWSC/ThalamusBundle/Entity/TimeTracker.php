<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="time_tracker")
 */
class TimeTracker //extends Base
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Please enter your comment")
     * @Assert\Length(
     *     min=3,
     *     max=2000,
     *     minMessage="The comment is too short.",
     * )
     */
    private $description;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $person;

    /**
     * @ORM\Column(name="time", type="float", length=255)
     */
    private $time;

    /**
     * @ORM\OneToOne(targetEntity="WWSC\ThalamusBundle\Entity\Comment", inversedBy="time_tracker")
     */
    private $comment;

    /**
     * @ORM\Column(name="billable", type="boolean", nullable=true)
     */
    private $billable = 0;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description) {
        $this->description = utf8_encode($description);

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription() {
        if (preg_match('!!u', utf8_decode($this->description))) {
            return utf8_decode($this->description);
        } else {
            return $this->description;
        }
    }

    /**
     * Set person.
     *
     * @ORM\PrePersist()
     *
     * @param int $person
     *
     * @return TimeTracker
     */
    public function setPerson($person) {
        $this->person = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get person.
     *
     * @return integer
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * Set time.
     *
     * @param \DateTime $time
     *
     * @return TimeTracker
     */
    public function setTime($time) {
        if (false !== strpos($time, ':')) {
            $aTime = explode(':', $time);
            $this->time = $aTime[0] * 60 + $aTime[1];
        } else {
            $this->time = $time * 60;
        }

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime($format = false, $timeDisplay = 'number') {
        if ('minutes' == $timeDisplay) {
            return $this->time;
        }
        if ('hours' == $timeDisplay) {
            return self::convertMinutesToTimeFormat($this->time);
        }
        if ('DE' == $format) {
            return number_format($this->time / 60, 2, ',', ' ');
        }

        return number_format($this->time / 60, 2, '.', ' ');
    }

    /**
     * Set comment.
     *
     * @param \WWSC\ThalamusBundle\Entity\Comment $comment
     *
     * @return TimeTracker
     */
    public function setComment(\WWSC\ThalamusBundle\Entity\Comment $comment = null) {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return \WWSC\ThalamusBundle\Entity\Comment
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * Set created.
     *
     * @param \DateTime $date
     *
     * @return Task
     */
    public function setDateForm($date) {
        $this->date = new \DateTime($date);

        return $this;
    }

    /**
     * Get due_date.
     *
     * @return \DateTime
     */
    public function getDateForm() {
        if ('object' == gettype($this->date)) {
            return $this->date->format('m/d/Y');
        }

        return $this->date;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    public function setUserResponsible($oUser) {
        $this->person = $oUser;

        return $this;
    }

    public static function getUsersForFilterTime() {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $projectIds = $oUser->getProjectsForAccount(true);
        $oCompany = $oUser->getCompany();
        $companyId = $oCompany->getId();
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;

        $projectList = implode("', '", $projectIds);

        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $addRole = "AND comp.id = '$companyId'";
        } else {
            $addRole = "AND comp.roles IN ('ROLE_FREELANCER', 'ROLE_PROVIDER')";
        }

        $sql = "
            SELECT DISTINCT 
            comp.id AS comp_id,
            comp.name AS comp_name,
            comp.roles AS comp_role 
            
            FROM fos_user f0_ 
            INNER JOIN project_user p2_ ON f0_.id = p2_.user_id 
            INNER JOIN project p1_ ON p1_.id = p2_.project_id 
            INNER JOIN company_user c3_ ON ((f0_.id = c3_.user_id)) 
            INNER JOIN company comp ON ((c3_.company_id = comp.id)) 
            
            WHERE p1_.id IN ('$projectList') 
            AND comp.is_deleted = 0 
            AND p1_.closed_project = 0
            AND p1_.is_deleted = 0 
            $addRole
        ";

        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $connection = $em->getConnection();
        $run = $connection->prepare($sql);
        $run->execute();
        $compList = $run->fetchAll();

        $aSubsCompanies = array();

        foreach ($compList as $compItem) {

            $companyId = $compItem['comp_id'];

            // Now get users for company
            $sqlUsers = "
                SELECT DISTINCT 
                users.id AS user_id,
                users.first_name AS user_name,
                users.last_name AS user_surname 
                
                FROM fos_user users 
                INNER JOIN company_user compUser ON users.id = compUser.user_id 
                INNER JOIN project_user projUser ON users.id = projUser.user_id 
                INNER JOIN project proj ON proj.id = projUser.project_id 
                
                WHERE proj.id IN ('$projectList') 
                AND compUser.company_id = '$companyId' 
            ";

            $run = $connection->prepare($sqlUsers);
            $run->execute();
            $usersList = $run->fetchAll();

            foreach ($usersList as $userItem) {

                $aSubsCompanies[$companyId]['id'] = $compItem['comp_id'];
                $aSubsCompanies[$companyId]['name'] = $compItem['comp_name'];
                $aSubsCompanies[$companyId]['role'] = $compItem['comp_role'];
                $aSubsCompanies[$companyId]['people'][$userItem['user_id']] = $userItem['user_name'].' '.$userItem['user_surname'];

            }

        }

        return $aSubsCompanies;
    }

    public static function getReport($project = false, $aFilter = false, $integrateChildRecords = false, $exportToGoogle = false) {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $oCompany = $oUser->getCompany();
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();


        $sql = '';
        $slectProject = '';
        $joinProject = '';
        $whereProject = 't.project_id = '.$project.' AND';
        $columnTaskName = 'ti.description as task_name';
        $orderChildRecords = '';
        $orderAgencyUsers = '';
        $whereComment = '';
        $whereListTask = '';
        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $whereListTask = ' AND t.visible_freelancer = 0';
            $whereComment = ' AND c.private = 0';
        }
        if (!$project) {
            $slectProject = ', p.slug as project_slug, p.name as project_name';
            if (isset($aFilter['include_closed_projects'])) {
                $whereShowClosedProject = '';
            } else {
                $whereShowClosedProject = 'and p.closed_project = 0';
            }
            $joinProject = 'JOIN project as p on (t.project_id = p.id and  p.account_id ='.$accountId.' and  p.is_deleted = 0 '.$whereShowClosedProject.')
                            JOIN project_user as pu on (p.id = pu.project_id and pu.user_id ='.$oUser->getId().')';
            $whereProject = '';
        }

        $joinCompany = 'JOIN company_user as cu on (tt.person_id = cu.user_id ) join company as comp on (cu.company_id = comp.id and comp.account_id ='.$accountId.')';

        if ($integrateChildRecords) {
            $columnTaskName = 'getDescription(ti.id) as task_name';
            $orderChildRecords = ', getPriority(ti.id) ASC';
        }
        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $joinCompany = 'JOIN company_user as cu on (tt.person_id = cu.user_id and cu.company_id = '.$oCompany->getId().') join company as comp on (cu.company_id = comp.id and comp.roles = "ROLE_FREELANCER" and comp.account_id ='.$accountId.')';
        }

        if($exportToGoogle) {
            $selectTotalColumn = 'IF(tt.billable = 1, IF(MOD(ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2), 0.25) > 0,
                                  ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2) + (0.25 - MOD(ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2),0.25)),
                                  ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2)), 0) AS time ';
        }else {
            $selectTotalColumn = 'ROUND(tt.time/60, 2) AS time';
        }
        $selectColumn = $selectTotalColumn.',
                ROUND(tt.time/60, 2) AS hours_original, tt.billable as billable, tt.date as date, c.id as comment_id, t.name as list_name, t.id as list_id, '.$columnTaskName.',
                         ti.id as task_id, comp.name as comp_name,getDescription(IFNULL(ti.parent, ti.id)) as parent_name, u.first_name as person, tt.description, IFNULL(ti.parent, ti.id) as parent, IF(parent_ti.fast_track = 1, 1, ti.fast_track) as fast_track, ti.state'.$slectProject;

        $sql = 'SELECT '.$selectColumn.' FROM time_tracker as tt
             JOIN comment as c on (tt.comment_id = c.id  '.$whereComment.')
             JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem")
             LEFT JOIN taskitem as parent_ti on (parent_ti.id = ti.parent)
             JOIN task as t on (ti.task_id = t.id '.$whereListTask.')
             JOIN fos_user as u on (tt.person_id = u.id) '.$joinProject.$joinCompany;

        $where = ' WHERE '.$whereProject.' c.is_deleted = 0 AND ti.is_deleted = 0 AND t.is_deleted = 0';

        if ($aFilter) {
            if ($aFilter['filter_date_from']) {
                $filterDateFrom = $oUser->convertDateFormat($aFilter['filter_date_from'], 'sql');
                $where .= ' AND tt.date >= "'.$filterDateFrom.' 00:00:01'.'"';
            }
            if ($aFilter['filter_date_to']) {
                $filterDateTo = $oUser->convertDateFormat($aFilter['filter_date_to'], 'sql');
                $where .= ' AND tt.date <= "'.$filterDateTo.' 23:59:59'.'"';
            }
            if (isset($aFilter['filter_person']) && $aFilter['filter_person']) {
                $aFilterPerson = explode('_', $aFilter['filter_person']);
                if ('c' == $aFilterPerson[0]) {
                    $where .= ' AND comp.id = '.$aFilterPerson[1];
                }
                if ('u' == $aFilterPerson[0]) {
                    $where .= ' AND tt.person_id = '.$aFilterPerson[1];
                }
            }
            if ($aFilter['filter_task']) {
                $where .= ' AND ti.id = '.$aFilter['filter_task'];
            }
            if ($aFilter['fast_track']) {
                if ('yes' == $aFilter['fast_track']) {
                    $where .= ' AND IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1';
                } else if ('no' == $aFilter['fast_track']) {
                    $where .= ' AND IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 0';
                }
            }
            if ($aFilter['filter_hide_empty']) {
                $where .= ' AND tt.time != 0';
            }
            if ($aFilter['filter_parent']) {
                $where .= ' AND (ti.parent = '.$aFilter['filter_parent'].' OR ti.id = '.$aFilter['filter_parent'].')';
            }
            if (isset($aFilter['sort_agency_users'])) {
                $orderAgencyUsers .= ' ,FIELD(comp.roles, "ROLE_PROVIDER", "ROLE_FREELANCER")';
            }
            $sql = str_replace('ti.state', 'IF(parent_ti.state, parent_ti.state, ti.state) as state', $sql);
        }
        $orderBy = ' ORDER BY t.project_id ASC '.$orderChildRecords.''.$orderAgencyUsers.', tt.date ASC, ti.id ASC';
        $sql = $sql.$where.$orderBy;

        return WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
    }

    public static function getReportGropedByCompany($project = false, $aFilter = false, $isExport = false) {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $oCompany = $oUser->getCompany();
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();

        if ($project) {
            if ($isExport) {
                $select = 'SUM(ROUND(
					tt.time * 
					(CASE WHEN (
						(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
						= 1) 
					THEN 1.5 ELSE 1 END)
			 		/60, 2)) as total,
                         SUM(ROUND ((CASE WHEN (tt.billable = 1) THEN tt.time * 
					(CASE WHEN (
						(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
						= 1) 
					THEN 1.5 ELSE 1 END) ELSE 0 END)/60, 2)) as billable,
                         SUM(ROUND ((CASE WHEN (tt.billable = 0) THEN tt.time * 
					(CASE WHEN (
						(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
						= 1) 
					THEN 1.5 ELSE 1 END) ELSE 0 END)/60, 2)) as nonbillable,
                         comp.name';

            }
            else {
                $select = 'SUM(ROUND(tt.time/60, 2)) as total,
                         SUM(ROUND((CASE WHEN (tt.billable = 1) THEN tt.time ELSE 0 END)/60, 2)) as billable,
                         SUM(ROUND((CASE WHEN (tt.billable = 0) THEN tt.time ELSE 0 END)/60, 2)) as nonbillable,
                         comp.name';
            }

            $qb->select($select)
                ->from('WWSC\ThalamusBundle\Entity\TimeTracker', 'tt')
                ->join('WWSC\ThalamusBundle\Entity\Comment', 'c', 'WITH', "(tt.comment = c.id and c.type = 'TaskItem' and c.is_deleted = 0)")
                ->join('WWSC\ThalamusBundle\Entity\TaskItem', 'ti', 'WITH', '(c.parent_id = ti.id and ti.is_deleted = 0)')
		->leftjoin('WWSC\ThalamusBundle\Entity\TaskItem', 'parent_ti', 'WITH', '(ti.parent = parent_ti.id)')
                ->join('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(ti.task = t.id and t.is_deleted = 0)')
                ->where('t.project = '.$project);
        } else {
            if ($isExport) {
                $select = 'SUM(ROUND(
				tt.time * 
				(CASE WHEN (
					(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
					= 1) 
				THEN 1.5 ELSE 1 END)
				/60, 2)) as total, 
                         SUM(ROUND ((CASE WHEN (tt.billable = 1) THEN tt.time * 
					(CASE WHEN (
						(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
						= 1) 
					THEN 1.5 ELSE 1 END) ELSE 0 END)/60, 2)) as billable,
                         SUM(ROUND ((CASE WHEN (tt.billable = 0) THEN tt.time * 
					(CASE WHEN (
						(CASE WHEN (parent_ti.fast_track = 1) THEN 1 ELSE ti.fast_track END) 
						= 1) 
					THEN 1.5 ELSE 1 END) ELSE 0 END)/60, 2)) as nonbillable,
                         comp.id as comp_id,
                         comp.name,
                         p.slug as project_slug, 
                         p.name as project_name';
            }
            else {
                $select = 'SUM(ROUND(tt.time/60, 2)) as total, 
                         SUM(ROUND((CASE WHEN (tt.billable = 1) THEN tt.time ELSE 0 END)/60, 2)) as billable,
                         SUM(ROUND((CASE WHEN (tt.billable = 0) THEN tt.time ELSE 0 END)/60, 2)) as nonbillable,
                         comp.id as comp_id,
                         comp.name,
                         p.slug as project_slug, 
                         p.name as project_name';
            }

            if (isset($aFilter['include_closed_projects'])) {
                $whereShowClosedProject = '';
            } else {
                $whereShowClosedProject = 'and p.closed_project = 0';
            }
            $qb->select($select)
                ->from('WWSC\ThalamusBundle\Entity\TimeTracker', 'tt')
                ->join('WWSC\ThalamusBundle\Entity\Comment', 'c', 'WITH', "(tt.comment = c.id and c.type = 'TaskItem' and c.is_deleted = 0)")
                ->join('WWSC\ThalamusBundle\Entity\TaskItem', 'ti', 'WITH', '(c.parent_id = ti.id and ti.is_deleted = 0)')
		->leftjoin('WWSC\ThalamusBundle\Entity\TaskItem', 'parent_ti', 'WITH', '(ti.parent = parent_ti.id)')
                ->join('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(ti.task = t.id and t.is_deleted = 0)')
                ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', '(t.project = p.id and p.is_deleted = 0 '.$whereShowClosedProject.'  and p.account ='.$accountId.')')
                ->join('p.users', 'u')
                ->where('u.id ='.$oUser->getId());
        }
        if ($aFilter) {
            if ($aFilter['filter_date_from']) {
                $filterDateFrom = $oUser->convertDateFormat($aFilter['filter_date_from'], 'sql');
                $filterDateFrom = $filterDateFrom.' 00:00:01';
                $qb->andWhere('tt.date >= :date_from')
                    ->setParameter(':date_from', new \DateTime($filterDateFrom));
            }
            if ($aFilter['filter_date_to']) {
                $filterDateTo = $oUser->convertDateFormat($aFilter['filter_date_to'], 'sql');
                $filterDateTo = $filterDateTo.' 23:59:59';
                $qb->andWhere('tt.date <= :date_to')
                    ->setParameter(':date_to', new \DateTime($filterDateTo));
            }
            if (isset($aFilter['filter_person']) && $aFilter['filter_person']) {
                $aFilterPerson = explode('_', $aFilter['filter_person']);
                if ('c' == $aFilterPerson[0]) {
                    $qb->andWhere('comp.id = :comp_id')
                        ->setParameter(':comp_id', $aFilterPerson[1]);
                }
                if ('u' == $aFilterPerson[0]) {
                    $qb->andWhere('tt.person = :person')
                        ->setParameter(':person', $aFilterPerson[1]);
                }
            }

            if ($aFilter['filter_task']) {
                $qb->andWhere('ti.id = :task_id')
                    ->setParameter(':task_id', $aFilter['filter_task']);
            }
            if ($aFilter['fast_track']) {
                $qb->andWhere('IF(parent_ti.fast_track = 1, 1, ti.fast_track) = :fast_track')
                    ->setParameter(':fast_track', 'yes' == $aFilter['fast_track'] ? true : false );
            }
            if ($aFilter['filter_hide_empty']) {
                $qb->andWhere('tt.time != 0');
            }
            if ($aFilter['filter_parent']) {
                $qb->andWhere('(ti.parent = :parent_task OR ti.id = :parent_task)')
                    ->setParameter(':parent_task', $aFilter['filter_parent']);
            }
        }

        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $qb->andWhere('t.visible_freelancer = 0');
            $qb->andWhere('c.private <> 1');
        }

        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $qb->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(tt.person = cu.user and cu.company = '.$oCompany->getId().')')
                ->join('WWSC\ThalamusBundle\Entity\Company', 'comp', 'WITH', "(cu.company = comp.id and comp.roles = 'ROLE_FREELANCER' and comp.account =".$accountId.')');
        } else {
            $qb->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(tt.person = cu.user)')
                ->join('WWSC\ThalamusBundle\Entity\Company', 'comp', 'WITH', '(cu.company = comp.id and comp.account ='.$accountId.')');
        }
        if (!$project) {
            $qb->groupBy('p.id, comp.id');
        } else {
            $qb->groupBy('comp.id');
        }
        $qb->orderBy('cu.company', 'ASC');
        $critSQL = $qb->getQuery()->execute();
        if ($project) {
            return $critSQL;
        }
        $aProjectGropedByCompany = array();
        $aProjectGropedByCompany['projects_total']['sum'] = 0;
        $aProjectGropedByCompany['projects_total']['billable'] = 0;
        $aProjectGropedByCompany['projects_total']['nonbillable'] = 0;
        foreach ($critSQL as $pGropedByCompany) {
            $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['project_name'] = $pGropedByCompany['project_name'];
            $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['company'][$pGropedByCompany['comp_id']]['name'] = $pGropedByCompany['name'];
            $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['company'][$pGropedByCompany['comp_id']]['total'] = $pGropedByCompany['total'];
            if (isset($aProjectGropedByCompany[$pGropedByCompany['project_slug']]['project_total'])) {
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['project_total'] = $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['project_total'] + $pGropedByCompany['total'];
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_billable'] = $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_billable'] + $pGropedByCompany['billable'];
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_nonbillable'] = $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_nonbillable'] + $pGropedByCompany['nonbillable'];
            } else {
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['project_total'] = $pGropedByCompany['total'];
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_billable'] = $pGropedByCompany['billable'];
                $aProjectGropedByCompany[$pGropedByCompany['project_slug']]['total_nonbillable'] = $pGropedByCompany['nonbillable'];
            }
            $aProjectGropedByCompany['projects_total']['sum'] = $aProjectGropedByCompany['projects_total']['sum'] + $pGropedByCompany['total'];
            $aProjectGropedByCompany['projects_total']['billable'] = $aProjectGropedByCompany['projects_total']['billable'] + $pGropedByCompany['billable'];
            $aProjectGropedByCompany['projects_total']['nonbillable'] = $aProjectGropedByCompany['projects_total']['nonbillable'] + $pGropedByCompany['nonbillable'];
        }

        return $aProjectGropedByCompany;
    }

    public static function getReportGropedByTask($project = false, $aFilter = false, $integrateChildRecords = false, $exportToGoogle = false) {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $oCompany = $oUser->getCompany();
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();

        $slectProject = '';
        if (!$project) {
            $slectProject = ', p.slug as project_slug, p.name as project_name';

            if (isset($aFilter['include_closed_projects'])) {
                $whereShowClosedProject = '';
            } else {
                $whereShowClosedProject = 'and p.closed_project = 0';
            }
        }

        $slectProject = '';
        $joinProject = '';
        $whereProject = 't.project_id = '.$project.' AND';
        $columnTaskName = 'ti.description as task_name';
        $orderChildRecords = '';
        $orderAgencyUsers = '';

        $whereComment = '';
        $whereListTask = '';
        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $whereListTask = ' AND t.visible_freelancer = 0';
            $whereComment = ' AND c.private = 0';
        }

        if (!$project) {
            $slectProject = ', p.slug as project_slug, p.name as project_name';
            $joinProject = 'JOIN project as p on (t.project_id = p.id and  p.account_id ='.$accountId.' '.$whereShowClosedProject.' and p.is_deleted = 0)
                            JOIN project_user as pu on (p.id = pu.project_id and pu.user_id ='.$oUser->getId().')';
            $whereProject = '';
        }
        $joinCompany = 'JOIN company_user as cu on (tt.person_id = cu.user_id ) join company as comp on (cu.company_id = comp.id and comp.account_id ='.$accountId.')';

        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $joinCompany = 'JOIN company_user as cu on (tt.person_id = cu.user_id and cu.company_id = '.$oCompany->getId().') join company as comp on (cu.company_id = comp.id and comp.roles = "ROLE_FREELANCER" and comp.account_id ='.$accountId.')';
        }

        if ($integrateChildRecords) {
            $columnTaskName = 'getDescription(ti.id) as task_name';
            $orderChildRecords = ', getPriority(ti.id) ASC';
        }

        if($exportToGoogle) {
            $selectTotalColumn = 'IF(SUM(IF(tt.billable = 1, tt.time, 0)) > 0, SUM(IF(tt.billable = 1, IF(MOD(ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2), 0.25) > 0,
                                  ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2) + (0.25 - MOD(ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2),0.25)),
                                  ROUND((tt.time * IF(IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1, 1.5, 1))/60, 2)), 0)),
                                  SUM(ROUND(IF(tt.billable = 0, tt.time, 0)/60, 2))) AS total ';
        }else {
            $selectTotalColumn = 'SUM(ROUND(tt.time/60, 2)) AS total ';
        }
        $selectColumn = $selectTotalColumn.',
        SUM(ROUND(tt.time/60, 2)) AS hours_original,
        IF(SUM(IF(tt.billable = 1, tt.time, 0)) > 0, 1, 0) AS billable, MAX(tt.date) as last_track, t.name as list_name,
            t.id as list_id, '.$columnTaskName.', ti.id as task_id, COUNT(comp.id) as count_comp,
            DATE_FORMAT(MAX(tt.date), "%d %c %Y") as last_date, DATE_FORMAT(MAX(tt.date),"%H:%i") as last_time,
            comp.name as comp_name, COUNT(tt.id) as count_tt, COUNT(tt.person_id) as count_person, u.first_name as person,
            tt.description, IFNULL(ti.parent, ti.id) as parent,getDescription(IFNULL(ti.parent, ti.id)) as parent_name, IF(parent_ti.fast_track = 1, 1, ti.fast_track) as fast_track, ti.state'.$slectProject;

        $sql = 'SELECT '.$selectColumn.' FROM time_tracker as tt
             JOIN comment as c on (tt.comment_id = c.id '.$whereComment.')
             JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem")
             LEFT JOIN taskitem as parent_ti on (parent_ti.id = ti.parent)
             JOIN task as t on (ti.task_id = t.id '.$whereListTask.')
             JOIN fos_user as u on (tt.person_id = u.id) '.$joinProject.$joinCompany;

        $where = ' WHERE '.$whereProject.' c.is_deleted = 0 AND ti.is_deleted = 0 AND t.is_deleted = 0';

        if ($aFilter) {
            $date_from = $oUser->convertDateFormat($aFilter['filter_date_from'], 'sql');
            $date_to = $oUser->convertDateFormat($aFilter['filter_date_to'], 'sql');

            if ($aFilter['filter_date_from']) {
                $where .= ' AND tt.date >= "'.$date_from.' 00:00:01'.'"';
            }
            if ($aFilter['filter_date_to']) {
                $where .= ' AND tt.date <= "'.$date_to.' 23:59:59'.'"';
            }
            if (isset($aFilter['filter_person']) && $aFilter['filter_person']) {
                $aFilterPerson = explode('_', $aFilter['filter_person']);
                if ('c' == $aFilterPerson[0]) {
                    $where .= ' AND comp.id = '.$aFilterPerson[1];
                }
                if ('u' == $aFilterPerson[0]) {
                    $where .= ' AND tt.person_id = '.$aFilterPerson[1];
                }
            }
            if ($aFilter['filter_task']) {
                $where .= ' AND ti.id = '.$aFilter['filter_task'];
            }
            if ($aFilter['fast_track']) {
                if ('yes' == $aFilter['fast_track']) {
                    $where .= ' AND IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 1';
                } else if ('no' == $aFilter['fast_track']) {
                    $where .= ' AND IF(parent_ti.fast_track = 1, 1, ti.fast_track) = 0';
                }
            }
            if ($aFilter['filter_hide_empty']) {
                $where .= ' AND tt.time != 0';
            }
            if ($aFilter['filter_parent']) {
                $where .= ' AND (ti.parent = '.$aFilter['filter_parent'].' OR ti.id = '.$aFilter['filter_parent'].')';
            }
            if (isset($aFilter['sort_agency_users'])) {
                $orderAgencyUsers .= ' ,FIELD(comp.roles, "ROLE_PROVIDER", "ROLE_FREELANCER")';
            }
        }

        if ($aFilter['group_by_public_id']) {
            $sql = str_replace('ti.state', 'IF(parent_ti.state, parent_ti.state, ti.state) as state', $sql);
            $orderBy = ' GROUP BY IFNULL(ti.parent, ti.id) ORDER BY t.project_id ASC '.$orderChildRecords.''.$orderAgencyUsers.',last_date ASC, parent ASC, last_time ASC';
        } else {
            $orderBy = ' GROUP BY ti.id ORDER BY t.project_id ASC '.$orderChildRecords.''.$orderAgencyUsers.',last_date ASC, task_id ASC, last_time ASC';
        }
        $sql = $sql.$where.$orderBy;

        return WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
    }

    public static function getTimeTrackToday($type = 'user', $userId = false) {
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $filterDateFrom = date('Y-m-d').' 00:00:01';
        $filterDateTo = date('Y-m-d').' 23:59:59';
        switch ($type) {
            case 'user':
                $sql = 'SELECT SUM(tt.time) as total
                        FROM time_tracker AS tt
                        JOIN comment as c on (tt.comment_id = c.id and  c.is_deleted = 0)
                        JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem" and ti.is_deleted = 0)
                        JOIN task as t on (ti.task_id = t.id  and t.is_deleted = 0)
                        JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')
                        WHERE tt.date >="'.$filterDateFrom.'" and tt.date <= "'.$filterDateTo.'" and tt.person_id ='.$userId.'';
                break;
            case 'company':
                $sql = 'SELECT SUM(tt.time) as total
                        FROM time_tracker AS tt
                        JOIN comment as c on (tt.comment_id = c.id and  c.is_deleted = 0)
                        JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem"  and ti.is_deleted = 0)
                        JOIN task as t on (ti.task_id = t.id  and t.is_deleted = 0)
                        JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')
                        JOIN company_user AS cu ON (tt.person_id = cu.user_id)
                        JOIN company AS comp ON (cu.company_id = comp.id AND comp.account_id = '.$accountId.' and comp.roles ="ROLE_PROVIDER")
                        WHERE tt.date >="'.$filterDateFrom.'" and tt.date <= "'.$filterDateTo.'"';
                break;
        }

        $critSQL = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        if (isset($critSQL[0]['total']) && $critSQL[0]['total']) {
            $hours = floor($critSQL[0]['total'] / 60);
            $minutes = $critSQL[0]['total'] % 60;
            $hours < 10 ? $hours = '0'.$hours : $hours;
            $minutes < 10 ? $minutes = '0'.$minutes : $minutes;

            return $hours.':'.$minutes;
        } else {
            return '00:00';
        }
    }

    public static function getPersonalTimetracking($filterDate = false, $total = false, $userId = null) {
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($userId || $userId = WWSCThalamusBundle::getContainer()->get('session')->get('userPersonalTimetracking')) {
            $oUser = $entityManager->getRepository('WWSCThalamusBundle:User')->find($userId);
        } else {
            $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        }

        $qb = $entityManager->createQueryBuilder();

        if (!$filterDate) {
            $filterDate = date('Y-m-d');
        } else {
            $filterDate = date('Y-m-d', strtotime($filterDate));
        }

        if ($total) {
            $sql = 'SELECT ROUND(SUM(IF(tt.billable = 1 ,tt.time/60 ,0)),2) as total_billable_hours,
                    ROUND(SUM(IF(tt.billable = 0 ,tt.time/60 ,0)),2) as total_non_billable_hours
            FROM time_tracker AS tt
            JOIN comment as c on (tt.comment_id = c.id and  c.is_deleted = 0)
            JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem" and ti.is_deleted = 0)
            JOIN task as t on (ti.task_id = t.id  and t.is_deleted = 0)
            JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')
            WHERE DATE(tt.date) ="'.$filterDate.'" and tt.person_id ='.$oUser->getId().' and tt.time > 0';
        } else {
            $sql = 'SELECT tt.id as track_id, ti.id as task_id, ti.description as task_description, t.id as task_list_id,  tt.time as time, tt.date as date, tt.billable as billable,
                p.name as project_name, p.slug as project_slug
            FROM time_tracker AS tt
            JOIN comment as c on (tt.comment_id = c.id and  c.is_deleted = 0)
            JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem" and ti.is_deleted = 0)
            JOIN task as t on (ti.task_id = t.id  and t.is_deleted = 0)
            JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')
            WHERE DATE(tt.date) ="'.$filterDate.'" and tt.person_id ='.$oUser->getId().' and tt.time > 0';
        }
        $critPersonalTimetrackings = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
        if ($total) {
            return $critPersonalTimetrackings;
        }
        $aPersonalTimetrackings = array();
        foreach ($critPersonalTimetrackings as $aTimetrack) {
            $urlProject = WWSCThalamusBundle::getContainer()->get('router')->generate(
                'wwsc_thalamus_project_overview', array(
                    'project' => $aTimetrack['project_slug'],
                )
            );
            $urlTask = WWSCThalamusBundle::getContainer()->get('router')->generate(
                'wwsc_thalamus_project_task_item_comments', array(
                    'project' => $aTimetrack['project_slug'],
                    'task' => $aTimetrack['task_list_id'],
                    'id' => $aTimetrack['task_id'],
                )
            );

            $endTime = new \DateTime($aTimetrack['date']);
            $startTime = new \DateTime($aTimetrack['date']);
            $startTime->modify('- '.$aTimetrack['time'].' minutes');

            $diff = $endTime->diff($startTime);

            $tooltip = '<div class="tooltip-fullCalendar" style="height: auto"> <a class="project-name" href="'.$urlProject.'">'.$aTimetrack['project_name'].'</a>
                       <br><a class="task-name" href="'.$urlTask.'">'.$aTimetrack['task_description'].'('.$aTimetrack['task_id'].')</a></p>
                       <p>'.$startTime->format('H:i').'-'.$endTime->format('H:i').' ('.$diff->h.'h'.$diff->i.'m)</p></div>';
            $aPersonalTimetracking = array(
                'id' => $aTimetrack['track_id'],
                'title' => '#'.$aTimetrack['task_id'],
                'tooltip' => $tooltip,
            );

            $end = date('Y-m-d', strtotime($aTimetrack['date'])).'T'.date('H:i:s', strtotime($aTimetrack['date']));
            $aPersonalTimetracking['end'] = $end;
            $dateStart = date('Y-m-d H:i:s', strtotime('-'.round($aTimetrack['time']).' minutes', strtotime($aTimetrack['date'])));
            $dateStart = date('Y-m-d', strtotime($dateStart)).'T'.date('H:i:s', strtotime($dateStart));
            $aPersonalTimetracking['start'] = $dateStart;

            if ($aTimetrack['billable']) {
                $aPersonalTimetracking['backgroundColor'] = '#0099FF';
            } else {
                $aPersonalTimetracking['backgroundColor'] = '#FF6633';
            }
            $url = WWSCThalamusBundle::getContainer()->get('router')->generate(
                'wwsc_thalamus_edit_personal_timetracking', array(
                    'id' => $aTimetrack['track_id'],
                )
            );
            $aPersonalTimetracking['url'] = $url;
            array_push($aPersonalTimetrackings, $aPersonalTimetracking);
        }

        return $aPersonalTimetrackings;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return TimeTracker
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Set billable.
     *
     * @param bool $billable
     *
     * @return TimeTracker
     */
    public function setBillable($billable) {
        $this->billable = $billable;

        return $this;
    }

    /**
     * Get billable.
     *
     * @return boolean
     */
    public function getBillable() {
        return $this->billable;
    }

    public function getStartTime() {
        $dateTracker = $this->getDate()->format('Y-m-d H:i:s');
        $startTime = date('Y-m-d H:i:s', strtotime('-'.round($this->getTime(false, 'minutes')).' minutes', strtotime($dateTracker)));
        $startTime = date('H:i', strtotime($startTime));

        return $startTime;
    }

    public function getEndTime() {
        $endTime = $this->getDate()->format('H:i');

        return $endTime;
    }

    public static function getSumPersonalTrackedHours($type = 'personal') {
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($userId = WWSCThalamusBundle::getContainer()->get('session')->get('userPersonalTimetracking')) {
            $oUser = $entityManager->getRepository('WWSCThalamusBundle:User')->find($userId);
        } else {
            $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        }
        $companyId = $oUser->getCompany()->getId();
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $filterDate = date('Y-m-d');
        $sql = 'SELECT
                    ROUND(SUM(case when (tt.billable = 1 and DATE_FORMAT(NOW(),"%Y-%m-%d") = DATE_FORMAT(tt.date,"%Y-%m-%d"))  then ROUND (tt.time/60,2) else 0 end),2) as total_day_billable_hours,
                    ROUND(SUM(case when (tt.billable = 0 and DATE_FORMAT(NOW(),"%Y-%m-%d") = DATE_FORMAT(tt.date,"%Y-%m-%d"))  then ROUND (tt.time/60,2) else 0 end),2) as total_day_non_billable_hours,
                    ROUND(SUM(case when (DATE_FORMAT(NOW(),"%Y-%m-%d") = DATE_FORMAT(tt.date,"%Y-%m-%d"))  then ROUND (tt.time/60,2) else 0 end),2)  as total_day_all_hours,

                    ROUND(SUM(case when (tt.billable = 1 and YEARWEEK(tt.date, 1) = YEARWEEK(NOW(), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_week_billable_hours,
                    ROUND(SUM(case when (tt.billable = 0 and YEARWEEK(tt.date, 1) = YEARWEEK(NOW(), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_week_non_billable_hours,
                    ROUND(SUM(case when (YEARWEEK(tt.date, 1) = YEARWEEK(NOW(), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_week_all_hours,
                    
                    ROUND(SUM(case when (tt.billable = 1 and YEARWEEK(tt.date, 1) = YEARWEEK(DATE_ADD(NOW(), INTERVAL - 7 DAY), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_last_week_billable_hours,
                    ROUND(SUM(case when (tt.billable = 0 and YEARWEEK(tt.date, 1) = YEARWEEK(DATE_ADD(NOW(), INTERVAL - 7 DAY), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_last_week_non_billable_hours,
                    ROUND(SUM(case when (YEARWEEK(tt.date, 1) = YEARWEEK(DATE_ADD(NOW(), INTERVAL - 7 DAY), 1))  then ROUND (tt.time/60,2) else 0 end),2) as total_last_week_all_hours,

                    ROUND(SUM(case when (tt.billable = 1 and DATE_FORMAT(NOW(),"%Y-%m") = DATE_FORMAT(tt.date,"%Y-%m"))  then ROUND (tt.time/60,2) else 0 end),2) as total_month_billable_hours,
                    ROUND(SUM(case when (tt.billable = 0 and DATE_FORMAT(NOW(),"%Y-%m") = DATE_FORMAT(tt.date,"%Y-%m"))  then ROUND (tt.time/60,2) else 0 end),2) as total_month_non_billable_hours,
                    ROUND(SUM(case when (DATE_FORMAT(NOW(),"%m") = DATE_FORMAT(tt.date,"%m"))  then ROUND (tt.time/60,2) else 0 end),2)  as total_month_all_hours,
                    
                    ROUND(SUM(case when (tt.billable = 1 and DATE_FORMAT(NOW(),"%m") < DATE_FORMAT(DATE_ADD(tt.date,INTERVAL -1 MONTH),"%m"))  then ROUND (tt.time/60,2) else 0 end),2) as total_last_month_billable_hours,
                    ROUND(SUM(case when (tt.billable = 0 and DATE_FORMAT(NOW(),"%m") < DATE_FORMAT(DATE_ADD(tt.date,INTERVAL -1 MONTH),"%m"))  then ROUND (tt.time/60,2) else 0 end),2) as total_last_month_non_billable_hours,
                    ROUND(SUM(case when (DATE_FORMAT(NOW(),"%m") < DATE_FORMAT(DATE_ADD(tt.date,INTERVAL -1 MONTH),"%m"))  then ROUND (tt.time/60,2) else 0 end),2)  as total_last_month_all_hours,

                    ROUND(SUM(IF(tt.billable = 1 ,tt.time/60 ,0)),2) as total_year_billable_hours,
                    ROUND(SUM(IF(tt.billable = 0 ,tt.time/60 ,0)),2) as total_year_non_billable_hours,
                    ROUND(SUM(tt.time/60),2) as total_year_all_hours

            FROM time_tracker AS tt
            JOIN comment as c on (tt.comment_id = c.id and  c.is_deleted = 0)
            JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem" and ti.is_deleted = 0)
            JOIN task as t on (ti.task_id = t.id  and t.is_deleted = 0)
            JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')';

        switch ($type) {
            case 'personal':
                $sql .= ' WHERE DATE_FORMAT(NOW(),"%Y") = DATE_FORMAT(tt.date,"%Y") and tt.person_id ='.$oUser->getId().' and tt.time > 0';
                break;
            case 'company':
                $sql .= 'JOIN company_user as cu on (tt.person_id  = cu.user_id and cu.enabled = 1)  WHERE DATE_FORMAT(NOW(),"%Y") = DATE_FORMAT(tt.date,"%Y") and cu.company_id ='.$companyId.' and tt.time > 0';
                break;
            case 'account':
                $sql .= ' WHERE DATE_FORMAT(NOW(),"%Y") = DATE_FORMAT(tt.date,"%Y") and tt.time > 0';
                break;
        }
        $critSQL = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        $aSumPersonalTrackedHours = $critSQL[0];
        $aSumPersonalTrackedHours['productivity_year'] = $aSumPersonalTrackedHours['total_year_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_year_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_year_all_hours']) : 0;
        $aSumPersonalTrackedHours['productivity_month'] = $aSumPersonalTrackedHours['total_month_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_month_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_month_all_hours']) : 0;
        $aSumPersonalTrackedHours['productivity_week'] = $aSumPersonalTrackedHours['total_week_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_week_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_week_all_hours']) : 0;
        $aSumPersonalTrackedHours['productivity_day'] = $aSumPersonalTrackedHours['total_day_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_day_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_day_all_hours']) : 0;
        $aSumPersonalTrackedHours['productivity_last_week'] = $aSumPersonalTrackedHours['total_last_week_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_last_week_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_last_week_all_hours']) : 0;
        $aSumPersonalTrackedHours['productivity_last_month'] = $aSumPersonalTrackedHours['total_last_month_all_hours'] > 0 ? floor($aSumPersonalTrackedHours['total_last_month_billable_hours'] * 100 / $aSumPersonalTrackedHours['total_last_month_all_hours']) : 0;

        return $aSumPersonalTrackedHours;
    }

    public static function convertMinutesToTimeFormat($time,  $leadingZeros = true ){
        $hours = floor($time / 60);
        $minutes = $time % 60;
        if($leadingZeros) {
            $hours < 10 ? $hours = '0'.$hours : $hours;
        }
        $minutes < 10 ? $minutes = '0'.$minutes : $minutes;

        return $hours.':'.$minutes;
    }
}
