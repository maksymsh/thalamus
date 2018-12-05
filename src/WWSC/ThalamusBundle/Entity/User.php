<?php

namespace WWSC\ThalamusBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use WWSC\ThalamusBundle\WWSCThalamusBundle;
use WWSC\ThalamusBundle\Entity\UserProfile as Profile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatar")
     *
     * @var File
     */
    protected $avatarFile;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     * @Assert\NotBlank(message="Please enter your first Name.")
     * @Assert\Length(
     *     min=2,
     *     max="255",
     *     minMessage="The First Name is too short.",
     *     maxMessage="The First Name is too long.",
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Assert\NotBlank(message="Please enter your last Name.")
     * @Assert\Length(
     *     min=2,
     *     max="255",
     *     minMessage="The Last Name is too short.",
     *     maxMessage="The Last Name is too long.",
     * )
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=100, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="time_zone", type="string", length=100, nullable=true)
     */
    private $timeZone;

    /**
     * @var bool
     *
     * @ORM\Column(name="access_all_projects", type="boolean", nullable=true)
     */
    private $accessAllProjects;

    /**
     * @ORM\OneToOne(targetEntity="WWSC\ThalamusBundle\Entity\UserProfile", mappedBy="user", cascade={"all"})
     */
    protected $profile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\CompanyUser", mappedBy="user")
     */
    private $companyUser;

    /**
     * @ORM\ManyToMany(targetEntity="WWSC\ThalamusBundle\Entity\Project", mappedBy="users")
     */
    private $project;

    /**
     * @ORM\Column(name="sorting_projects_list", type="integer", nullable=true)
     */
    public $sorting_projects_list;

    /**
     * @ORM\Column(name="last_logged_account", type="integer", nullable=true)
     */
    public $last_logged_account;

    /** @ORM\Column(name="googleID", type="string", length=255, nullable=true) */
    protected $googleID;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(name="locked", type="integer")
     */
    protected $locked = 0;

    /**
     * @ORM\Column(name="google_drive_token", type="string", length=255, nullable=true)
     */
    protected $google_drive_token;

    /**
     * @ORM\Column(name="google_drive_token_expire", type="string", length=255, nullable=true)
     */
    protected $google_drive_token_expire;

    /**
     * @ORM\Column(name="google_drive_token_refresh", type="string", length=255, nullable=true)
     */
    protected $google_drive_token_refresh;

    public $account;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->project = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companyUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        if(!$this->salt){
            $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        }
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
     * @param UploadedFile $avatarFile
     */
    public function setAvatarFile(File $avatarFile)
    {
        $this->avatarFile = $avatarFile;
        $this->updated = new \DateTime();
    }

    /**
     * @return File
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    public function getLanguageCode()
    {
        if ('de' == $this->language || 'de_AT' == $this->language) {
            return 'de';
        } else {
            return 'en';
        }
    }

    /**
     * Set avatar.
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get avatar.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getCompany($account = false)
    {
        if (!$account) {
            $account = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        }
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('c')
            ->from('WWSC\ThalamusBundle\Entity\Company', 'c')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(c.id = cu.company)')
            ->where('cu.user = '.$this->getId())
            ->andWhere('c.account = '.$account)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getRole()
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('ru.key')
            ->from('WWSC\ThalamusBundle\Entity\RoleUser', 'ru')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(ru.id = cu.role_user)')
            ->where('cu.user = '.$this->getId())
            ->andWhere('cu.company = '.$this->getCompany()->getId())
            ->setMaxResults(1);
        if ($oRole = $qb->getQuery()->getOneOrNullResult()) {
            return $oRole['key'];
        } else {
            return false;
        }
    }

    public function setCompany($oCompany)
    {
        if ($oCompany->getId() != $this->getCompany()->getId()) {
            $enabled = $this->checkActiveUserCompany();
            $this->removeCompanyUser($this->getCompany());
            $this->addCompanyUser($oCompany, $enabled);
        }
    }

    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set language.
     *
     * @param string $language
     *
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set timeZone.
     *
     * @param string $timeZone
     *
     * @return User
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone.
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set accessAllProjects.
     *
     * @param bool $accessAllProjects
     *
     * @return User
     */
    public function setAccessAllProjects($accessAllProjects)
    {
        $this->accessAllProjects = $accessAllProjects;

        return $this;
    }

    /**
     * Get accessAllProjects.
     *
     * @return bool
     */
    public function getAccessAllProjects()
    {
        return $this->accessAllProjects;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return User
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
     * Add project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return User
     */
    public function addProject(\WWSC\ThalamusBundle\Entity\Project $project)
    {
        $this->project[] = $project;

        return $this;
    }

    /**
     * Remove project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     */
    public function removeProject(\WWSC\ThalamusBundle\Entity\Project $project)
    {
        $this->project->removeElement($project);
    }

    /**
     * Get project.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectsForAccount($getIds = false, $hideClosedProjects = false, $groupByCompany = false, $orderBy = false)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('WWSC\ThalamusBundle\Entity\Account', 'a')
            ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', '(p.account = a.id and p.is_deleted = 0)')
            ->join('p.users', 'u')
            ->where('a.id = '.WWSCThalamusBundle::getContainer()->get('session')->get('account')->id)
            ->andWhere('u.id='.$this->getId());
        if ('alphabet' == $orderBy) {
            $qb->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.id = p.responsible_company)');
            $qb->orderBy('c.name ,p.name ', 'ASC');
        }
        if ($hideClosedProjects) {
            $qb->andWhere('p.closed_project  <>  1');
        }
        $aProjects = $qb->getQuery()->getResult();

        if ($groupByCompany) {
            foreach ($aProjects as $oProject) {
                $aIds[$oProject->getResponsibleCompany()->getId()]['name'] = $oProject->getResponsibleCompany()->getName();
                $aIds[$oProject->getResponsibleCompany()->getId()]['projects'][$oProject->getId()] = $oProject->getName();
            }

            return $aIds;
        }
        if ($getIds) {
            $aIds = array();
            foreach ($aProjects as $oProject) {
                $aIds[] = $oProject->getId();
            }

            return $aIds;
        }

        return $aProjects;
    }

    public function getHasRoleProject($projectSlug, $roleReplyEmail = false, $statusProject = 'open')
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $aWhere = array('slug' => $projectSlug, 'is_deleted' => 0);
        if (!$roleReplyEmail && 'ROLE_PROVIDER' != $this->getCompany()->getRoles()) {
            if ('open' == $statusProject) {
                $aWhere['closed_project'] = 0;
            } else if ('closed' == $statusProject) {
                $aWhere['closed_project'] = 1;
            }
        }
        if ($oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy($aWhere)) {
            $qb = $em->createQueryBuilder();
            $qb->select('p.id')
                ->from('WWSC\ThalamusBundle\Entity\Account', 'a')
                ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', '(p.account = a.id)')
                ->join('p.users', 'u')
                ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(c.account = a.id)')
                ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(cu.company = c.id)');
            $qb->Where('cu.user = '.$this->getId())
                ->andWhere('u.id='.$this->getId())
                ->andWhere('p.id= '.$oProject->getId())
                ->andWhere('cu.enabled = 1');
            if (!$roleReplyEmail) {
                $qb->andWhere('a.id = '.WWSCThalamusBundle::getContainer()->get('session')->get('account')->id);
            }

            if ($qb->getQuery()->getResult()) {
                return true;
            }
        }

        return false;
    }

    public function getLastTask($limit = 1)
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('com.description as last_comment, ti.description as title, ti.id as task_id,  created.firstName, created.lastName')
            ->from('WWSC\ThalamusBundle\Entity\User', 'u')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(u.id = cu.user)')
            ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(cu.company = c.id)')
            ->join('WWSC\ThalamusBundle\Entity\Account', 'a', 'WITH', '(c.account = a.id)')
            ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', '(p.account = a.id)')
            ->join('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(t.project = p.id  and t.is_deleted = 0)')
            ->join('WWSC\ThalamusBundle\Entity\TaskItem', 'ti', 'WITH', "(t.id = ti.task and ti.is_deleted = 0  and ti.state != 'CLOSED')")
            ->join('WWSC\ThalamusBundle\Entity\Comment', 'com', 'WITH', "(ti.id = com.parent_id and com.type = 'TaskItem' and com.is_deleted = 0)")
            ->join('WWSC\ThalamusBundle\Entity\User', 'created', 'WITH', '(created.id = com.user_created)')
            ->where('u.id = '.$this->getId())
            ->andWhere('ti.responsible = '.$this->getId())
            ->andWhere('cu.enabled = 1')
            ->orderBy('com.id', 'DESC')
            ->setMaxResults($limit);
        if (!$aTask = $qb->getQuery()->getResult()) {
            return array('status' => false, 'message' => 'no projects found');
        }
        if (preg_match('!!u', utf8_decode($aTask[0]['last_comment']))) {
            $aTask[0]['last_comment'] = utf8_decode($aTask[0]['last_comment']);
        }
        $aTask[0]['posted_by'] = $aTask[0]['firstName'].' '.$aTask[0]['lastName'];
        unset($aTask[0]['firstName']);
        unset($aTask[0]['lastName']);

        return $aTask[0];
    }

    /**
     * Set lastLoggedAccount.
     *
     * @param int $lastLoggedAccount
     *
     * @return User
     */
    public function setLastLoggedAccount($lastLoggedAccount)
    {
        $this->last_logged_account = $lastLoggedAccount;

        return $this;
    }

    /**
     * Get lastLoggedAccount.
     *
     * @return int
     */
    public function getLastLoggedAccount()
    {
        return $this->last_logged_account;
    }

    /**
     * Set googleAccessToken.
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken.
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set googleID.
     *
     * @param string $googleID
     *
     * @return User
     */
    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;

        return $this;
    }

    /**
     * Get googleID.
     *
     * @return string
     */
    public function getGoogleID()
    {
        return $this->googleID;
    }

    /** Sets the email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

    /**
     * Set the canonical email.
     *
     * @param string $emailCanonical
     *
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->setUsernameCanonical($emailCanonical);

        return parent::setEmailCanonical($emailCanonical);
    }

    /**
     * Set isDeleted.
     *
     * @param bool $isDeleted
     *
     * @return User
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

    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function setGoogleDriveToken($google_drive_token)
    {
        $this->google_drive_token = $google_drive_token;
    }

    public function getGoogleDriveToken()
    {
        return $this->google_drive_token;
    }

    public function setGoogleDriveTokenExpire($google_drive_token_expire)
    {
        $this->google_drive_token_expire = $google_drive_token_expire;
    }

    public function getGoogleDriveTokenExpire()
    {
        return $this->google_drive_token_expire;
    }

    public function setGoogleDriveTokenRefresh($google_drive_token_refresh)
    {
        $this->google_drive_token_refresh = $google_drive_token_refresh;
    }

    public function getGoogleDriveTokenRefresh()
    {
        return $this->google_drive_token_refresh;
    }

    /**
     * Add companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     *
     * @return User
     */
    public function addCompanyUser($oCompany, $enabled = 0, $role = false)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $newCompanyUser = new \WWSC\ThalamusBundle\Entity\CompanyUser();
        $newCompanyUser->setCompany($oCompany);
        $newCompanyUser->setUser($this);
        if ($role) {
            $newCompanyUser->setRoleUser($em->getRepository('WWSCThalamusBundle:RoleUser')->findOneBy(array('key' => $role)));
        }
        $newCompanyUser->setEnabled($enabled);
        $em->persist($newCompanyUser);
        $em->flush();
    }

    public function updateRole($role)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $this->getCompany(), 'user' => $this));
        $oRole = $role ? $em->getRepository('WWSCThalamusBundle:RoleUser')->findOneBy(array('key' => $role)) : NULL;
        $oCompanyUser->setRoleUser($oRole);
        $em->flush();
    }

    public function getCompanies($enabled = true)
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('c')
            ->from('WWSC\ThalamusBundle\Entity\User', 'u')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(u.id = cu.user)')
            ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(cu.company = c.id)')
            ->where('u.id = '.$this->getId());
        if ($enabled) {
            $qb->andWhere('cu.enabled = 1');
        }

        return $qb->getQuery()->getResult();
    }

    public function hasAccount()
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('a.id')
            ->from('WWSC\ThalamusBundle\Entity\User', 'u')
            ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(u.id = cu.user)')
            ->join('WWSC\ThalamusBundle\Entity\Company', 'c', 'WITH', '(cu.company = c.id)')
            ->join('WWSC\ThalamusBundle\Entity\Account', 'a', 'WITH', '(c.account = a.id)')
            ->where('u.id = '.$this->getId())
            ->andWhere('cu.enabled = 1')
            ->setMaxResults(1);
        if ($oAccount = $qb->getQuery()->getResult()) {
            return $oAccount[0]['id'];
        }

        return false;
    }

    /**
     * Remove companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     */
    public function removeCompanyUser($oCompany)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $oCompany, 'user' => $this));
        $em->remove($oCompanyUser);
        $em->flush();
    }

    public function checkActiveUserCompany()
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $this->getCompany(), 'user' => $this));

        return $oCompanyUser->getEnabled();
    }

    /**
     * Get companyUser.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanyUser()
    {
        return $this->companyUser;
    }

    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getTimeTrackToday()
    {
        return \WWSC\ThalamusBundle\Entity\TimeTracker::getTimeTrackToday('user', $this->getId());
    }

    public function formatHours($hours)
    {
        if (!$hours) {
            return 0;
        }

        if (false !== strpos($hours, '.')) {
            switch ($this->getLanguageCode()) {
                case 'en':
                    return number_format($hours, 2, '.', '');
                    break;
                case 'de':
                    return number_format($hours, 2, ',', '');
                    break;
            }
        }

        return $hours;
    }

    public function formatPrice($price)
    {
        $price = str_replace(' ', '', $price);
        $price = str_replace(',', '.', $price);
        if (!$price) {
            $price = 0;
        }
        switch ($this->getLanguageCode()) {
            case 'en':
                return number_format($price, 2, '.', ',');
                break;
            case 'de':
                return number_format($price, 2, ',', '.');
                break;
        }
    }

    /**
     * Set sortingProjectsList.
     *
     * @param int $sortingProjectsList
     *
     * @return User
     */
    public function setSortingProjectsList($sortingProjectsList)
    {
        $this->sorting_projects_list = $sortingProjectsList;

        return $this;
    }

    /**
     * Get sortingProjectsList.
     *
     * @return int
     */
    public function getSortingProjectsList()
    {
        if (1 == $this->sorting_projects_list) {
            return 'projectLead';
        }

        return 'alphabet';
    }

    /**
     * Get project.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getResponsibleProjects($type = 'all')
    {
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $sql = 'SELECT p.id  FROM project AS p WHERE p.is_deleted = 0 AND p.closed_project = 0  AND p.projectleader_id = '.$this->getId();
        if ('has-responsible-project' == $type) {
            if (WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll()) {
                return true;
            } else {
                return false;
            }
        }
        $aProjects = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll();

        return array_column($aProjects, 'id');
    }

    public function getFormatDate()
    {
        if ('de' == $this->getLanguageCode()) {
            return 'd/m/Y';
        } else {
            return 'm/d/Y';
        }
    }

    public function nextDay($date)
    {
        if ('de' == $this->getLanguageCode()) {
            $date = str_replace('/', '-', $date);
        }
        $date = date($this->getFormatDate(), strtotime($date.' +1 day'));

        return $date;
    }

    public function prevDay($date)
    {
        if ('de' == $this->getLanguageCode()) {
            $date = str_replace('/', '-', $date);
        }
        $date = date($this->getFormatDate(), strtotime($date.' -1 day'));

        return $date;
    }

    public function convertDateFormat($date, $type = 'js')
    {
        if ('de' == $this->getLanguageCode()) {
            switch ($type) {
                case 'sql':
                    $oDate = \DateTime::createFromFormat('d/m/Y', $date);
                    if (!$oDate) $oDate = \DateTime::createFromFormat('d-m-Y', $date);
                    if ($oDate) {
                        $convDate = $oDate->format('Y-m-d');
                    } else {
                        $convDate = date('Y-m-d', strtotime($date));
                    }
                    break;
                case 'js':
                    $convDate = str_replace('/', '-', $date);
                    $convDate = date('m/d/Y', strtotime($convDate));
                    if ('01/01/1970' == $convDate) {
                        $convDate = $date;
                    }
                    break;
                case 'object':
                    $convDate = \DateTime::createFromFormat('d/m/Y', $date);
                    break;
                case 'month-of-timespan':
                    $aTransGermanyMonths = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
                    $convDate = \DateTime::createFromFormat('d/m/Y', $date);
                    $convDate = $aTransGermanyMonths[(int) ($convDate->format('m')) - 1].' '.$convDate->format('Y');
                    break;
            }
        } else {
            switch ($type) {
                case 'sql':
                    $convDate = date('Y-m-d', strtotime($date));
                    break;
                case 'object':
                    $convDate = \DateTime::createFromFormat('m/d/Y', $date);
                    break;
                case 'month-of-timespan':
                    $convDate = \DateTime::createFromFormat('m/d/Y', $date);
                    $convDate = $convDate->format('F Y');
                    break;
                default:
                    $convDate = $date;
            }
        }

        return $convDate;
    }

    public function encodingString($str)
    {
        if (preg_match('!!u', utf8_decode($str))) {
            return utf8_decode($str);
        } else {
            return $str;
        }
    }

    public function getDateObject($date)
    {
        return $this->convertDateFormat($date, 'object');
    }

    public function getProjectForScreenshotTool()
    {
        $container = WWSCThalamusBundle::getContainer();
        $em = $container->get('doctrine')->getManager();
        $accountId = $container->get('session')->get('account')->id;
        if(!$obj = $em->getRepository('WWSCThalamusBundle:ProjectForScreenshotTool')->findOneBy(
            array(
                'account_id' => $accountId,
                'user_id' => $this->getId(),
            )
        )){
           return null;
        }

        return $obj->getProjectId();
    }

    public function setProjectForScreenshotTool($projectId)
    {
        $container = WWSCThalamusBundle::getContainer();
        $em = $container->get('doctrine')->getManager();
        $accountId = $container->get('session')->get('account')->id;
        if(!$obj = $em->getRepository('WWSCThalamusBundle:ProjectForScreenshotTool')->findOneBy(
            array(
                'account_id' => $accountId,
                'user_id' => $this->getId(),
            )
        )){
            $obj = new ProjectForScreenshotTool();
            $obj->setUserId($this->getId());
            $obj->setAccountId($accountId);
        }
        $obj->setProjectId($projectId);
        $em->persist($obj);
        $em->flush();

        return $obj->getProjectId();
    }

    public function getTimespanSinceLastTime()
    {
        $date = date('Y-m-d H:i:s', strtotime('-4 hours',  strtotime(date('Y-m-d H:i:s'))));
        $sql = "SELECT t.date as date
                FROM time_tracker t
                WHERE t.person_id = {$this->getId()}
                AND date > '{$date}'
                AND t.time > 0
                ORDER BY date DESC
                LIMIT 0,1";

        if (!$time = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll()) {
            return false;
        }
        $nowTime = strtotime('now');
        $timeLastTrack = strtotime($time[0]['date']);
        $interval = abs($nowTime - $timeLastTrack);
        $minutes = round($interval / 60);

        return  TimeTracker::convertMinutesToTimeFormat($minutes, false);
    }
}
