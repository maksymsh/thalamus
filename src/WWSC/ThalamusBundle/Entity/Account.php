<?php

namespace WWSC\ThalamusBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use WWSC\ThalamusBundle\WWSCThalamusBundle;

/**
 * Company.
 *
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account {
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
     * @Assert\NotBlank(message="Please enter your account name.")
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The account name is too short.",
     *     maxMessage="The account name is too long.",
     * )
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Company", mappedBy="account", cascade={"all"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\Project", mappedBy="account", cascade={"all"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $projects;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->company = new \Doctrine\Common\Collections\ArrayCollection();
        $this->project = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Account
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add company.
     *
     * @param \WWSC\ThalamusBundle\Entity\Company $company
     *
     * @return Account
     */
    public function addCompany(\WWSC\ThalamusBundle\Entity\Company $company) {
        $this->company[] = $company;

        return $this;
    }

    /**
     * Remove company.
     *
     * @param \WWSC\ThalamusBundle\Entity\Company $company
     */
    public function removeCompany(\WWSC\ThalamusBundle\Entity\Company $company) {
        $this->company->removeElement($company);
    }

    /**
     * Get company.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompany() {
        $session = WWSCThalamusBundle::getContainer()->get('session');
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if ($session->get('presentationMode') && 'ROLE_PROVIDER' == $activeUser->getCompany()->getRoles()) {
            return $this->company->filter(
                            function($entry) {
                        return 'ROLE_FREELANCER' != $entry->getRoles();
                    });
        }

        return $this->company;
    }

    public function getPrimaryCompany() {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $oCompany = $em->getRepository('WWSCThalamusBundle:Company')->findOneBy(array('primary_company' => 1, 'account' => $this->getId()));

        return $oCompany;
    }

    public function getAccountOwner() {
        return $this->getPrimaryCompany()->getUserCreated();
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Account
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Add projects.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $projects
     *
     * @return Account
     */
    public function addProject(\WWSC\ThalamusBundle\Entity\Project $projects) {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $projects
     */
    public function removeProject(\WWSC\ThalamusBundle\Entity\Project $projects) {
        $this->projects->removeElement($projects);
    }

    public function hasProjects($statusProjects = 'open') {
        if ('open' == $statusProjects) {
            if (count($this->projects) > 1) {
                return true;
            }
        } else if ('closed' == $statusProjects) {
            $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
            $qb->select('p.id')
                    ->from('WWSC\ThalamusBundle\Entity\Project', 'p')
                    ->join('p.users', 'u')
                    ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.id = p.responsible_company)')
                    ->where('p.account = '.$this->getId())
                    ->andWhere('u.id = '.WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId())
                    ->andWhere('p.is_deleted = 0')
                    ->andWhere('p.closed_project = 1')
                    ->setMaxResults(1);
            if ($qb->getQuery()->getResult()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get projects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects($groupedBy = false, $limit = false, $forDashboard = false, $status = 'open') {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        'open' == $status ? $isClosed = 0 : $isClosed = 1;
        if (true === $groupedBy) {
            $groupedBy = 'company';
        }

        switch ($groupedBy) {
            case 'company':
                $qb->select('p')
                        ->from('WWSC\ThalamusBundle\Entity\Project', 'p')
                        ->join('p.users', 'u')
                        ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.id = p.responsible_company)')
                        ->where('p.account = '.$this->getId())
                        ->andWhere('u.id = '.WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId())
                        ->andWhere('p.is_deleted = 0')
                        ->andWhere('p.closed_project = '.$isClosed)
                        ->orderBy('c.name ,p.name ', 'ASC');
                $aCompaniesProject = array();
                foreach ($qb->getQuery()->getResult() as $oProject) {
                    $aCompaniesProject[$oProject->getResponsibleCompany()->getId()]['company_name'] = $oProject->getResponsibleCompany()->getName();
                    $aCompaniesProject[$oProject->getResponsibleCompany()->getId()]['projects'][$oProject->getId()]['slug'] = $oProject->getSlug();
                    $aCompaniesProject[$oProject->getResponsibleCompany()->getId()]['projects'][$oProject->getId()]['name'] = $oProject->getName();
                }

                return $aCompaniesProject;
                break;
            case 'projectLead':
                $qb->select('p')
                        ->from('WWSC\ThalamusBundle\Entity\Project', 'p')
                        ->join('p.users', 'u')
                        ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.id = p.responsible_company)')
                        ->leftjoin('WWSC\ThalamusBundle\Entity\User', 'resp_user', 'WITH', '(p.projectleader = resp_user.id)')
                        ->where('p.account = '.$this->getId())
                        ->andWhere('u.id = '.WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId())
                        ->andWhere('p.is_deleted = 0')
                        ->andWhere('p.closed_project = '.$isClosed)
                        ->orderBy('resp_user.firstName, c.name ,p.name ', 'ASC');
                $aProjectleaderProject = array();
                foreach ($qb->getQuery()->getResult() as $oProject) {
                    if ($oProjectLeader = $oProject->getProjectleader()) {
                        $idProjectleader = $oProjectLeader->getId();
                        $fullNameProjectleader = $oProjectLeader->getFullName();
                    } else {
                        $idProjectleader = 0;
                        $fullNameProjectleader = 'No project lead';
                    }
                    $aProjectleaderProject[$idProjectleader]['projectleader'] = $fullNameProjectleader;
                    $aProjectleaderProject[$idProjectleader]['company'][$oProject->getResponsibleCompany()->getId()]['company_name'] = $oProject->getResponsibleCompany()->getName();
                    $aProjectleaderProject[$idProjectleader]['company'][$oProject->getResponsibleCompany()->getId()]['projects'][$oProject->getId()]['slug'] = $oProject->getSlug();
                    $aProjectleaderProject[$idProjectleader]['company'][$oProject->getResponsibleCompany()->getId()]['projects'][$oProject->getId()]['name'] = $oProject->getName();
                }
                if (isset($aProjectleaderProject[0]) && $aNoProjectLead = $aProjectleaderProject[0]) {
                    unset($aProjectleaderProject[0]);
                    array_push($aProjectleaderProject, $aNoProjectLead);
                }
                //print_r($aProjectleaderProject);die();
                return $aProjectleaderProject;
                break;
            case 'API':
                $qb->select('p.id as projectId, p.name as projectName, MAX (l.created) as last_created')
                    ->from('WWSC\ThalamusBundle\Entity\Project', 'p')
                    ->join('p.users', 'u')
                    ->join('WWSC\ThalamusBundle\Entity\Log', 'l', 'WITH', '(p.id = l.project)')
                    ->where('p.account = '.$this->getId())
                    ->andWhere('u.id = '.WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId())
                    ->andWhere('p.is_deleted = 0')
                    ->andWhere('p.closed_project = '.$isClosed)
                    ->orderBy('last_created', 'DESC')
                    ->groupBy('p.id');
                if($result = WWSCThalamusBundle::getContainer()->get('database_connection')->query($qb->getQuery()->getSQL())->fetchAll()) {
                    $aProjectsForAPI = array();
                    foreach ($result as $key => $aProject) {
                        //$aProjectsForAPI["{$aProject["id_0"]}"] =  $aProject["name_1"];
                        $aProjectsForAPI[$key]['id'] = $aProject['id_0'];
                        $aProjectsForAPI[$key]['name'] = $aProject['name_1'];
                    }

                    return $aProjectsForAPI;
                }

                return false;
                break;
            default:
                if ($forDashboard) {
                    $qb->select('p, MAX (l.created) as last_created');
                    $qb->orderBy('last_created', 'DESC');
                } else {
                    $qb->select('p');
                    $qb->orderBy('l.created', 'DESC');
                }
                $qb->from('WWSC\ThalamusBundle\Entity\Project', 'p')
                        ->join('p.users', 'u')
                        ->join('WWSC\ThalamusBundle\Entity\Log', 'l', 'WITH', '(p.id = l.project)')
                        ->where('p.account = '.$this->getId())
                        ->andWhere('u.id = '.WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId())
                        ->andWhere('p.is_deleted = 0')
                        ->andWhere('p.closed_project = '.$isClosed)
                        ->groupBy('p.id');

                if ($limit) {
                    $qb->setFirstResult(0);
                    $qb->setMaxResults($limit);
                }

                return $qb->getQuery()->getResult();
                break;
        }
    }

    /**
     * Get projects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectsForDashboard() {
        $aProjects = array();
        $i = 1;
        $em = $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        foreach ($this->getProjects(false, 5, true) as $oProject) {
            if ($i <= 5) {
                if (isset($oProject[0]) && $aProject['log'] = $oProject[0]->getLogPagination(false, 5)) {
                    $aProject['name'] = $oProject[0]->getName();
                    $aProject['slug'] = $oProject[0]->getSlug();
                    array_push($aProjects, $aProject);
                    ++$i;
                }
            }
        }

        return $aProjects;
    }

    public function getChekUserForAccount($oUser, $enabled = true) {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('a')
                ->from('WWSC\ThalamusBundle\Entity\Account', 'a')
                ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.account = a.id)')
                ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.company = c.id)')
                ->where('a.id = '.$this->getId())
                ->andWhere('cu.user = '.$oUser->getId());
        if ($enabled) {
            $qb->andWhere('cu.enabled = 1');
        }
        if ($qb->getQuery()->getResult()) {
            return true;
        }

        return false;
    }

    public function getTasksForAccount($aFilter = false) {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        /**
         * @var Company $oCompany
         */
        $oCompany = $oUser->getCompany();

        $aProjects = $oUser->getProjectsForAccount();
        $joinComment = $aFilter['hide_empty_tasks'];
        if ('ROLE_PROVIDER' == $oCompany->getRoles()) {
            $sql = ' SELECT ti.id AS ti_id, ti.state AS ti_status, t.id AS t_id, ti.description AS ti_name, ti.fast_track AS ti_fast_track, p.name AS p_name, p.slug AS p_slug, u.last_name AS last_name,'
                .' u.first_name AS first_name, (SELECT updated FROM comment AS C WHERE C.parent_id = ti.id ORDER BY updated DESC LIMIT 0, 1) AS last_comment';
        }else {
            $sql = ' SELECT ti.id AS ti_id, ti.state AS ti_status, t.id AS t_id, ti.description AS ti_name, ti.fast_track AS ti_fast_track, p.name AS p_name, p.slug AS p_slug, p.id AS p_id,'
                .'(SELECT updated FROM comment AS C WHERE C.parent_id = ti.id ORDER BY updated DESC LIMIT 0, 1) AS last_comment';
        }
        $sql .= ' FROM taskitem AS ti ';
        $sql .= ' LEFT JOIN project AS p ON( p.account_id='.$this->getId().' ) ';
        $sql .= ' LEFT JOIN task AS t ON( t.project_id=p.id AND ti.task_id = t.id AND  ti.is_deleted = 0) ';
        if ($joinComment) {
            $sql .= ' LEFT JOIN comment AS c ON(c.type = "TaskItem" AND c.parent_id=ti.id AND c.is_deleted !=1) ';
        }

        $sql .= 'LEFT JOIN fos_user AS u ON(ti.responsible_id = u.id) ';

        $joinCompany = 'LEFT JOIN company_user AS cu ON(ti.responsible_id = cu.user_id ) JOIN company AS comp ON (cu.company_id = comp.id AND comp.account_id ='.$this->getId().')';
        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $joinCompany = 'LEFT JOIN company_user AS cu ON(ti.responsible_id = cu.user_id ) JOIN company AS comp ON (cu.company_id = comp.id AND comp.account_id ='.$this->getId().')';
        }
        $sql .= $joinCompany;
        $sql .= ' WHERE t.project_id=p.id AND  ti.state != "CLOSED" AND ti.status = 0 AND p.closed_project = 0 ';
        if ($aFilter) {
            if ($aFilter['filter_task_status'] && 'ROLE_FREELANCER' != $oCompany->getRoles()) {
                $sql .= ' AND ti.state !="READY_FOR_BRIEFING" AND ti.state != "ON_HOLD" ';
            }

            if ($aFilter['filter_status']) {
                $sql .= ' AND ti.state ="'.$aFilter['filter_status'].'" ';
            }

            if ($aFilter['filter_project_title']) {
                $sql .= ' AND p.id ="'.$aFilter['filter_project_title'].'" ';
            }
        }
        /*foreach ($aProjects as $project) {
            if ($project->getExludeFromGlobalTaskList()) {
                $sql .=' AND p.id !=' . $project->getId() . ' ';
            }
        }*/
        if ('ROLE_FREELANCER' == $oCompany->getRoles()) {
            $sql .= ' AND ti.responsible_id = '.$oUser->getId();
        }else {
            if (isset($aFilter['filter_person']) && $aFilter['filter_person']) {
                $aFilterPerson = explode('_', $aFilter['filter_person']);
                if ('c' == $aFilterPerson[0]) {
                    $sql .= ' AND comp.id = '.$aFilterPerson[1];
                }
                if ('u' == $aFilterPerson[0]) {
                    $sql .= ' AND ti.responsible_id = '.$aFilterPerson[1];
                }
            }
        }

        if ($joinComment) {
            $sql .= ' AND c.parent_id IS NOT NULL GROUP BY ti.id';
        }

        $sql .= ' ORDER BY ti.sort_tasks ASC ';

        // Dev module
        if($oCompany->getId() == '24') {
            $sql = "
                SELECT 
                t.id as ti_id,
                t.state as ti_status,
                t.description as ti_name, 
                t.fast_track as ti_fast_track, 
                t.updated as last_comment, 
                u.*, 
                p.slug as p_slug, 
                p.name as p_name 
                FROM company_user c1 
                 inner join company as c on c1.company_id = c.id
                    inner join taskitem as t on t.responsible_id = c1.user_id
                 inner join fos_user as u on c1.user_id = u.id
                 left join company_project as ct on c.id = ct.company_id
                 left join project_user as pu on pu. user_id = u.id
                 left join project as p on p.id = ct.project_id and p.id = pu.project_id
                WHERE c1.company_id = '".$oCompany->getId()."'
                 and c.is_deleted = 0
                 and c1.enabled = 1
                 and t.state not in ('NO', '', 'CLOSED', 'WAITING_FOR_APPROVAL', 'WAITING_FOR_FEEDBACK')
                 and t.task_id = 51
                group by t.id
                order by t.id desc
            ";
        }

        $aTasksCrit = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        return $aTasksCrit;
    }

    public function getProjectsForAccountFreelancer()
    {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        $sql = ' SELECT p.id AS p_id, p.name AS p_name ';
        $sql .= ' FROM project AS p ';
        $sql .= ' JOIN project_user AS pu ON( pu.project_id=p.id AND pu.user_id = '.$oUser->getId().') ';
        $sql .= ' WHERE p.account_id='.$this->getId().' AND p.closed_project  <>  1 ';

        return WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
    }

    public function getProjectsForAccount()
    {
        $sql = ' SELECT p.id AS p_id, p.name AS p_name ';
        $sql .= ' FROM project AS p ';
        $sql .= ' WHERE p.account_id='.$this->getId().' AND p.closed_project  <>  1 ';

        return WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();
    }
}
