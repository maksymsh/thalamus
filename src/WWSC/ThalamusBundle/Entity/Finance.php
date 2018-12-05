<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cost.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="finance")
 */
class Finance extends Base{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="invoice_date", type="datetime", nullable=true)
     */
    private $invoice_date;

    /**
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $due_date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="vat_rate", type="integer", nullable=true)
     */
    private $vat_rate;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;

    private $save_to_log = 1;

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
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(name="billable", type="boolean", nullable=true)
     */
    private $billable = 0;
    /**
     * @ORM\Column(name="recorder_cost", type="boolean", nullable=true)
     */
    private $recorder_cost = 0;

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
     * Set invoiceDate.
     *
     * @param \DateTime $invoiceDate
     *
     * @return Cost
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoice_date = new \DateTime($invoiceDate);

        return $this;
    }

    /**
     * Get invoiceDate.
     *
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        if ('object' == gettype($this->invoice_date)) {
            if('de' == WWSCThalamusBundle::getContainer()->get('session')->get('_localeThalamus')) {
                return $this->invoice_date->format('d/m/Y');
            }

            return $this->invoice_date->format('m/d/Y');
        }

        return $this->invoice_date;
    }

    /**
     * Set dueDate.
     *
     * @param \DateTime $dueDate
     *
     * @return Cost
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = new \DateTime($dueDate);

        return $this;
    }

    /**
     * Get dueDate.
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        if ('object' == gettype($this->due_date)) {
            if('de' == WWSCThalamusBundle::getContainer()->get('session')->get('_localeThalamus')) {
                return $this->due_date->format('d/m/Y');
            }

            return $this->due_date->format('m/d/Y');
        }

        return $this->due_date;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Cost
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return Cost
     */
    public function setAmount($amount)
    {
        $this->amount = str_replace(',', '.', $amount);

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        if('de' == WWSCThalamusBundle::getContainer()->get('session')->get('_localeThalamus')) {
            return  number_format($this->amount, 2, ',', '');
        }

        return  number_format($this->amount, 2, '.', '');
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Cost
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus($type = 'code')
    {
        if('value' == $type){
            if(isset($this::$aStatus[$this->status])){
                return $this::$aStatus[$this->status];
            }
        }

        return $this->status;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Cost
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
     * @return Cost
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
     * Set isDeleted.
     *
     * @param bool $isDeleted
     *
     * @return Cost
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted.
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set user_created.
     *
     * @ORM\PrePersist()
     *
     * @param \WWSC\ThalamusBundle\Entity\Finance $userCreated
     *
     * @return Finance
     */
    public function setUserCreated($userCreated)
    {
        $this->user_created = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get userCreated.
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
     * @param \WWSC\ThalamusBundle\Entity\Finance $userUpdated
     *
     * @return Finance
     */
    public function setUserUpdated($userUpdated)
    {
        $this->user_updated = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get userUpdated.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserUpdated()
    {
        return $this->user_updated;
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Finance
     */
    public function setProject(\WWSC\ThalamusBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \WWSC\ThalamusBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public static $aStatus = array(
        '1' => 'planned',
        '2' => 'send',
        '3' => 'paid',
    );

    public static $aVATrate = array(
        '19' => '19%',
        '7' => '7%',
        '0' => 'n/a',
    );

    public static function getFinanseAllProject($total = false , $project = false, $company = 'all', $showClosedProjects = false, $projectSlug = false){
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $accountId = $session->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if('ROLE_ACCOUNTING' == $oUser->getRole()){
            $aProjectsIds = $oUser->getProjectsForAccount(true);
        }else{
            $aProjectsIds = $oUser->getResponsibleProjects();
        }
        if(!$projectIds = implode(',', $aProjectsIds)){
            $projectIds = 0;
        }
        $aDateRangeFilter = false;
        $whereProjectClosed = '';
        $whereExludeProject = '';
        if($project){
            if(isset($session->get('aDateRangeFilter')[$projectSlug])){
                $aDateRangeFilter = $session->get('aDateRangeFilter')[$projectSlug];
            }
            $whereProject = 'p.id ='.$project;
        }else{
            if(isset($session->get('aDateRangeFilter')['all'])){
                $aDateRangeFilter = $session->get('aDateRangeFilter')['all'];
            }
            $whereProject = 'p.id  IN ('.$projectIds.') and p.is_deleted = 0';
            $whereExludeProject = ' AND p.exlude_from_global_task_list = 0';
            if(!$showClosedProjects){
                $whereProjectClosed = ' and p.closed_project = 0';
                $whereProject .= $whereProjectClosed;
            }
        }
        $whereCompany = '';
        if('all' != $company){
            $whereCompany = ' AND  p.responsible_company_id = '.$company;
        }
        $whereDateRangeFromTime = '';
        $whereDateRangeFromCost = '';

        if($aDateRangeFilter){
            if(isset($aDateRangeFilter['date_from']) && $aDateRangeFilter['date_from']){
                $dateFrom = date('Y-m-d', strtotime($oUser->convertDateFormat($aDateRangeFilter['date_from'])));

                $whereDateRangeFromTime .= ' AND tt.date >= "'.$dateFrom.'"';
                $whereDateRangeFromCost .= ' AND finance.invoice_date >= "'.$dateFrom.'"';
            }
            if(isset($aDateRangeFilter['date_to']) && $aDateRangeFilter['date_to']){
                $dateTo = date('Y-m-d', strtotime($oUser->convertDateFormat($aDateRangeFilter['date_to'])));
                $whereDateRangeFromTime .= ' AND tt.date <= "'.$dateTo.'"';
                $whereDateRangeFromCost .= ' AND finance.invoice_date <= "'.$dateTo.'"';
            }
        }
        $sql = 'SELECT
                p.name  AS project_name,
                p.slug  AS project_slug,
                CONCAT(u.first_name, " ",u.last_name) as projectleader,
                p.type  AS project_type,
                rs_comp.name  AS company_name,
                rs_comp.id  AS company_id,
                f.billable_third_party  AS billable_third_party,
                f.non_billable_third_party  AS  non_billable_third_party,
                ROUND( IF (IFNULL(p.budget ,0) > 0 ,p.budget, f.already_billed), 2) AS project_budget,
                ROUND( (IF (IFNULL(p.budget ,0) > 0 ,p.budget, f.already_billed) - f.already_billed_paid), 2) AS still_open_project_value,
                ROUND (SUM(case when (tt.billable = 1 and comp.roles = "ROLE_PROVIDER")  then ROUND (tt.time/60,2) * comp.rate_internal else 0 end), 2) * -1 AS billable_personnel_cost,
                ROUND (SUM(case when  (tt.billable = 1 and comp.roles = "ROLE_FREELANCER") then ROUND (tt.time/60,2) * comp.rate_internal else 0 end), 2) * -1 AS billable_sub_contractor_cost,
                ROUND (SUM(case when (tt.billable = 0 and comp.roles = "ROLE_PROVIDER")  then ROUND (tt.time/60,2) * comp.rate_internal else 0 end), 2) * -1 AS non_billable_personnel_cost,
                ROUND (SUM(case when  (tt.billable = 0 and comp.roles = "ROLE_FREELANCER") then ROUND (tt.time/60,2) * comp.rate_internal else 0 end),2) * -1 AS non_billable_sub_contractor_cost,
                ROUND (SUM(tt.time/60), 2) AS time_of_project,
                ROUND (SUM(case when (comp.id = 2) then tt.time/60 else 0 end), 2) AS time_of_wwsc,
                ROUND (
                  (SUM(case when (tt.billable = 1 and comp.roles = "ROLE_PROVIDER")  then ROUND (tt.time/60,2) * comp.rate_external else 0 end)
                    - SUM(case when (tt.billable = 0 and comp.roles = "ROLE_PROVIDER")  then ROUND (tt.time/60,2) * comp.rate_external else 0 end))
                + (
                 SUM(case when (tt.billable = 1 and comp.roles = "ROLE_FREELANCER")  then ROUND (tt.time/60,2) * comp.rate_external else 0 end)
                - SUM(case when (tt.billable = 0 and comp.roles = "ROLE_FREELANCER")  then ROUND (tt.time/60,2) * comp.rate_external else 0 end)), 2
                ) AS sum_for_expected_turnover,

                ROUND ((SUM(case when (tt.billable = 1 and comp.roles = "ROLE_PROVIDER")  then (ROUND (tt.time/60,2) * comp.rate_internal) * -1 else 0 end)
                + SUM(case when  (tt.billable = 1 and comp.roles = "ROLE_FREELANCER") then (ROUND (tt.time/60,2) * comp.rate_internal)* -1 else 0 end) + IFNULL(billable_third_party, 0)), 2) as billable_costs_sum,

                ROUND ((SUM(case when (tt.billable = 0 and comp.roles = "ROLE_PROVIDER")  then (ROUND (tt.time/60,2) * comp.rate_internal)* -1 else 0 end)
                + SUM(case when  (tt.billable = 0 and comp.roles = "ROLE_FREELANCER") then (ROUND (tt.time/60,2) * comp.rate_internal)* -1 else 0 end) + IFNULL(non_billable_third_party, 0)), 2) as non_billable_costs_sum

                FROM project AS p LEFT JOIN (SELECT project_id,
                           sum(case when amount > 0 and  status = 3 then amount else 0 end) as already_billed_paid,
                           sum(case when amount > 0 then amount else 0 end) as already_billed,
                           sum(case when (amount < 0 and billable = 1) then amount else 0 end) as billable_third_party,
                           sum(case when (amount < 0 and billable = 0) then amount else 0 end) as non_billable_third_party
                FROM finance  WHERE is_deleted = 0 AND recorder_cost != 1 '.$whereDateRangeFromCost.'  GROUP BY project_id)  AS f on(f.project_id = p.id)
                LEFT JOIN task AS t ON (t.project_id = p.id AND t.is_deleted = 0 AND p.is_deleted = 0 '.$whereProjectClosed.')
                LEFT JOIN  taskitem AS ti ON (ti.task_id = t.id AND ti.is_deleted = 0)
                LEFT JOIN  comment AS c ON (ti.id = c.parent_id AND c.type = "TaskItem" AND c.is_deleted = 0)
                LEFT JOIN  time_tracker AS tt ON (tt.comment_id = c.id '.$whereDateRangeFromTime.')
                LEFT JOIN  company_user AS cu ON (tt.person_id = cu.user_id)
                LEFT JOIN  company AS comp ON (cu.company_id = comp.id  AND comp.account_id = '.$accountId.' )
                LEFT JOIN fos_user u  ON p.projectleader_id = u.id
                JOIN  company AS rs_comp ON ( p.responsible_company_id = rs_comp.id )
                WHERE '.$whereProject.$whereCompany.$whereExludeProject.' AND comp.id IS NOT NULL
                group by p.name, p.budget ORDER BY rs_comp.name, p.name';

        $aFinances = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        if($total){
            $aData = array('aFinances' => $aFinances);
            $aTotalFinces = array();
            foreach ($aFinances as $k => $subArray) {
                foreach ($subArray as $id => $value) {
                    if(!isset($aTotalFinces[$id])){
                        $aTotalFinces[$id] = $value;
                    }else{
                        $aTotalFinces[$id] += $value;
                    }
                }
            }
            $aData['aTotalFinces'] = $aTotalFinces;

            return $aData;
        }else{
            return $aFinances;
        }
    }

    public static function getCostProject($projectId, $projectSlug, $aFinanceFilter = false ){
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('f')
            ->from('WWSC\ThalamusBundle\Entity\Finance', 'f')
            ->where('f.is_deleted = 0')
            ->andWhere('f.project = '.$projectId);
        if($aFinanceFilter){
            if(1 == $aFinanceFilter['velues']){
                $qb->andWhere('f.amount > 0');
            }else if($aFinanceFilter['velues'] == -1){
                $qb->andWhere('f.amount < 0');
            }
            if(isset($aFinanceFilter['hide-all-paid']) && $aFinanceFilter['hide-all-paid']){
                $qb->andWhere('f.status <> 3');
            }
        }
        if(isset($session->get('aDateRangeFilter')[$projectSlug])){
            $aDateRangeFilter = $session->get('aDateRangeFilter')[$projectSlug];
            if(isset($aDateRangeFilter['date_from']) && $aDateRangeFilter['date_from']){
                $qb->andWhere('f.invoice_date >= :from_date');
                $qb->setParameter(':from_date', new \DateTime($oUser->convertDateFormat($aDateRangeFilter['date_from'],'sql')));
            }
            if(isset($aDateRangeFilter['date_to']) && $aDateRangeFilter['date_to']){
                $qb->andWhere('f.invoice_date <= :to_date');
                $qb->setParameter(':to_date', new \DateTime($oUser->convertDateFormat($aDateRangeFilter['date_to'],'sql')));
            }
        }
        $qb->orderBy('f.due_date', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public static function getCompaniesTime()
    {
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $accountId = $session->get('account')->id;
        $sql = "
select dates.date, c.id, c.name, IFNULL(content.billable, 0) as billable , IFNULL(content.notbillable, 0) as notbillable, c.roles
from
(select  max(str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' )) as date
	FROM company c
inner join company_user cu on (cu.company_id = c.id and c.account_id = $accountId and (c.primary_company = 1 OR c.roles = 'ROLE_FREELANCER'))
inner join fos_user u on cu.user_id = u.id
inner join time_tracker tt on tt.person_id = u.id
group by str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' )) dates
left join company c on (c.account_id = $accountId and (c.primary_company = 1 OR c.roles = 'ROLE_FREELANCER'))
left join 
(select c.id, c.name, str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' ) as date,
	round(sum(if(tt.billable = 1, tt.time, 0))/60,2) as billable,
	round(sum(if(tt.billable = 0, tt.time, 0))/60,2) as notbillable,
    c.roles
from company c
inner join company_user cu on (cu.company_id = c.id and c.account_id = $accountId and (c.primary_company = 1 OR c.roles = 'ROLE_FREELANCER'))
inner join fos_user u on cu.user_id = u.id
inner join time_tracker tt on tt.person_id = u.id
	GROUP BY c.name,  str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' ), c.roles
    ) content on dates.date = content.date and content.id = c.id
    
    order by dates.date asc, c.roles desc, c.name asc";
        $aAllCostLines = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        return $aAllCostLines;
    }

    public static function getAccountUsersTime()
    {
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $accountId = $session->get('account')->id;

        $sql = "select dates.date, users.name, IFNULL(content.billable, 0) as billable, IFNULL(content.notbillable, 0) as notbillable
            from
            (select  max(str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' )) as date
                FROM company c
            inner join company_user cu on (cu.company_id = c.id and c.account_id = $accountId and (c.primary_company = 1 OR c.roles = 'ROLE_FREELANCER'))
            inner join fos_user u on cu.user_id = u.id
            inner join time_tracker tt on tt.person_id = u.id
            group by str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' )) dates
            
            left join (select u.id, CONCAT(u.first_name, ' ' , u.last_name) as name
            from company c
            inner join company_user cu on (cu.company_id = c.id and c.account_id = $accountId and c.primary_company = 1)
            inner join fos_user u on cu.user_id = u.id
            ) users on 1 = 1
            left join 
            (select u.id, CONCAT(u.first_name, ' ' , u.last_name) as name, str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' ) as date,
                round(sum(if(tt.billable = 1, tt.time, 0))/60,2) as billable,
                round(sum(if(tt.billable = 0, tt.time, 0))/60,2) as notbillable  
            from company c
            inner join company_user cu on (cu.company_id = c.id and c.account_id = $accountId and c.primary_company = 1)
            inner join fos_user u on cu.user_id = u.id
            inner join time_tracker tt on tt.person_id = u.id
                GROUP BY u.first_name, u.last_name, str_to_date(concat(year(tt.date) ,'-', month(tt.date),'-1'),'%Y-%m-%d' )
                ) content on dates.date = content.date and users.id = content.id
                
                order by dates.date asc, users.name asc
            ";
        $aAllCostLines = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        return $aAllCostLines;
    }

    public static function allCostLines($hidePaydCosts = false){
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $accountId = $session->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $projectIds = implode(',', $oUser->getProjectsForAccount(true));
        $whereDateRangeFromCost = '';
        $whereStatus = '';
        if(isset($session->get('aDateRangeFilter')['all'])){
            $aDateRangeFilter = $session->get('aDateRangeFilter')['all'];
            if(isset($aDateRangeFilter['date_from']) && $aDateRangeFilter['date_from']){
                $dateFrom = date('Y-m-d', strtotime($oUser->convertDateFormat($aDateRangeFilter['date_from'],'sql')));
                $whereDateRangeFromCost .= ' AND f.invoice_date >= "'.$dateFrom.'"';
            }
            if(isset($aDateRangeFilter['date_to']) && $aDateRangeFilter['date_to']){
                $dateTo = date('Y-m-d', strtotime($oUser->convertDateFormat($aDateRangeFilter['date_to'],'sql')));
                $whereDateRangeFromCost .= ' AND f.invoice_date <= "'.$dateTo.'"';
            }
        }
        if($hidePaydCosts){
            $whereStatus = ' AND f.status <> 3';
        }

        //$joinAccount = 'JOIN account AS a ON (p.account_id = a.id and p.is_deleted = 0)';
        $whereProjects = 'ROLE_ACCOUNTING' != $oUser->getRole() ? "p.id  IN ({$projectIds})" : "p.account_id = {$accountId}";
        $sql = 'SELECT
                f.id  AS f_id,
                p.name  AS project_name,
               /* CONCAT(u.first_name, " ",u.last_name) as projectleader,
                p.type  AS project_type,*/
                p.slug  AS project_slug,
                f.description  AS description,
                f.status AS status,
                f.due_date  AS due_date,
                f.invoice_date  AS invoice_date,
                f.amount  AS net_value,
                case when f.billable = 1 then "yes" else "no" end AS billable,
                IFNULL(f.amount + (f.amount * (f.vat_rate/100)),f.amount) AS gross_value
                FROM project AS p               
                JOIN  finance AS f ON (p.id = f.project_id and p.is_deleted = 0)
                /*LEFT JOIN fos_user u  ON p.projectleader_id = u.id*/
                WHERE f.is_deleted = 0  AND p.exlude_from_global_task_list = 0 AND '.$whereProjects.$whereDateRangeFromCost.$whereStatus.'
                ORDER BY f.due_date ASC, p.name';
        $aAllCostLines = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        return $aAllCostLines;
    }

    /**
     * Set vatRate.
     *
     * @param int $vatRate
     *
     * @return Finance
     */
    public function setVatRate($vatRate)
    {
        $this->vat_rate = $vatRate;

        return $this;
    }

    /**
     * Get vatRate.
     *
     * @return int
     */
    public function getVatRate($type = 'code')
    {
        if('value' == $type){
            if(isset($this::$aVATrate[$this->vat_rate])){
                return $this::$aVATrate[$this->vat_rate];
            }
        }

        return $this->vat_rate;
    }

    /**
     * Set billable.
     *
     * @param bool $billable
     *
     * @return Finance
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;

        return $this;
    }

    /**
     * Get billable.
     *
     * @return bool
     */
    public function getBillable()
    {
        return $this->billable;
    }

    public static  $aFilterValues = array(
        '0' => 'Show all',
        '1' => 'Show only incoming',
        '-1' => 'Show only outgoing',
    );

    /**
     * Set recorderCost.
     *
     * @param bool $recorderCost
     *
     * @return Finance
     */
    public function setRecorderCost($recorderCost)
    {
        $this->recorder_cost = $recorderCost;

        return $this;
    }

    /**
     * Get recorderCost.
     *
     * @return bool
     */
    public function getRecorderCost()
    {
        return $this->recorder_cost;
    }
}
