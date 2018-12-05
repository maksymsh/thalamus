<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Task.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="task", indexes={@ORM\Index(columns={"name", "description"}, flags={"fulltext"})})
 */
class Task extends Base{
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name = 'List';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    /**
     * @var boolean
     *
     * @ORM\Column(name="visible_client", type="boolean", nullable=true)
     */
    private $visible_client;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible_freelancer", type="boolean", nullable=true)
     */
    private $visible_freelancer;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_time_tracker", type="boolean", nullable=true)
     */
    private $is_time_tracker;

    private $save_to_log = 1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user_created;

    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user_updated;

    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(name="recursive", type="boolean", nullable=true)
     */
    private $recursive = 0;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\TaskItem", mappedBy="task", cascade={"all"})
     * @ORM\OrderBy({"sort" = "DESC"})
     */
    private $items;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Task
     */
    public function setName($name = 'List') {
        if ($name) {
            $this->name = utf8_encode($name);
        }

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() {
        if (preg_match('!!u', utf8_decode($this->name))) {
            return utf8_decode($this->name);
        } else {
            return $this->name;
        }
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Task
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Task
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated() {
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
    public function setUserCreated($userCreated) {
        $this->user_created = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get user_created.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserCreated() {
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
    public function setUserUpdated($userUpdated) {
        $this->user_updated = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get user_updated.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserUpdated() {
        return $this->user_updated;
    }

    /**
     * Set is_deleted.
     *
     * @param bool $isDeleted
     *
     * @return Task
     */
    public function setIsDeleted($isDeleted) {
        $this->is_deleted = $isDeleted;

        if(1 == $isDeleted){
            if($this->getItems()){
                foreach($this->getItems() as $item){
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
    public function getIsDeleted() {
        return $this->is_deleted;
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Task
     */
    public function setProject(\WWSC\ThalamusBundle\Entity\Project $project = null) {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \WWSC\ThalamusBundle\Entity\Project
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add items.
     *
     * @param \WWSC\ThalamusBundle\Entity\TaskItem $items
     *
     * @return Task
     */
    public function addItem(\WWSC\ThalamusBundle\Entity\TaskItem $items) {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items.
     *
     * @param \WWSC\ThalamusBundle\Entity\TaskItem $items
     */
    public function removeItem(\WWSC\ThalamusBundle\Entity\TaskItem $items) {
        $this->items->removeElement($items);
    }

    /**
     * Get items.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClosedItems($offset = false, $limit = 3) {
        if(!$status){
            $status = 0;
        }
        if ($aFilter && (isset($aFilter['filter_due']) && $aFilter['filter_due']) || (isset($aFilter['filter_responsible']) && $aFilter['filter_responsible'])) {
            return $this->getFilterTaskItem($status, $aFilter , $lCompletedItems, $state, $offset, $limit);
        }
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();

        $qb->select('ti')
                ->from('WWSC\ThalamusBundle\Entity\TaskItem', 'ti')
                ->where('ti.is_deleted = 0')
                ->andWhere('ti.task = '.$this->getId())
                ->andWhere('ti.status = '.$status);
        if($lCompletedItems){
            $qb->setMaxResults($lCompletedItems);
        }
        if(0 == $status){
            if('ON_HOLD' == $state){
                $qb->andWhere("ti.state = 'ON_HOLD'");
            }else{
                $qb->andWhere("ti.state <> 'ON_HOLD' OR ti.state is NULL");
            }
			$qb->orderBy('ti.sort', 'ASC');
			$qb->addOrderBy('ti.id', 'DESC');
        }else{
			$qb->orderBy('ti.updated ', 'DESC');
			$qb->addOrderBy('ti.sort', 'ASC');
			$qb->addOrderBy('ti.id', 'DESC');
            if(false !== $offset) {
                $qb->setFirstResult($offset);
                $qb->setMaxResults($limit);
            }
        }

        return $qb->getQuery()->getResult();
    }

   /* public function getClosedItems($offset, $task_Id){

        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('ti')
            ->from('WWSC\ThalamusBundle\Entity\TaskItem', 'ti')
            ->where("ti.is_deleted = 0")
            ->andWhere("ti.task = ".$task_Id)
            ->andWhere("ti.status = 1")
            ->orderBy('ti.updated ', 'DESC')
            ->addOrderBy('ti.sort', 'ASC')
            ->addOrderBy('ti.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();


    }*/

    /**
     * Set is_time_tracker.
     *
     * @param bool $isTimeTracker
     *
     * @return Task
     */
    public function setIsTimeTracker($isTimeTracker) {
        $this->is_time_tracker = $isTimeTracker;

        return $this;
    }

    /**
     * Get is_time_tracker.
     *
     * @return bool
     */
    public function getIsTimeTracker() {
        return $this->is_time_tracker;
    }

    /**
     * Set sort.
     *
     * @param int $sort
     *
     * @return Task
     */
    public function setSort($sort) {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return int
     */
    public function getSort() {
        return $this->sort;
    }

    /**
     * Set int sort.
     *
     * @ORM\PrePersist()
     */
    public function setSortNewElem() {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $crit = array(
            'is_deleted' => 0,
            'project' => $this->project,
        );
        $oItem = $entityManager->getRepository('WWSCThalamusBundle:Task')->findOneBy($crit, array('sort' => 'DESC'));
        if ($oItem) {
            $this->setSort($oItem->getSort() + 1);
        } else {
            $this->setSort(0);
        }
    }

    function getTaskItem($aFilter, $status = 0, $offset = false, $limit = 3)
    {
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $roleCompany = $activeUser->getCompany()->getRoles();
        $oProject = $this->getProject();
        $sql = 'SELECT
                   ti.description as ti_description,
                   ti.id as ti_id,
                   ti.state as ti_state,
                   ti.status as ti_status,
                   ti.fast_track as fastTrack,
                   ti.updated as ti_updated,
                   ti.estimated as ti_estimate,
                   CONCAT(res.first_name,
                   " ",
                   res.last_name) as responsible,
                   MAX(c.updated) as c_updated,
                   COUNT(c.id) as c_count,
                   lvtt.date as last_visit_to_task
                FROM
                   taskitem  ti
                LEFT JOIN
                   last_visit_to_task lvtt
                      ON lvtt.task_id = ti.id
                      and lvtt.user_id = '.$activeUser->getId().'
                LEFT JOIN
                   comment c
                      ON c.parent_id = ti.id
                      and c.type = "TaskItem"
                      and c.is_deleted = 0
                LEFT JOIN
                   fos_user res
                      ON ti.responsible_id = res.id';

        $where = " WHERE  ti.is_deleted = 0 and ti.task_id = {$this->getId()}  and ti.description <> ''";

        if (isset($aFilter['filter_due']) && $aFilter['filter_due'] && '' != $aFilter['filter_due']) {
            switch ($aFilter['filter_due']) {
                case 'today':
                    $where .= " AND ti.due_date >= '".date('Y-m-d', strtotime('today'))."' AND ti.due_date <= '".date('Y-m-d', strtotime('now'))."'";
                    break;
                case 'tomorrow':
                    $where .= " AND ti.due_date >= '".date('Y-m-d', strtotime('now'))."' AND ti.due_date <= '".date('Y-m-d', strtotime('tomorrow'))."'";
                    break;
                case 'this_week':
                    $where .= " AND ti.due_date >= '".date('Y-m-d', strtotime('monday this week'))."' AND ti.due_date <= '".date('Y-m-d', strtotime('sunday this week'))."'";
                    break;
                case 'next_week':
                    $where .= " AND ti.due_date >= '".date('Y-m-d', strtotime('monday next week'))."' AND ti.due_date <= '".date('Y-m-d', strtotime('sunday next week'))."'";
                    break;
                case 'later':
                    $where .= " AND ti.due_date >= '".date('Y-m-d', strtotime('now'))."'";
                    break;
            }
        }
        if (isset($aFilter['filter_responsible']) && $aFilter['filter_responsible']) {
            $aFilterResponsible = explode('_', $aFilter['filter_responsible']);
            if ('c' == $aFilterResponsible[0]) {
                $sql .= ' LEFT JOIN company_user cu ON ti.responsible_id = cu.user_id';
                $where .= ' AND cu.company_id = '.$aFilterResponsible[1];
            }
            if ('u' == $aFilterResponsible[0]) {
                $where .= ' AND  ti.responsible_id = '.$aFilterResponsible[1];
            }
        }

        if (isset($aFilter['hide_close_task']) && $aFilter['hide_close_task']) {
            $where .= ' AND ti.status = 0';
        }

        if(0 == $status) {
            $closedTasksSQL = "SELECT id as aClosedTasks FROM taskitem WHERE task_id = {$this->getId()} AND status = 1 AND is_deleted =0 AND description  <> ''  ORDER BY updated DESC LIMIT 0,3";
            $resClosedTasks = WWSCThalamusBundle::getContainer()->get('database_connection')->query($closedTasksSQL)->fetchAll();
            if(isset($resClosedTasks[0]['aClosedTasks']) && $resClosedTasks[0]['aClosedTasks']){
                $aClosedTasks = implode(',', array_column($resClosedTasks,'aClosedTasks'));
                $where .= " AND (ti.status <> 1 or ti.id IN ({$aClosedTasks}))";
            }else{
                $where .= ' AND ti.status <> 1';
            }
            $sql .= $where.' GROUP BY ti.id ORDER BY  ti.sort ASC, ti.id DESC';
        }else{
            $where .= ' AND ti.status = 1';
            $sql .= $where." GROUP BY ti.id ORDER BY ti.updated DESC  LIMIT {$offset},{$limit}";
        }

        $result = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        $aTaskItems = array();
        foreach ($result as $critTask) {
            if ('CLOSED' == $critTask['ti_state'] || 1 == $critTask['ti_status']) {
                $stateTaskItem = 'CLOSED';
            } else if ('ON_HOLD' == $critTask['ti_state']) {
                $stateTaskItem = 'ON_HOLD';
            } else {
                $stateTaskItem = 'OPEN';
            }
            if (!$critTask['ti_id'] || '' == trim($critTask['ti_description'])) {
                continue;
            }
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['id'] = $critTask['ti_id'];
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['updated'] = $critTask['ti_updated'];
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['description'] = $oProject->getShortText($critTask['ti_description']);
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['state'] = isset(TaskItem::$states[$critTask['ti_state']]) ? TaskItem::$states[$critTask['ti_state']] : '';
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['responsible'] = $critTask['responsible'];
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['percentOfMoneyLeft'] = $oProject->getPercentOfMoneyLeft($critTask['ti_id'], $critTask['ti_estimate'], $activeUser->getLanguageCode());

            if (!$critTask['c_updated']) {
                $lastFeedback = null;
            } else {
                $lastFeedback = (int) ((strtotime('now') - strtotime(date('Y-m-d', strtotime($critTask['c_updated'])))) / (60 * 60 * 24));
                if ($lastFeedback > 0) {
                    if ($lastFeedback > 1) {
                        $lastFeedback = $lastFeedback.' days';
                    } else {
                        $lastFeedback = $lastFeedback.' day';
                    }
                }
            }
            if ($critTask['c_updated'] <= $critTask['last_visit_to_task']) {
                $iconComment = 'green';
            } else {
                $iconComment = 'black';
            }
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['countComments'] = $critTask['c_count'];
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['iconComments'] = $iconComment;
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['daysAfterLastFeedback'] = $lastFeedback;
            $aTaskItems[$stateTaskItem][$critTask['ti_id']]['fastTrack'] = $critTask['fastTrack'];
        }

        return $aTaskItems;
    }

    public function getInfo(){
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'visible_client' => $this->getVisibleClient(),
            'visible_freelancer' => $this->getVisibleFreelancer(),
        );
    }

    public function getFilterTaskItem($status, $aFilter, $lCompletedItems = false, $state = false, $offset = false, $limit = 3) {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('ti')
                ->from('WWSC\ThalamusBundle\Entity\TaskItem', 'ti')
                ->where('ti.is_deleted = 0')
                ->andWhere('ti.task = '.$this->getId())
                ->andWhere('ti.status = '.$status);
        if ($aFilter['filter_due']) {
            switch ($aFilter['filter_due']) {
                case 'today':
                    $qb->andWhere('ti.due_date >= :min_date')
                            ->andWhere('ti.due_date <= :max_date')
                            ->setParameter(':min_date', new \DateTime('today'))
                            ->setParameter(':max_date', new \DateTime('now'));
                    break;
                case 'tomorrow':
                    $qb->andWhere('ti.due_date >= :min_date')
                            ->andWhere('ti.due_date <= :max_date')
                            ->setParameter(':min_date', new \DateTime('now'))
                            ->setParameter(':max_date', new \DateTime('tomorrow'));
                    break;
                case 'this_week':
                    $qb->andWhere('ti.due_date >= :min_date')
                            ->andWhere('ti.due_date <= :max_date')
                            ->setParameter(':min_date', new \DateTime('monday this week'))
                            ->setParameter(':max_date', new \DateTime('sunday this week'));
                    break;
                case 'next_week':
                    $qb->andWhere('ti.due_date >= :min_date')
                            ->andWhere('ti.due_date <= :max_date')
                            ->setParameter(':min_date', new \DateTime('monday next week'))
                            ->setParameter(':max_date', new \DateTime('sunday next week'));
                    break;
                case 'later':
                    $qb->andWhere('ti.due_date >= :min_date')
                            ->setParameter(':min_date', new \DateTime('now'));
                    break;
            }
        }
        if(0 == $status){
            if('ON_HOLD' == $state){
                $qb->andWhere("ti.state = 'ON_HOLD'");
            }else{
                $qb->andWhere("ti.state <> 'ON_HOLD' OR ti.state is NULL");
            }
        }
        if (isset($aFilter['filter_responsible']) && $aFilter['filter_responsible']) {
          $aFilterResponsible = explode('_', $aFilter['filter_responsible']);   
          if('c' == $aFilterResponsible[0]){
            $oCompany = $em->getRepository('WWSCThalamusBundle:Company')->find($aFilterResponsible[1]);
            $qb->andWhere('ti.responsible IN ('.implode(',',$oCompany->getUsers(array('id'))).')');
          }
          if('u' == $aFilterResponsible[0]){
            $qb->andWhere('ti.responsible = '.$aFilterResponsible[1]);
          }
        }
        if($lCompletedItems){
            $qb->setMaxResults($lCompletedItems);
        }

        if(1 == $status){
            $qb->orderBy('ti.updated ', 'DESC');
			$qb->addOrderBy('ti.sort', 'ASC');
			$qb->addOrderBy('ti.id', 'DESC'); 
            if(false !== $offset) {
                $qb->setFirstResult($offset);
                $qb->setMaxResults($limit);
            }
        }else{
			$qb->orderBy('ti.sort', 'ASC');
			$qb->addOrderBy('ti.id', 'DESC');
        }

        return $qb->getQuery()->getResult();
    }

    private function getLogInfoByTask($entity){
        if(!$entity->save_to_log){
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        $oProject = $entity->getProject();
        $url = WWSCThalamusBundle::getContainer()->get('router')->generate(
            'wwsc_thalamus_project_task_show',
            array(
                'project' => $oProject->getSlug(),
                'id' => $entity->getId(),
            )
        );
        $aRes['description'] = "<a href='".$url."'>".$this->truncation($entity->getName(), 100).'</a>';
        $aRes['project'] = $oProject;

        return $aRes;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $args) {
        if(!$args->hasChangedField('is_deleted')){
            $aParams = $this->getLogInfoByTask($args->getEntity());
            $aParams['action'] = 'Updated by';
            $this->things[] = $aParams;
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist($args) {
        if($aParams = $this->getLogInfoByTask($args->getEntity())){
            $aParams['action'] = 'Posted by';
            $this->saveLog($aParams);
        }
    }

    /**
     * Set visibleClient.
     *
     * @param bool $visibleClient
     *
     * @return Task
     */
    public function setVisibleClient($visibleClient)
    {
        $this->visible_client = $visibleClient;

        return $this;
    }

    /**
     * Get visibleClient.
     *
     * @return boolean
     */
    public function getVisibleClient()
    {
        return $this->visible_client;
    }

    /**
     * Set visibleFreelancer.
     *
     * @param bool $visibleFreelancer
     *
     * @return Task
     */
    public function setVisibleFreelancer($visibleFreelancer)
    {
        $this->visible_freelancer = $visibleFreelancer;

        return $this;
    }

    /**
     * Get visibleFreelancer.
     *
     * @return boolean
     */
    public function getVisibleFreelancer()
    {
        return $this->visible_freelancer;
    }

    /**
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return Task
     */
    public function setSaveToLog($saveToLog)
    {
        $this->save_to_log = $saveToLog;

        return $this;
    }

    /**
     * Get saveToLog.
     *
     * @return boolean
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
     * @return Task
     */
    public function setRecursive($recursive)
    {
        $this->recursive = $recursive;

        return $this;
    }

    /**
     * Get recursive.
     *
     * @return boolean
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * Set recurringTaskList.
     *
     * @param int $recurringTaskList
     *
     * @return Task
     */
    public function setRecurringTaskList($recurringTaskList)
    {
        $this->recurring_task_list = $recurringTaskList;

        return $this;
    }

    /**
     * Get recurringTaskList.
     *
     * @return integer
     */
    public function getRecurringTaskList()
    {
        return $this->recurring_task_list;
    }
}
