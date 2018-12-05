<?php

namespace WWSC\ThalamusBundle\Entity;

use Doctrine\ORM\QueryBuilder;
use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Criteria;

/**
 * Company.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="project")
 */
class Project
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter your project name.")
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The project name is too short.",
     *     maxMessage="The project name is too long.",
     * )
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="project_id", type="integer" )
     */
    private $project_id;

    /**
     * @var int
     *
     * @ORM\Column(name="config", type="text", nullable=true)
     */
    private $config;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_uid", type="string", length=255, nullable=true)
     */
    private $replyUID;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_uid_task", type="string", length=255, nullable=true)
     */
    private $replyUIDTask;

    /**
     * @var int
     *
     * @ORM\Column(name="post_task_id_via_email", type="integer", nullable=true)
     */
    private $post_task_via_email;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="budget", type="float", nullable=true)
     */
    private $budget = 0;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

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
     * @var int
     *
     * @ORM\Column(name="closed_project", type="boolean", nullable=true)
     */
    private $closed_project = 0;

    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(name="is_public_description", type="boolean", nullable=true)
     */
    private $is_public_description = 0;

    /**
     * @ORM\Column(name="is_billable_hours", type="boolean", nullable=true)
     */
    private $is_billable_hours = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="WWSC\ThalamusBundle\Entity\User", inversedBy="projects")
     * @ORM\JoinTable(name="project_user")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="WWSC\ThalamusBundle\Entity\Company", inversedBy="projects")
     * @ORM\JoinTable(name="company_project")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $companies;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Account", inversedBy="account")
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Message", mappedBy="project", cascade={"all"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $messages;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $projectleader;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Company")
     */
    private $responsible_company;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Log", mappedBy="project", cascade={"all"})
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $log;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Task", mappedBy="project", cascade={"all"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Files", mappedBy="project", cascade={"all"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $files;

    /**
     * @ORM\Column(name="exlude_from_global_task_list", type="boolean", nullable=true)
     */
    private $exlude_from_global_task_list = 0;

    /**
     * @ORM\Column(name="google_drive_folder_id", type="string", length=64, nullable=true)
     */
    private $google_drive_folder_id;

    private static $types = [
        1 => 'Fixed price',
        2 => 'Time & material',
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add company.
     *
     * @param \WWSC\ThalamusBundle\Entity\Company $company
     *
     * @return Account
     */
    public function addCompany(\WWSC\ThalamusBundle\Entity\Company $company)
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
        }

        return $this;
    }

    /**
     * Remove company.
     *
     * @param \WWSC\ThalamusBundle\Entity\Company $company
     */
    public function removeCompany(\WWSC\ThalamusBundle\Entity\Company $company)
    {
        foreach ($company->getUsers() as $oUser) {
            $this->removeUser($oUser);
        }
        $this->companies->removeElement($company);
    }

    /**
     * Set slug.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate
     *
     * @param string $slug
     *
     * @return Account
     */
    public function setSlug($slug = null)
    {
//        if ($slug) {
//            $this->slug = $slug;
//        } else {
        $abbrCompany = $this->getResponsibleCompany()->getAbbreviation();
        $projectId = $this->getProjectId();
        $this->slug = $abbrCompany.$projectId;
//        }

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Project
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
     * @return Project
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

    public function getCompaniesNotInProject()
    {
        $aCompaniesProject = $this->getCompanies()->toArray();

        return $this->getAccount()->getCompany()->filter(
            function ($entry) use ($aCompaniesProject) {
                return !in_array($entry, $aCompaniesProject);
            }
        );
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
     * @return Project
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        if (1 == $isDeleted) {
            if ($this->getMessages()) {
                foreach ($this->getMessages() as $item) {
                    $item->setIsDeleted(1);
                }
            }
            if ($this->getTasks()) {
                foreach ($this->getTasks() as $item) {
                    $item->setIsDeleted(1);
                }
            }
            if ($this->getFiles()) {
                foreach ($this->getFiles() as $item) {
                    //$item->setIsDeleted(1);
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
     * Set description.
     *
     * @param string $description
     *
     * @return Project
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
    public function getDescription()
    {
        if (preg_match('!!u', utf8_decode($this->description))) {
            return utf8_decode($this->description);
        } else {
            return $this->description;
        }
    }

    /**
     * @return mixed
     */
    public function getIsBillableHours()
    {
        return $this->is_billable_hours;
    }

    /**
     * @param mixed $is_billable_hours
     */
    public function setIsBillableHours($is_billable_hours)
    {
        $this->is_billable_hours = $is_billable_hours;
    }

    /**
     * Set account.
     *
     * @ORM\PrePersist()
     *
     * @param \WWSC\ThalamusBundle\Entity\Account $account
     *
     * @return Project
     */
    public function setAccount($account)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $this->account = $em->getRepository('WWSCThalamusBundle:Account')->find(WWSCThalamusBundle::getContainer()->get('session')->get('account')->id);

        return $this;
    }

    /**
     * Get account.
     *
     * @return \WWSC\ThalamusBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Add tasks.
     *
     * @param \WWSC\ThalamusBundle\Entity\Task $tasks
     *
     * @return Project
     */
    public function addTask(\WWSC\ThalamusBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks.
     *
     * @param \WWSC\ThalamusBundle\Entity\Task $tasks
     */
    public function removeTask(\WWSC\ThalamusBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks($aFilter = false, $type = 'object', $hideClosedTasksList = false)
    {
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if ('array' == $type) {
            return $this->getArrayTasks($aFilter, $activeUser, $hideClosedTasksList);
        }
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $lang = $activeUser->getLanguageCode();
        $roleCompany = $activeUser->getCompany()->getRoles();

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('is_deleted', 0))
            ->orderBy(array('sort' => Criteria::ASC, 'id' => Criteria::DESC));
        if ('ROLE_CLIENT' == $roleCompany) {
            $criteria->andWhere(Criteria::expr()->eq('visible_client', 1));
        }
        if ('ROLE_FREELANCER' == $roleCompany) {
            $criteria->andWhere(Criteria::expr()->eq('visible_freelancer', 1));
        }
        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $criteria->andWhere(Criteria::expr()->eq('visible_freelancer', 0));
        }

        return $this->tasks->matching($criteria);
    }

    public function getPercentOfMoneyLeft($taskItemId, $estimate, $lang)
    {
        if ($estimate && !WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            /*if ($lang == 'de') {
                $estimate =  number_format($estimate / 60, 2, ',', ' ');
            }*/
            $estimate = number_format($estimate / 60, 2, '.', ' ');
        } else {
            return null;
        }
        try {
            $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
            $aChildrenTasksIds = WWSCThalamusBundle::getContainer()->get('database_connection')->query('Select getChildrenTasksIds('.$taskItemId.') as aChildrenTasksIds')->fetchAll();
            $aChildrenTasksIds = $aChildrenTasksIds[0]['aChildrenTasksIds'];
            $sql = ' SELECT ROUND(SUM(tt.time / 60),2) as sumHoursAllChildren';
            $sql .= ' FROM taskitem AS ti';
            $sql .= ' Left JOIN comment AS c on(ti.id IN ('.$aChildrenTasksIds.') AND ti.id = c.parent_id and c.type= "TaskItem" AND c.is_deleted= 0 AND ti.is_deleted=0)';
            $sql .= ' JOIN time_tracker as tt on(c.id = tt.comment_id)';
            $aAllSumHours = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
            $percent = ($aAllSumHours[0]['sumHoursAllChildren'] * 100) / $estimate;
            if ($percent > 100) {
                return '<span class="estimate-task more_100_percentage">'.floor($percent).'%</span>';
            } else if ($percent > 74) {
                return '<span class="estimate-task more_75_percentage">'.floor($percent).'%</span>';
            } else {
                return '<span class="estimate-task">'.floor($percent).'%</span>';
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Add files.
     *
     * @param \WWSC\ThalamusBundle\Entity\Files $files
     *
     * @return Project
     */
    public function addFile(\WWSC\ThalamusBundle\Entity\Files $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files.
     *
     * @param \WWSC\ThalamusBundle\Entity\Files $files
     */
    public function removeFile(\WWSC\ThalamusBundle\Entity\Files $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles($sort = false, $cat = false, $user_created = false, $showFileSize = false, $page = 1)
    {
        $limit = 10;

        $offset = 0;

        if ($page > 1) {
            $offset = $page * $limit;
        }

        $activeUserCompany = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getCompany();
        $roleCompany = $activeUserCompany->getRoles();
        $account = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();

        /**
         * @var QueryBuilder
         */
        $qb = $em->createQueryBuilder();

        $qb->from('WWSC\ThalamusBundle\Entity\Files', 'f')
            ->where('f.project = '.$this->getId())
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.user = f.user_created)')
            ->join('WWSC\ThalamusBundle\Entity\Company', 'comp', 'WITH', "(cu.company = comp.id and comp.account = $account)")
            ->andWhere('f.is_deleted = 0');
        if ($cat) {
            $qb->andWhere('f.category = '.$cat);
        }
        if ($user_created) {
            $qb->andWhere('f.user_created = '.$user_created);
        }

        if ('ROLE_PROVIDER' != $activeUserCompany->getRoles()) {
            $qb->leftJoin('WWSC\ThalamusBundle\Entity\Comment', 'c', 'WITH', "(c.id = f.parent AND f.type = 'Comment')")
                ->leftJoin('WWSC\ThalamusBundle\Entity\TaskItem', 'ti', 'WITH', "(c.parent_id = ti.id and c.type = 'TaskItem')")
                ->leftJoin('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(ti.task = t.id)');

            if ('ROLE_CLIENT' == $roleCompany) {
                $qb->andWhere("(f.type != 'Comment' AND (cu.company =".$activeUserCompany->getId()." OR  f.private = 0 or f.private is NULL)) OR (c.type = 'TaskItem' and t.visible_client = 1)");
            }
            if ('ROLE_FREELANCER' == $roleCompany) {
                $qb->andWhere("(f.type != 'Comment' AND (cu.company =".$activeUserCompany->getId()." OR  f.private = 0 or f.private is NULL)) OR (c.type = 'TaskItem' and t.visible_freelancer = 1)");
            }
        } else {
            $qb->andWhere('cu.company ='.$activeUserCompany->getId().' OR  f.private = 0 OR f.private is NULL');
        }
        $direction_sort = 'DESC';
        if (!$sort) {
            $sort = 'created';
        }
        if ('name' == $sort) {
            $direction_sort = 'ASC';
        }
        $qb->orderBy('f.'.$sort, $direction_sort);

        $aData = array();

        if (is_numeric($page)) {
            $qb->setFirstResult($offset)
                ->setMaxResults($limit);
        }

        $aData['aFiles'] = $qb->select('f')->getQuery()->getResult();

        if ($showFileSize) {
/*            $qb->select('SUM (f.file_size) as totalFileSize');
            if (!$totalFileSize = $qb->getQuery()->getResult()) {
                $aData['totalFileSize'] = 0;
            } else {
                $aData['totalFileSize'] = round($totalFileSize[0]['totalFileSize'] / 1048576, 2);
            }*/
            $totalFileSize = 0;

            /**
             * @var Files
             */
            foreach ($aData['aFiles'] as $aFile) {
                $totalFileSize += $aFile->getFileSize();
            }

            $aData['totalFileSize'] = round($totalFileSize / 1048576, 2);
        }

        return $aData;
    }

    public function getTotalAmount($aFinanceFilter = false)
    {
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $projectSlug = $this->getSlug();
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('Sum(f.amount) as amount')
            ->from('WWSC\ThalamusBundle\Entity\Finance', 'f')
            ->where('f.is_deleted = 0')
            ->andWhere('f.project = '.$this->getId());
        if ($aFinanceFilter) {
            if (1 == $aFinanceFilter['velues']) {
                $qb->andWhere('f.amount > 0');
            } else if ($aFinanceFilter['velues'] == -1) {
                $qb->andWhere('f.amount < 0');
            }
            if (isset($aFinanceFilter['hide-all-paid']) && $aFinanceFilter['hide-all-paid']) {
                $qb->andWhere('f.status <> 3');
            }
        }

        if (isset($session->get('aDateRangeFilter')[$projectSlug])) {
            $aDateRangeFilter = $session->get('aDateRangeFilter')[$projectSlug];
            if (isset($aDateRangeFilter['date_from']) && $aDateRangeFilter['date_from']) {
                $qb->andWhere('f.invoice_date >= :from_date');
                $qb->setParameter(':from_date', new \DateTime($oUser->convertDateFormat($aDateRangeFilter['date_from'], 'sql')));
            }
            if (isset($aDateRangeFilter['date_to']) && $aDateRangeFilter['date_to']) {
                $qb->andWhere('f.invoice_date <= :to_date');
                $qb->setParameter(':to_date', new \DateTime($oUser->convertDateFormat($aDateRangeFilter['date_to'], 'sql')));
            }
        }
        $aSumAmount = $qb->getQuery()->getResult();
        if (isset($aSumAmount[0]['amount'])) {
            return $aSumAmount[0]['amount'];
        } else {
            return '0.00';
        }
    }

    public function getTaskList()
    {
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $roleCompany = $activeUser->getCompany()->getRoles();
        $sql = 'SELECT  t.id, t.name, t.description FROM task t';
        $where = " WHERE  t.project_id = {$this->getId()} AND t.is_deleted = 0 ";
        if ('ROLE_CLIENT' == $roleCompany) {
            $where .= ' AND t.visible_client = 1';
        }
        if ('ROLE_FREELANCER' == $roleCompany) {
            $where .= ' AND t.visible_freelancer = 1';
        }
        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $where .= ' AND t.visible_freelancer = 0';
        }
        $sql .= $where.' GROUP BY t.id  ORDER BY t.sort ASC, t.id DESC';

        return WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
    }

    function getArrayTasks($aFilter, $activeUser, $hideClosedTasksList = false)
    {
        $roleCompany = $activeUser->getCompany()->getRoles();
        $joinTaskItem = $hideClosedTasksList ? ' JOIN ' : ' LEFT JOIN ';
        $sql = "SELECT
                   t.id as t_id,
                   t.name as t_name,
                   t.description as t_description,
                   ti.description as ti_description,
                   ti.id as ti_id,
                   ti.state as ti_state,
                   ti.status as ti_status,
                   t.visible_client as visible_client,
                   t.visible_freelancer as visible_freelancer,
                   ti.fast_track as fastTrack,
                   ti.updated as ti_updated,
                   ti.estimated as ti_estimate,
                   CONCAT(res.first_name,
                   ' ',
                   res.last_name) as responsible,
                   MAX(c.updated) as c_updated,
                   COUNT(c.id) as c_count,
                   lvtt.date as last_visit_to_task
                FROM
                   task t
                  {$joinTaskItem}
                   taskitem  ti
                      ON t.is_deleted = 0
                      and ti.is_deleted = 0
                      and ti.is_deleted = 0
                      and ti.task_id = t.id
                      and ti.description <> ''
                      and t.project_id = {$this->getId()}
                LEFT JOIN
                   last_visit_to_task lvtt
                      ON lvtt.task_id = ti.id
                      and lvtt.user_id = {$activeUser->getId()}
                LEFT JOIN
                   comment c
                      ON c.parent_id = ti.id
                      and c.type = 'TaskItem'
                      and c.is_deleted = 0
                LEFT JOIN
                   fos_user res
                      ON ti.responsible_id = res.id";

        $where = " WHERE  t.project_id = {$this->getId()} AND t.is_deleted = 0 ";
        $visible_client = 0;
        $visible_freelancer = 0;
        if ('ROLE_CLIENT' == $roleCompany) {
            $where .= ' AND t.visible_client = 1';
            $visible_client = 1;
        }
        if ('ROLE_FREELANCER' == $roleCompany) {
            $where .= ' AND t.visible_freelancer = 1';
            $visible_freelancer = 1;
        }
        if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
            $where .= ' AND t.visible_freelancer = 0';
            $visible_freelancer = 0;
        }
        $closedTasksSQL = "SELECT getClosedTaskByTaskList({$this->getId()}) as aClosedTasks";
        $resClosedTasks = WWSCThalamusBundle::getContainer()->get('database_connection')->query($closedTasksSQL)->fetchAll();
        if (isset($resClosedTasks[0]['aClosedTasks']) && $resClosedTasks[0]['aClosedTasks']) {
            $ClosedTasks = $resClosedTasks[0]['aClosedTasks'];
            $where .= " AND (ti.id IS NULL OR (ti.id IS NOT NULL AND (ti.status <> 1 or ti.id IN ({$resClosedTasks[0]['aClosedTasks']}))))";
        } else {
            $where .= ' AND (ti.id IS NULL OR ( ti.id IS NOT NULL AND ti.status <> 1))';
        }

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
        $sql .= $where.' GROUP BY t.id, ti.id ORDER BY t.sort ASC, t.id DESC, ti.status ASC,  ti.sort ASC, ti.id DESC';
        $result = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
        $aTask = array();
        foreach ($result as $critTask) {
            if ('CLOSED' == $critTask['ti_state'] || 1 == $critTask['ti_status']) {
                $stateTaskItem = 'CLOSED';
                if ($hideClosedTasksList && !isset($openTaskList[$critTask['t_id']])) {
                    continue;
                }
            } else if ('ON_HOLD' == $critTask['ti_state']) {
                $stateTaskItem = 'ON_HOLD';
                $openTaskList[$critTask['t_id']] = true;
            } else {
                $stateTaskItem = 'OPEN';
                $openTaskList[$critTask['t_id']] = true;
            }

            $aTask[$critTask['t_id']]['info']['id'] = $critTask['t_id'];
            $aTask[$critTask['t_id']]['info']['name'] = $this->getUtf8DecodeText($critTask['t_name']);
            $aTask[$critTask['t_id']]['info']['description'] = $this->getUtf8DecodeText($critTask['t_description']);
            $aTask[$critTask['t_id']]['info']['visible_client'] = $critTask['visible_client'];
            $aTask[$critTask['t_id']]['info']['visible_freelancer'] = $critTask['visible_freelancer'];

            if (!$critTask['ti_id'] || '' == trim($critTask['ti_description'])) {
                continue;
            }
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['id'] = $critTask['ti_id'];
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['updated'] = $critTask['ti_updated'];
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['description'] = $this->getShortText($critTask['ti_description']);
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['state'] = isset(TaskItem::$states[$critTask['ti_state']]) ? TaskItem::$states[$critTask['ti_state']] : '';
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['responsible'] = $critTask['responsible'];
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['percentOfMoneyLeft'] = $this->getPercentOfMoneyLeft($critTask['ti_id'], $critTask['ti_estimate'], $activeUser->getLanguageCode());

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
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['countComments'] = $critTask['c_count'];
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['iconComments'] = $iconComment;
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['daysAfterLastFeedback'] = $lastFeedback;
            $aTask[$critTask['t_id']]['taskitems'][$stateTaskItem][$critTask['ti_id']]['fastTrack'] = $critTask['fastTrack'];
        }

        return $aTask;
    }

    /**
     * Add messages.
     *
     * @param \WWSC\ThalamusBundle\Entity\Message $messages
     *
     * @return Project
     */
    public function addMessage(\WWSC\ThalamusBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages.
     *
     * @param \WWSC\ThalamusBundle\Entity\Message $messages
     */
    public function removeMessage(\WWSC\ThalamusBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages($cat = null)
    {
        $activeUserCompany = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getCompany();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('m')
            ->from('WWSC\ThalamusBundle\Entity\Message', 'm')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.user = m.user_created)')
            ->where('m.project = '.$this->getId())
            ->andWhere('m.is_deleted = 0')
            ->andWhere('(m.private = 1 and cu.company ='.$activeUserCompany->getId().') or  m.private = 0')
            ->orderBy('m.id ', 'DESC');
        if ($cat) {
            $qb->andWhere('m.category = '.$cat);
        }
        if ('ROLE_PROVIDER' != $activeUserCompany->getRoles()) {
            $qb->join('WWSC\ThalamusBundle\Entity\SubscribeEmail', 'se', 'WITH', "(se.type = 'Message' and se.parent = m.id )");
            $qb->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'sub_com', 'WITH', '(se.user = sub_com.user )');
            $qb->andWhere('sub_com.company = '.$activeUserCompany->getId());
        }

        return $qb->getQuery()->getResult();
    }

    public function getWriteboards()
    {
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('w')
            ->from('WWSC\ThalamusBundle\Entity\Writeboard', 'w')
            ->where('w.project = '.$this->getId())
            ->andWhere('w.is_deleted = 0')
            ->andWhere('w.active = 1')
            ->orderBy('w.id ', 'DESC');

        if ('ROLE_PROVIDER' != $activeUser->getCompany()->getRoles()) {
            $qb->join('WWSC\ThalamusBundle\Entity\SubscribeEmail', 'se', 'WITH', "(se.type = 'Writeboard' and se.parent = w.number and se.user = ".$activeUser->getId().')');
        }
        $qb->groupBy('w.number');

        return $qb->getQuery()->getResult();
    }

    public function hasLog()
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if ($em->getRepository('WWSCThalamusBundle:Log')->findOneBy(array('project' => $this->id))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get log pagination.
     *
     * @param int $page
     * @param int $countPerPage
     *
     * @return \Knp\Component\Pager\Paginator
     */
    public function getLogPagination($countPage = false, $limit = 5, $page = 1)
    {
        $offset = $limit * ($page - 1);
        $projectId = $this->getId();
        $user = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        $companyId = $user->getCompany()->getId();
        $roles = $user->getCompany()->getRoles();
        if ('ROLE_PROVIDER' != $roles) {
            'ROLE_CLIENT' == $roles ? $whereTask = 'and t.visible_client = 1' : $whereTask = 'and t.visible_freelancer = 1';
            $joinWriteboard = "join subscribe_email as se on (se.type = 'Writeboard' and se.parent = w.number and se.user_id = {$userId}  and w.project_id = {$projectId} )";

            $selectTaskItemLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l join taskitem as ti on(l.object_type = 'TaskItem' and l.object_id = ti.id  and l.project_id = {$projectId} )
                                join task as t on(ti.task_id = t.id {$whereTask} and t.project_id = {$projectId}))union";

            $selectTaskLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l join task as t on(l.object_type = 'Task' and l.object_id = t.id  {$whereTask} and t.project_id  = {$projectId} ))union";

            $selectCommentTask = " select c.type, c.private, c.parent_id, c.id   from task as t join taskitem as ti on(ti.task_id = t.id and t.project_id = {$projectId}  {$whereTask})
                                        join comment as c  on (c.type = 'TaskItem' and c.parent_id = ti.id and c.private <> 1)";
        } else {
            $selectTaskLog = '';
            $joinMessage = '';
            $joinWriteboard = '';
            $whereTask = '';
            $commentWhereProvider = '';

            if (WWSCThalamusBundle::getContainer()->get('session')->get('presentationMode')) {
                $commentWhereProvider = 'AND c.private = 0';
                $whereTask = 'AND t.visible_freelancer = 0';
                $selectTaskLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l join task as t on(l.object_type = 'Task' and l.object_id = t.id  {$whereTask} and t.project_id  = {$projectId} ))union";
                $selectTaskItemLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l join taskitem as ti on(l.object_type = 'TaskItem' and l.object_id = ti.id  and l.project_id = {$projectId} )
                                join task as t on(ti.task_id = t.id {$whereTask} and t.project_id = {$projectId}))union";
            } else {
                $selectTaskItemLog = "(select l.object_type, l.project_id,  l.description, l.action, l.created, l.user_id  from log as l WHERE l.object_type IN('TaskItem','Task') and l.project_id  = {$projectId} )union";
            }

            $selectCommentTask = " select c.type, c.private, c.parent_id, c.id  from task as t join taskitem as ti on(ti.task_id = t.id and t.project_id = {$projectId}  {$whereTask})
                                        join comment as c  on (c.type = 'TaskItem' and c.parent_id = ti.id {$commentWhereProvider})";
        }

        $selectCommentLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l
            join (
               {$selectCommentTask}
            ) as gc
            on(l.object_type = 'Comment' and l.object_id = gc.id  and l.project_id  = {$projectId} ))union";

        $selectWriteboardLog = "(select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id  from log as l
           join (
                (select w.user_created_id, w.id, w.project_id from writeboard as w
                {$joinWriteboard}
                ))
            as gm on(l.object_type = 'Writeboard' and l.object_id = gm.id and l.project_id  = {$projectId} ))union";

        $selectFileLog = "(
            select l.object_type,  l.project_id,  l.description, l.action, l.created, l.user_id from log as l
            join (
              (select f.type, f.project_id, f.parent, f.id, f.private, f.user_created_id  from files as f
                join (
                    {$selectCommentTask}
                ) as gc
                on(f.type = 'Comment' and f.parent = gc.id and f.project_id = {$projectId} )
              )
              union
               (select f.type, f.project_id, f.parent, f.id, f.private, f.user_created_id from files as f  join  writeboard as w on (f.type = 'Writeboard' and f.parent = w.id and w.project_id = {$projectId} )
               {$joinWriteboard})
               union
              (select f.type, f.project_id, f.parent, f.id, f.private, f.user_created_id from files as f join company_user as cu on (f.user_created_id = cu.user_id and ((cu.company_id = $companyId and  f.private = 1 and f.project_id = 1) or f.private = 0))  where f.type = 'Project' and f.project_id = {$projectId}  )
            ) as gf on (l.object_type = 'Files' and l.object_id = gf.id and l.project_id  = {$projectId} ))
        ";
        if ($countPage) {
            $sql = "
                select COUNT(*) as count from(
                  ({$selectTaskItemLog}
                  {$selectCommentLog}
                  {$selectTaskLog}
                  {$selectWriteboardLog}
                  {$selectFileLog})
                as gl)
                where gl.project_id = '{$projectId}'
            ";

            return round(WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetch()['count'] / $limit);
        } else {
            $sql = "
                select gl.object_type, gl.description, gl.action, gl.created, gl.user_id, u.last_name, u.first_name from(
                  ({$selectTaskItemLog}
                  {$selectCommentLog}
                  {$selectTaskLog}
                  {$selectWriteboardLog}
                  {$selectFileLog})
                as gl)
                join fos_user as u
                  on (gl.user_id = u.id)
                where gl.project_id = '{$projectId}'
                order by gl.created DESC LIMIT $offset, $limit
            ";

            $result = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

            return $result;
        }
    }

    public function getSubspeople($company_id = false, $account = false, $showAllFreelUsers = false)
    {
        $aSubsCompanies = array();
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if ($company_id) {
            $oCompany = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->getRepository('WWSCThalamusBundle:Company')->find($company_id);
            $aSubsCompany = array();
            $aSubsCompany['id'] = $oCompany->getId();
            $aSubsCompany['name'] = $oCompany->getName();
            $aSubsCompany['role'] = $oCompany->getRoles();
            foreach ($oCompany->getUsers() as $oUser) {
                if ($oUser->getHasRoleProject($this->getSlug(), false)) {
                    $aSubsCompany['people'][$oUser->getId()] = $oUser->getFirstName().' '.$oUser->getLastName();
                }
            }
            array_push($aSubsCompanies, $aSubsCompany);

            return $aSubsCompanies;
        } else {
            if ($account) {
                $roleReplyEmail = true;
            } else {
                $roleReplyEmail = false;
            }
            foreach ($this->getCompanies() as $oCompany) {
                if (('ROLE_PROVIDER' == $activeUser->getCompany($account)->getRoles())
                    || ('ROLE_PROVIDER' == $oCompany->getRoles())
                    || (($showAllFreelUsers && 'ROLE_FREELANCER' == $oCompany->getRoles()) || $oCompany->getId() == $activeUser->getCompany($account)->getId())
                    || ('ROLE_CLIENT' == $activeUser->getCompany($account)->getRoles() && 'ROLE_CLIENT' == $oCompany->getRoles())
                ) {
                    $aSubsCompany = array();
                    $aSubsCompany['id'] = $oCompany->getId();
                    $aSubsCompany['name'] = $oCompany->getName();
                    $aSubsCompany['role'] = $oCompany->getRoles();
                    foreach ($oCompany->getUsers() as $oUser) {
                        if ($oUser->getHasRoleProject($this->getSlug(), $roleReplyEmail)) {
                            $aSubsCompany['people'][$oUser->getId()] = $oUser->getFirstName().' '.$oUser->getLastName();
                        }
                    }
                    array_push($aSubsCompanies, $aSubsCompany);
                }
            }

            return $aSubsCompanies;
        }
    }

    /**
     * Set is_public_description.
     *
     * @param bool $isPublicDescription
     *
     * @return Project
     */
    public function setIsPublicDescription($isPublicDescription)
    {
        $this->is_public_description = $isPublicDescription;

        return $this;
    }

    /**
     * Get is_public_description.
     *
     * @return bool
     */
    public function getIsPublicDescription()
    {
        return $this->is_public_description;
    }

    public function getChildTasks($taskId = false)
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $roleCompany = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getCompany()->getRoles();
        $sql = ' SELECT t.id as t_id, t.name as t_name, ti.id as ti_id, ti.description as ti_name, ti.status as ti_status';
        $sql .= ' FROM task AS t Left JOIN taskitem AS ti on(ti.task_id = t.id and t.project_id='.$this->getId().' AND isChild('.$taskId.', ti.id ) = 0  AND  ti.is_deleted = 0 AND (ti.parent is NULL or ti.parent = 0))';
        $sql .= ' WHERE t.is_deleted = 0  AND t.project_id = '.$this->getId();
        $sql .= ' ORDER BY t.sort DESC, ti.status ASC,  ti.sort ASC';
        $aTasks = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
        $aChildTasks = array();
        foreach ($aTasks as $oTask) {
            $statusTask = 0 == $oTask['ti_status'] ? 'open' : 'closed';
            $aChildTasks[$oTask['t_id']]['name'] = $oTask['t_name'];
            $aChildTasks[$oTask['t_id']]['tasks'][$statusTask][$oTask['ti_id']] = $oTask['ti_name'];
        }

        return $aChildTasks;
    }

    /**
     * Add log.
     *
     * @param \WWSC\ThalamusBundle\Entity\Log $log
     *
     * @return Project
     */
    public function addLog(\WWSC\ThalamusBundle\Entity\Log $log)
    {
        $this->log[] = $log;

        return $this;
    }

    /**
     * Remove log.
     *
     * @param \WWSC\ThalamusBundle\Entity\Log $log
     */
    public function removeLog(\WWSC\ThalamusBundle\Entity\Log $log)
    {
        $this->log->removeElement($log);
    }

    /**
     * Add users.
     *
     * @param \WWSC\ThalamusBundle\Entity\User $users
     *
     * @return Project
     */
    public function addUser(\WWSC\ThalamusBundle\Entity\User $users)
    {
        if (!$this->users->contains($users)) {
            $this->users[] = $users;
        }

        return $this;
    }

    /**
     * Remove users.
     *
     * @param \WWSC\ThalamusBundle\Entity\User $users
     */
    public function removeUser(\WWSC\ThalamusBundle\Entity\User $user)
    {
        $sql = 'DELETE FROM project_user';
        $sql .= ' WHERE project_user.project_id = :projectId AND project_user.user_id = :userId';
        $params = array('projectId' => $this->getId(), 'userId' => $user->getId());

        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers($company = false, $role = false)
    {
        if ($role) {
            return $this->users->filter(
                function ($entry) use ($role) {
                    foreach ($entry->getCompanies(false) as $oCompany) {
                        return $oCompany->getRoles() == $role;
                    }
                }
            );
        }
        if ($company) {
            $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
            $qb->select('u')
                ->from('WWSC\ThalamusBundle\Entity\User', 'u')
                ->join('u.project', 'p')
                ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.user = u.id and cu.enabled = 1)')
                ->where('p.id = '.$this->getId())
                ->andWhere('cu.company = '.$company);

            return $qb->getQuery()->getResult();
        }

        return $this->users;
    }

    public function getUserByFirstPartEmail($firstPartEmail, $aRoles = false)
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('WWSC\ThalamusBundle\Entity\User', 'u')
            ->join('u.project', 'p')
            ->where('p.id = '.$this->getId())
            ->andWhere('u.email LIKE :firstPartEmail')
            ->setParameter('firstPartEmail', $firstPartEmail.'%');
        if ($aRoles) {
            $qb->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.user = u.id and cu.enabled = 1)')
                ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(cu.company = c.id and c.account = p.account)')
                ->andWhere('c.roles IN(:aRoles)')
                ->setParameter(':aRoles', array_values($aRoles));
        }
        $qb->setMaxResults(1);
        if ($aUser = $qb->getQuery()->getResult()) {
            return $aUser[0];
        }

        return false;
    }

    /**
     * Get companies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if ($session->get('presentationMode') && 'ROLE_PROVIDER' == $activeUser->getCompany()->getRoles()) {
            return $this->companies->filter(
                function ($entry) {
                    return 'ROLE_FREELANCER' != $entry->getRoles();
                });
        }

        return $this->companies;
    }

    /**
     * Set responsibleCompany.
     *
     * @param \WWSC\ThalamusBundle\Entity\Company $responsibleCompany
     *
     * @return Project
     */
    public function setResponsibleCompany(\WWSC\ThalamusBundle\Entity\Company $responsibleCompany = null)
    {
        $this->responsible_company = $responsibleCompany;

        return $this;
    }

    /**
     * Get responsibleCompany.
     *
     * @return \WWSC\ThalamusBundle\Entity\Company
     */
    public function getResponsibleCompany()
    {
        return $this->responsible_company;
    }

    /**
     * Set replyUID.
     *
     * @ORM\PostPersist()
     *
     * @param string $replyUID
     *
     * @return Project
     */
    public function setReplyUID($replyUID)
    {
        $this->replyUID = $this->getId().md5(uniqid(rand(), true));
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
     * Set postTaskViaEmail.
     *
     * @param int $postTaskViaEmail
     *
     * @return Project
     */
    public function setPostTaskViaEmail($postTaskViaEmail)
    {
        $this->post_task_via_email = $postTaskViaEmail;

        return $this;
    }

    /**
     * Get postTaskViaEmail.
     *
     * @return int
     */
    public function getPostTaskViaEmail()
    {
        return $this->post_task_via_email;
    }

    /**
     * Get log.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set replyUIDTask.
     *
     * @param string $replyUIDTask
     *
     * @return Project
     */
    public function setReplyUIDTask($replyUIDTask)
    {
        $this->replyUIDTask = $replyUIDTask;

        return $this;
    }

    /**
     * Get replyUIDTask.
     *
     * @return string
     */
    public function getReplyUIDTask()
    {
        return $this->replyUIDTask;
    }

    /**
     * Set closedProject.
     *
     * @param bool $closedProject
     *
     * @return Project
     */
    public function setClosedProject($closedProject)
    {
        $this->closed_project = $closedProject;

        return $this;
    }

    /**
     * Get closedProject.
     *
     * @return bool
     */
    public function getClosedProject()
    {
        return $this->closed_project;
    }

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return Project
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get FinanceType.
     *
     * @return string
     */
    public function getFinanceType()
    {
        if (isset(self::$types[$this->getType()])) {
            return self::$types[$this->getType()];
        }

        return null;
    }

    /**
     * Set budget.
     *
     * @param int $budget
     *
     * @return Project
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget.
     *
     * @return int
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set projectleader.
     *
     * @param \WWSC\ThalamusBundle\Entity\User $projectleader
     *
     * @return Project
     */
    public function setProjectleader(\WWSC\ThalamusBundle\Entity\User $projectleader = null)
    {
        $this->projectleader = $projectleader;

        return $this;
    }

    /**
     * Get projectleader.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getProjectleader($type = 'object')
    {
        if ('id' == $type) {
            if ($this->projectleader) {
                return $this->projectleader->getId();
            }

            return false;
        }

        return $this->projectleader;
    }

    public function getTasksProjectForSelect()
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $roleCompany = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getCompany()->getRoles();
        $whereCompany = '';
        if ('ROLE_FREELANCER' == $roleCompany) {
            $whereCompany = ' AND t.visible_freelancer = 1';
        }
        $sql = ' SELECT t.id as t_id, t.name as t_name, ti.id as ti_id, ti.description as ti_name, ti.status as ti_status';
        $sql .= ' FROM task AS t Left JOIN taskitem AS ti on(ti.task_id = t.id and t.project_id='.$this->getId().' AND  ti.is_deleted = 0)';
        $sql .= ' WHERE t.is_deleted = 0 '.$whereCompany.' AND t.is_time_tracker = 1 AND t.project_id = '.$this->getId();
        $sql .= ' ORDER BY t.sort ASC, ti.status ASC,  ti.sort ASC';
        $aTasksCrit = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
        $aTasks = array();
        foreach ($aTasksCrit as $oTask) {
            $statusTask = 0 == $oTask['ti_status'] ? 'open' : 'closed';
            $aTasks[$oTask['t_id']]['name'] = $this->getUtf8DecodeText($oTask['t_name']);
            $aTasks[$oTask['t_id']]['tasks'][$statusTask][$oTask['ti_id']] = $this->getUtf8DecodeText($oTask['ti_name']);
        }

        return $aTasks;
    }

    public function getInfoViaAPI()
    {
        return ['project' => [
                'ID' => $this->getId(),
                'title' => $this->getName(),
                'isActive' => $this->getClosedProject() ? false : true,
                'financeType' => $this->getFinanceType(),
                'jsonConfig' => $this->getConfig(),
                'projectleader' => [
                    'FullName' => $this->getProjectleader()->getFullName(),
                ],
                'company' => [
                    'companyName' => $this->getResponsibleCompany()->getName(),
                    'companyAbbreviation' => $this->getResponsibleCompany()->getAbbreviation(),
                ],
            ],
        ];
    }

    /**
     * Set exludeFromGlobalTaskList.
     *
     * @param bool $exludeFromGlobalTaskList
     *
     * @return Project
     */
    public function setExludeFromGlobalTaskList($exludeFromGlobalTaskList)
    {
        $this->exlude_from_global_task_list = $exludeFromGlobalTaskList;

        return $this;
    }

    /**
     * Get exludeFromGlobalTaskList.
     *
     * @return bool
     */
    public function getExludeFromGlobalTaskList()
    {
        return $this->exlude_from_global_task_list;
    }

    public function getUtf8DecodeText($text)
    {
        if (preg_match('!!u', utf8_decode($text))) {
            $text = utf8_decode($text);
        }

        return $text;
    }

    public function getShortText($text)
    {
        if (preg_match('!!u', utf8_decode($text))) {
            $text = utf8_decode($text);
        }
        if (strlen($text) > 55) {
            $text = substr($text, 0, 55);
            $text = trim($text);

            return $text.'...';
        }

        return $text;
    }

    /**
     * Set google drive folder.
     *
     * @param string $googleDriveFolder
     *
     * @return Project
     */
    public function setGoogleDriveFolderId($googleDriveFolderId)
    {
        $this->google_drive_folder_id = $googleDriveFolderId;

        return $this;
    }

    /**
     * Get google drive folder.
     *
     * @return string
     */
    public function getGoogleDriveFolderId()
    {
        return $this->google_drive_folder_id;
    }

    /**
     * Set project_id.
     *
     * @param int $projectId
     *
     * @return Project
     */
    public function setProjectId($projectId)
    {
        $this->project_id = $projectId;

        return $this;
    }

    /**
     * Get project_id.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Set config.
     *
     * @param string $config
     *
     * @return Project
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config.
     *
     * @return string
     */
    public function getConfig($type = 'string', $key = null)
    {
        $config = $this->config;
        switch ($type) {
            case 'string':
                if (!$config) {
                    $config = '{}';
                }
                break;
            case 'array':
                $config = json_decode($config, true);
                if ($key) {
                    if (isset($config[$key])) {
                        $config = $config[$key];
                    } else {
                        return false;
                    }
                }
                break;
            case 'json':
                $config = json_decode($config, true);
                if ($key) {
                    if (isset($config[$key])) {
                        $config = $config[$key];
                    } else {
                        return false;
                    }
                }
                $config = json_encode($config);
                break;
        }

        return $config;
    }

    public function checkBudgetData()
    {
        $data = $this->getConfig('array', 'settings');
        if ($data) {
            if (isset($data['abrechnungsart']) && 'monatlichBudget' == $data['abrechnungsart']) {
                if ($data = $this->getConfig('array', 'budgets')) {
                    if (count($data['year']) > 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function getTotalHours($type = 'billabel', $period = 'month')
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        switch ($period) {
            case 'day':
                $currenDate = date('Y-m-d');
                $wherePeriod = "DATE_FORMAT(tt.date,'%Y-%m-%d') = '{$currenDate}'";
                break;
            case 'month':
                $currenDate = date('Y-m');
                $wherePeriod = "DATE_FORMAT(tt.date,'%Y-%m') = '{$currenDate}'";
                break;
            case 'year':
                $currenDate = date('Y');
                $wherePeriod = "DATE_FORMAT(tt.date,'%Y') = '{$currenDate}'";
                break;
        }
        if ('billabel' == $type) {
            $billabel = 1;
        } else {
            $billabel = 0;
        }
        $id = $this->getId();
        $qb = $em->createQueryBuilder();
        $qb->select('SUM(ROUND (tt.time/60, 2)) as total')
            ->from('WWSC\ThalamusBundle\Entity\TimeTracker', 'tt')
            ->join('WWSC\ThalamusBundle\Entity\Comment', 'c', 'WITH', "(tt.comment = c.id and c.type = 'TaskItem' and c.is_deleted = 0)")
            ->join('WWSC\ThalamusBundle\Entity\TaskItem', 'ti', 'WITH', '(c.parent_id = ti.id and ti.is_deleted = 0)')
            ->join('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(ti.task = t.id and t.is_deleted = 0)')
            ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', "(t.project = p.id and p.is_deleted = 0 and p.id = {$id})")
            ->where("tt.billable = $billabel and $wherePeriod");
        $result = $qb->getQuery()->getResult();
        if (isset($result[0]['total'])) {
            return str_replace('.', ',', $result[0]['total']);
        }

        return 0;
    }
}
