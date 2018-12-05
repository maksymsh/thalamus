<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use WWSC\ThalamusBundle\Entity\Comment as Comments;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * taskItem.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="taskitem", indexes={@ORM\Index(columns={"description"}, flags={"fulltext"})})
 */
class TaskItem extends Base
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_uid", type="string", length=255, nullable=true)
     */
    private $replyUID;

    /**
     * @var string
     *
     * @ORM\Column(name="parent",  type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Please enter your item description.")
     * @Assert\Length(
     *     min=3,
     *     minMessage="The description item is too short.",
     * )
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User", inversedBy="responsible")
     */
    private $responsible;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Task", inversedBy="task")
     */
    private $task;

    /**
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $due_date;

    private $save_to_log = 1;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="annotations", type="text", nullable=true)
     */
    private $annotations;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_tasks", type="integer", nullable=true)
     */
    private $sort_tasks = 0;

    /**
     * Constructor.
     */
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user_created;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user_updated;

    /**
     * @var bool
     *
     * @ORM\Column(name="fast_track", type="boolean", nullable=true)
     */
    private $fast_track;

    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(name="recursive", type="boolean", nullable=true)
     */
    private $recursive = 0;

    /**
     * @ORM\Column(name="show_description_recursive", type="boolean", nullable=true)
     */
    private $show_description_recursive = 0;

    /**
     * @ORM\Column(name="day_of_recursion", type="integer", nullable=true)
     */
    private $day_of_recursion = 1;

    /**
     * @ORM\Column(name="days_weekly_of_recursion", type="string", length=255, nullable=true)
     */
    private $days_weekly_of_recursion;

    /**
     * @ORM\Column(name="type_recursion", type="integer", nullable=true)
     */
    private $type_period_recursion = 1;

    /**
     * @ORM\Column(name="estimated", type="float", length=255, nullable=true)
     */
    private $estimated;

    /**
     * @ORM\Column(name="recurring_task_list", type="integer", nullable=true)
     */
    private $recurring_task_list = 0;

    /**
     * @ORM\Column(name="month_of_recursion", type="integer", nullable=true)
     */
    private $month_of_recursion = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="description_recursive", type="text", nullable=true)
     */
    private $description_recursive;

    private $comments;

    /**
     * @ORM\Column(name="google_drive_item_folder_id", type="string", length=64, nullable=true)
     */
    private $google_drive_item_folder_id;

    public static $states = array
    (
        'READY_FOR_BRIEFING' => 'Ready for briefing',
        'IN_PROGRESS' => 'In Progress',
        'BILLED' => 'Billed',
        'ON_HOLD' => 'on Hold',
        'WAITING_FOR_FEEDBACK' => 'Waiting for feedback',
        'WAITING_FOR_APPROVAL' => 'Waiting for approval',
        'CLOSED' => 'Closed',
    );

    public static function statusConvert($status)
    {
        // Array of statuses
        $convert = [
            'READY_FOR_BRIEFING' => 'Ready for briefing',
            'IN_PROGRESS' => 'In Progress',
            'BILLED' => 'Billed',
            'ON_HOLD' => 'on Hold',
            'WAITING_FOR_FEEDBACK' => 'Waiting for feedback',
            'WAITING_FOR_APPROVAL' => 'Waiting for approval',
            'CLOSED' => 'Closed'
        ];

        // Convert
        $result = strtr($status, $convert);

        return $result;
    }

    public static $aTypePeriodRecursion = array(
        '0' => 'weekly',
        '1' => 'every month',
        '3' => 'every quarter',
        '6' => 'every half-year',
        '12' => 'every year',
    );

    public static $aDaysWeekly = array(
        '1' => 'Mo',
        '2' => 'Tue',
        '3' => 'Wed',
        '4' => 'Thur',
        '5' => 'Fri',
        '6' => 'Sat',
        '7' => 'Son',
    );

    /**
     * Get id.
     *
     * @return int
     */
    public static function getDayMonth()
    {
        $aDaysMonth = array();
        for ($i = 1; $i <= 31; ++$i) {
            $aDaysMonth[$i] = $i;
        }

        return $aDaysMonth;
    }

    public static function getMonth()
    {
        $aMonth = array();
        for ($i = 1; $i <= 12; ++$i) {
            $aMonth[$i] = date('F', mktime(0, 0, 0, $i, 10));
        }

        return $aMonth;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return TaskItem
     */
    public function setDescription($description)
    {
        $this->description = utf8_encode($description);

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription($type = 'full-text')
    {
        $description = $this->description;
        if (preg_match('!!u', utf8_decode($this->description))) {
            $description = utf8_decode($this->description);
        }
        if ('short-text' == $type && strlen($description) > 55) {
            $description = substr($description, 0, 55);
            $description = trim($description);

            return $description . '...';
        }

        return $description;
    }

    /**
     * Get due_date.
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    public function setDueDateForm($dueDate)
    {
        if ('de' == WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getLanguageCode()) {
            $this->due_date = \DateTime::createFromFormat('d/m/Y', $dueDate);
        } else {
            $this->due_date = new \DateTime($dueDate);
        }

        return $this;
    }

    /**
     * Get due_date.
     *
     * @return \DateTime
     */
    public function getDueDateForm()
    {
        if ('object' == gettype($this->due_date)) {
            if ('de' == WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getLanguageCode()) {
                return $this->due_date->format('d/m/Y');
            }

            return $this->due_date->format('m/d/Y');
        }

        return $this->due_date;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return TaskItem
     */
    public function setStatus($status, $saveToLog = true)
    {
        $this->status = $status;
        $this->save_to_log = $saveToLog;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sort.
     *
     * @param int $sort
     *
     * @return TaskItem
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set sort_tasks.
     *
     * @param int $sortTasks
     *
     * @return TaskItem
     */
    public function setSortTasks($sortTasks)
    {
        $this->sort_tasks = $sortTasks;

        return $this;
    }

    /**
     * Get sort_tasks.
     *
     * @return int
     */
    public function getSortTasks()
    {
        return $this->sort_tasks;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return TaskItem
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return TaskItem
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set user_created.
     *
     * @ORM\PrePersist()
     *
     * @param \WWSC\ThalamusBundle\Entity\User $userCreated
     *
     * @return Company
     */
    public function setUserCreated($userCreated)
    {
        $this->user_created = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get user_created.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserCreated()
    {
        return $this->user_created;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate
     * Set user_updated
     *
     * @param \WWSC\ThalamusBundle\Entity\User $userUpdated
     *
     * @return Company
     */
    public function setUserUpdated($userUpdated)
    {
        $this->user_updated = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get user_updated.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserUpdated()
    {
        return $this->user_updated;
    }

    /**
     * Set is_deleted.
     *
     * @param bool $isDeleted
     *
     * @return TaskItem
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        if (1 == $isDeleted) {
            if ($this->getComments()) {
                foreach ($this->getComments() as $item) {
                    $item->setIsDeleted(1);
                }
            }
        }

        return $this;
    }

    /**
     * Get is_deleted.
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set responsible.
     *
     * @param \WWSC\ThalamusBundle\Entity\User $responsible
     *
     * @return TaskItem
     */
    public function setResponsible(\WWSC\ThalamusBundle\Entity\User $responsible = null, $saveToLog = true)
    {
        $this->responsible = $responsible;
        $this->save_to_log = $saveToLog;

        return $this;
    }

    /**
     * Get responsible.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getResponsible()
    {
        return $this->responsible;
    }

    /**
     * Set task.
     *
     * @param \WWSC\ThalamusBundle\Entity\Task $task
     *
     * @return TaskItem
     */
    public function setTask(\WWSC\ThalamusBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task.
     *
     * @return \WWSC\ThalamusBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments($type = 'list')
    {
        $activeUserCompany = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getCompany();
        /**
         * @var \Doctrine\ORM\QueryBuilder $qb
         */
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        if ('count' == $type) {
            $qb->select('COUNT(c.id)');
        } else {
            $qb->select('c');
        }
        $qb->from('WWSC\ThalamusBundle\Entity\Comment', 'c')
            ->where('c.is_deleted = 0')
            ->andWhere("c.type = 'TaskItem'")
            ->andWhere('c.parent_id = ' . $this->getId());
        if ('ROLE_PROVIDER' != $activeUserCompany->getRoles() || WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $qb->andWhere('c.private <> 1');
        }
        $qb->orderBy('c.updated', 'ASC');
        if ('count' == $type) {
            return $qb->getQuery()->getSingleScalarResult();
        }

        return $qb->getQuery()->getResult();
    }

    public function getSumHoursTimeTracker()
    {
        $sumHours = 0;
        foreach ($this->getComments() as $oComment) {
            if ($oComment->getTimeTracker()) {
                $sumHours = $sumHours + $oComment->getTimeTracker()->getTime();
            }
        }
        if ($sumHours <= 0) {
            return 0;
        }

        return round($sumHours, 2);
    }

    public function getSumHoursAllChildren()
    {
        try {
            $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
            $aChildrenTasksIds = WWSCThalamusBundle::getContainer()->get('database_connection')->query('Select getChildrenTasksIds(' . $this->getId() . ') as aChildrenTasksIds')->fetchAll();
            $aChildrenTasksIds = $aChildrenTasksIds[0]['aChildrenTasksIds'];
            $sql = ' SELECT ROUND(SUM(tt.time / 60),2) as sumHoursAllChildren';
            $sql .= ' FROM taskitem AS ti';
            $sql .= ' Left JOIN comment AS c on(ti.id IN (' . $aChildrenTasksIds . ') AND ti.id = c.parent_id and c.type= "TaskItem" AND c.is_deleted= 0 AND ti.is_deleted=0)';
            $sql .= ' JOIN time_tracker as tt on(c.id = tt.comment_id)';
            $aAllSumHours = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

            return $aAllSumHours[0]['sumHoursAllChildren'];
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Set int sort.
     *
     * @ORM\PrePersist()
     */
    public function setSortNewElem()
    {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $crit = array(
            'is_deleted' => 0,
            'status' => 0,
            'task' => $this->task,
        );
        $oItem = $entityManager->getRepository('WWSCThalamusBundle:TaskItem')->findOneBy($crit, array('sort' => 'DESC'));
        if ($oItem && 1 != $this->getFastTrack()) {
            $this->setSort($oItem->getSort() + 1);
        } else {
            $this->setSort(0);
        }
    }

    private function getLogInfoByTaskItem($entity)
    {
        if (!$entity->save_to_log) {
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        $url = WWSCThalamusBundle::getContainer()->get('router')->generate(
            'wwsc_thalamus_project_task_item_comments', array(
                'project' => $entity->getTask()->getProject()->getSlug(),
                'task' => $entity->getTask()->getId(),
                'id' => $entity->getId(),
            )
        );
        $aRes['description'] = "<a href='" . $url . "'>" . $this->truncation($entity->getDescription(), 100) . '</a>';
        $aRes['project'] = $entity->getTask()->getProject();

        return $aRes;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if (!$args->hasChangedField('is_deleted')) {
            $aParams = $this->getLogInfoByTaskItem($args->getEntity());
            $aParams['action'] = 'Updated by';
            $this->things[] = $aParams;
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if ($aParams = $this->getLogInfoByTaskItem($args->getEntity())) {
            $aParams['action'] = 'Posted by';
            $this->saveLog($aParams);
        }
    }

    public function getActiveSubscribed($typeShow = 'id', $privateComment = 0)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $critSubspeople = $em->getRepository('WWSCThalamusBundle:SubscribeEmail')->findBy(array('type' => 'TaskItem', 'parent' => $this->id));
        $aSubspeople = array();
        if ('id' == $typeShow) {
            foreach ($critSubspeople as $oSubsPeople) {
                $aSubspeople[$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getId();
            }
        }
        if ('info' == $typeShow) {
            foreach ($critSubspeople as $oSubsPeople) {
                if (1 != $privateComment || 'ROLE_PROVIDER' == $oSubsPeople->getUser()->getCompany()->getRoles()) {
                    $aSubspeople['email'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getEmail();
                    $aSubspeople['lang'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getLanguageCode();
                    $aSubspeople['name'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getFirstName() . ' ' . $oSubsPeople->getUser()->getLastName();
                }
            }
        }
        if ('company-info' == $typeShow) {
            foreach ($critSubspeople as $oSubsPeople) {
                if ($oSubsPeople->getUser()->getCompany()) {
                    $aSubspeople[$oSubsPeople->getUser()->getCompany()->getName()][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getFirstName() . ' ' . $oSubsPeople->getUser()->getLastName();
                }
            }
        }

        return $aSubspeople;
    }

    /**
     * @ORM\PrePersist()
     * Set replyUID
     *
     * @param string $replyUID
     *
     * @return $replyUID
     */
    public function setReplyUID($replyUID)
    {
        $this->replyUID = 'ti_'
            . $this->getId()
            . md5(uniqid(rand(), true));
        WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->flush();

        return $this;
    }

    /**
     * Get replyUID.
     *
     * @return string
     */
    public function getReplyUID()
    {
        return $this->replyUID;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return TaskItem
     */
    public function setState($state, $saveToLog = true)
    {
        $this->state = $state;
        $status = 'CLOSED' == $state ? 1 : 0;
        $this->setStatus($status);
        $this->save_to_log = $saveToLog;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    public function getStateValue()
    {
        if (isset(self::$states[$this->getState()])) {
            return self::$states[$this->getState()];
        }

        return $this->state;
    }

    /**
     * Set parent.
     *
     * @param string $parent
     *
     * @return TaskItem
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get parent.
     *
     * @return string
     */
    public function getParentTask()
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($this->getParent()) {
            return $em->getRepository('WWSCThalamusBundle:TaskItem')->find($this->getParent());
        }

        return false;
    }

    public function getChildTasks()
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();

        return $em->getRepository('WWSCThalamusBundle:TaskItem')->findBy(array('parent' => $this->getId()));
    }

    /**
     * Set due_date.
     *
     * @param \DateTime $dueDate
     *
     * @return TaskItem
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = $dueDate;

        return $this;
    }

    /**
     * Set fast_track.
     *
     * @param bool $fastTrack
     *
     * @return TaskItem
     */
    public function setFastTrack($fastTrack)
    {
        $this->fast_track = $fastTrack;

        return $this;
    }

    /**
     * Get fast_track.
     *
     * @return bool
     */
    public function getFastTrack()
    {
        return $this->fast_track;
    }

    public function getDaysAfterLastFeedback()
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($lastCommentsUpdate = $em->getRepository('WWSCThalamusBundle:Comment')->findOneBy(
            array(
                'type' => 'TaskItem',
                'parent_id' => $this->getId(),
            ), array(
            'updated' => 'DESC',
        ))
        ) {
            $lastFeedback = (int)((strtotime('now') - strtotime($lastCommentsUpdate->getUpdated()->format('Y-m-d'))) / (60 * 60 * 24));
            if ($lastFeedback > 0) {
                if ($lastFeedback > 1) {
                    return $lastFeedback . ' days';
                } else {
                    return $lastFeedback . ' day';
                }
            }
        }

        return false;
    }

    public function saveLastVisitToTask()
    {
        $userId = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($lastVisitToTask = $em->getRepository('WWSCThalamusBundle:LastVisitToTask')->findOneBy(array('user' => $userId, 'task' => $this->getId()))) {
            $lastVisitToTask->setDate(new \DateTime('now'));
            $em->flush();
        } else {
            $lastVisit = new \WWSC\ThalamusBundle\Entity\LastVisitToTask ();
            $lastVisit->setUser($userId);
            $lastVisit->setTask($this->getId());
            $lastVisit->setDate(new \DateTime('now'));
            $em->persist($lastVisit);
            $em->flush();
        }
    }

    public function getIconComments()
    {
        $userId = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($lastVisitToTask = $em->getRepository('WWSCThalamusBundle:LastVisitToTask')->findOneBy(array('user' => $userId, 'task' => $this->getId()))) {
            $lastCommentsUpdate = $em->getRepository('WWSCThalamusBundle:Comment')->findOneBy(array('type' => 'TaskItem', 'parent_id' => $this->getId()), array('updated' => 'DESC'));
            if ($lastCommentsUpdate->getUpdated() <= $lastVisitToTask->getDate()) {
                return '/bundles/wwscthalamus/images/icon-comment.png';
            }
        }

        return '/bundles/wwscthalamus/images/icon-comment_not_show.png';
    }

    public function getInfo()
    {
        return array(
            'id' => $this->getId(),
            'fastTrack' => $this->getFastTrack(),
            'countComments' => $this->getComments('count'),
            'iconComments' => $this->getIconComments(),
            'daysAfterLastFeedback' => $this->getDaysAfterLastFeedback(),
            'percentOfMoneyLeft' => $this->getPercentOfMoneyLeft(),
            'responsible' => $this->getResponsible()->getFirstName() . ' ' . $this->getResponsible()->getLastName(),
            'description' => $this->getDescription(),
            'state' => $this->getStateValue(),
            'updated' => $this->getUpdated(),
        );
    }

    /**
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return TaskItem
     */
    public function setSaveToLog($saveToLog)
    {
        $this->save_to_log = $saveToLog;

        return $this;
    }

    /**
     * Get saveToLog.
     *
     * @return bool
     */
    public function getSaveToLog()
    {
        return $this->save_to_log;
    }

    /**
     * Set recursive.
     *
     * @param bool $recursive
     *
     * @return TaskItem
     */
    public function setRecursive($recursive)
    {
        $this->recursive = $recursive;

        return $this;
    }

    /**
     * Get recursive.
     *
     * @return bool
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * Set showDescriptionRecursive.
     *
     * @param bool $showDescriptionRecursive
     *
     * @return TaskItem
     */
    public function setShowDescriptionRecursive($showDescriptionRecursive)
    {
        $this->show_description_recursive = $showDescriptionRecursive;

        return $this;
    }

    /**
     * Get showDescriptionRecursive.
     *
     * @return bool
     */
    public function getShowDescriptionRecursive()
    {
        return $this->show_description_recursive;
    }

    /**
     * Set dayOfRecursion.
     *
     * @param int $dayOfRecursion
     *
     * @return TaskItem
     */
    public function setDayOfRecursion($dayOfRecursion)
    {
        $this->day_of_recursion = $dayOfRecursion;

        return $this;
    }

    /**
     * Get dayOfRecursion.
     *
     * @return int
     */
    public function getDayOfRecursion()
    {
        return $this->day_of_recursion;
    }

    /**
     * Set descriptionRecursive.
     *
     * @param string $descriptionRecursive
     *
     * @return TaskItem
     */
    public function setDescriptionRecursive($descriptionRecursive)
    {
        $this->description_recursive = $descriptionRecursive;

        return $this;
    }

    /**
     * Get descriptionRecursive.
     *
     * @return string
     */
    public function getDescriptionRecursive()
    {
        return $this->description_recursive;
    }

    /**
     * Set recurringTaskList.
     *
     * @param int $recurringTaskList
     *
     * @return TaskItem
     */
    public function setRecurringTaskList($recurringTaskList)
    {
        $this->recurring_task_list = $recurringTaskList;

        return $this;
    }

    /**
     * Get recurringTaskList.
     *
     * @return int
     */
    public function getRecurringTaskList()
    {
        return $this->recurring_task_list;
    }

    public static function getArrayRecurringTaskList($projectId, $taskId)
    {
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('t.id as task_list_id, t.name as task_list_name')
            ->from('WWSC\ThalamusBundle\Entity\Task', 't')
            ->where('t.is_deleted = 0')
            ->andWhere('t.project = ' . $projectId)
            ->andWhere('t.id <> ' . $taskId);

        $aTaskList = array();
        foreach ($qb->getQuery()->execute() as $aTask) {
            $aTaskList[$aTask['task_list_id']] = $aTask['task_list_name'];
        }

        return $aTaskList;
    }

    /**
     * Set monthOfRecursion.
     *
     * @param int $monthOfRecursion
     *
     * @return TaskItem
     */
    public function setMonthOfRecursion($monthOfRecursion)
    {
        $this->month_of_recursion = $monthOfRecursion;

        return $this;
    }

    /**
     * Get monthOfRecursion.
     *
     * @return int
     */
    public function getMonthOfRecursion()
    {
        return $this->month_of_recursion;
    }

    /**
     * Set googleDriveItemFolderId.
     *
     * @param string $googleDriveItemFolderId
     *
     * @return TaskItem
     */
    public function setGoogleDriveItemFolderId($googleDriveItemFolderId)
    {
        $this->google_drive_item_folder_id = $googleDriveItemFolderId;

        return $this;
    }

    /**
     * Get googleDriveItemFolderId.
     *
     * @return string
     */
    public function getGoogleDriveItemFolderId()
    {
        return $this->google_drive_item_folder_id;
    }

    /**
     * Set typePeriodRecursion.
     *
     * @param int $typePeriodRecursion
     *
     * @return TaskItem
     */
    public function setTypePeriodRecursion($typePeriodRecursion)
    {
        if (0 == $typePeriodRecursion) {
            $this->setDayOfRecursion(null);
            $this->setMonthOfRecursion(null);
        } else {
            $this->setDaysWeeklyOfRecursion(null);
        }
        $this->type_period_recursion = $typePeriodRecursion;

        return $this;
    }

    /**
     * Get typePeriodRecursion.
     *
     * @return int
     */
    public function getTypePeriodRecursion()
    {
        return $this->type_period_recursion;
    }

    /**
     * Set estimated.
     *
     * @param float $estimated
     *
     * @return TaskItem
     */
    public function setEstimated($estimated)
    {
        if (false !== strpos($estimated, ':')) {
            $aEstimated = explode(':', $estimated);
            $this->estimated = $aEstimated[0] * 60 + $aEstimated[1];
        } else {
            $this->estimated = $estimated * 60;
        }

        return $this;
    }

    /**
     * Get estimated.
     *
     * @return float
     */
    public function getEstimated($format = false)
    {
        if ($this->estimated) {
            if ('DE' == $format) {
                return number_format($this->estimated / 60, 2, ',', ' ');
            }

            return number_format($this->estimated / 60, 2, '.', ' ');
        }

        return null;
    }

    public function getPercentOfMoneyLeft()
    {
        if ($this->getEstimated() && !WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $percent = ($this->getSumHoursAllChildren() * 100) / $this->getEstimated();
            if ($percent > 100) {
                return '<span class="estimate-task more_100_percentage">' . floor($percent) . '%</span>';
            } else if ($percent > 74) {
                return '<span class="estimate-task more_75_percentage">' . floor($percent) . '%</span>';
            } else {
                return '<span class="estimate-task">' . floor($percent) . '%</span>';
            }
        } else {
            return null;
        }
    }

    /**
     * Set daysWeeklyOfRecursion.
     *
     * @param string $daysWeeklyOfRecursion
     *
     * @return TaskItem
     */
    public function setDaysWeeklyOfRecursion($daysWeeklyOfRecursion)
    {
        if ($daysWeeklyOfRecursion) {
            $this->days_weekly_of_recursion = implode(',', $daysWeeklyOfRecursion);
        } else {
            $this->days_weekly_of_recursion = null;
        }

        return $this;
    }

    /**
     * Get daysWeeklyOfRecursion.
     *
     * @return string
     */
    public function getDaysWeeklyOfRecursion()
    {
        return explode(',', $this->days_weekly_of_recursion);
    }

    public function getInfoViaAPI()
    {
        return ['taskItem' => [
            'ID' => $this->getId(),
            'title' => $this->getDescription(),
            'isActive' => $this->getIsDeleted() ? false : true,
            'state' => $this->getStateValue(),
            'annotations' => $this->getAnnotations(),
            'assignedToName' => $this->getResponsible()->getFullName(),
            'taskList' => [
                'ID' => $this->getTask()->getId(),
                'title' => $this->getTask()->getName(),
            ],
        ],
        ];
    }

    /**
     * Set annotations.
     *
     * @param string $annotations
     *
     * @return TaskItem
     */
    public function setAnnotations($annotations)
    {
        $this->annotations = $annotations;

        return $this;
    }

    /**
     * Get annotations.
     *
     * @return string
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }
}
