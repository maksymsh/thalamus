<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Company.
 *
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="company")
 */
class Company {
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
     * @Assert\NotBlank(message="Please enter your company name.")
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The company name is too short.",
     *     maxMessage="The company name is too long.",
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="abbreviation", type="string", length=100)
     */
    private $abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=100, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="time_zone", type="string", length=100, nullable=true)
     */
    private $timeZone;

    /**
     * @var string
     *
     * @ORM\Column(name="web_address", type="string", length=255, nullable=true)
     */
    private $webAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="office", type="string", length=255, nullable=true)
     */
    private $office;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var bool
     *
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    private $private;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="company_logo", fileNameProperty="logo")
     *
     * @var file
     *
     * This is the virtual field that will populate logo with the resulting file
     */
    protected $logoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

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
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\CompanyUser", mappedBy="company") 
     */
    private $companyUser;

    /**
     * @ORM\ManyToMany(targetEntity="WWSC\ThalamusBundle\Entity\Project", mappedBy="companies")
     */
    private $project;

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
     * @ORM\Column(name="rate_internal", type="float", length=255, nullable=true)
     */
    private $rate_internal;

    /**
     * @ORM\Column(name="rate_external", type="float", length=255, nullable=true)
     */
    private $rate_external;

    /**
     * @ORM\Column(name="expected_turnover", type="float", length=255, nullable=true)
     */
    private $expected_turnover;    

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Account", inversedBy="account")
     */
    private $account;

    /**
     * @ORM\Column(name="roles", type="string", length=100)
     */
    private $roles;

    /**
     * @ORM\Column(name="primary_company", type="boolean", nullable=true)
     */
    private $primary_company = 0;

    /**
     * @ORM\ManyToMany(targetEntity="WWSC\ThalamusBundle\Entity\Project", mappedBy="companies")
     */
    private $projects;

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
     * @return Company
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
     * Set address1.
     *
     * @param string $address1
     *
     * @return Company
     */
    public function setAddress1($address1) {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1.
     *
     * @return string
     */
    public function getAddress1() {
        return $this->address1;
    }

    /**
     * Set address2.
     *
     * @param string $address2
     *
     * @return Company
     */
    public function setAddress2($address2) {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2.
     *
     * @return string
     */
    public function getAddress2() {
        return $this->address2;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Company
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Company
     */
    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set zip.
     *
     * @param string $zip
     *
     * @return Company
     */
    public function setZip($zip) {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip.
     *
     * @return string
     */
    public function getZip() {
        return $this->zip;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Company
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set language.
     *
     * @param string $language
     *
     * @return Company
     */
    public function setLanguage($language) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Set timeZone.
     *
     * @param string $timeZone
     *
     * @return Company
     */
    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone.
     *
     * @return string
     */
    public function getTimeZone() {
        return $this->timeZone;
    }

    /**
     * Set webAddress.
     *
     * @param string $webAddress
     *
     * @return Company
     */
    public function setWebAddress($webAddress) {
        $this->webAddress = $webAddress;

        return $this;
    }

    /**
     * Get webAddress.
     *
     * @return string
     */
    public function getWebAddress() {
        return $this->webAddress;
    }

    /**
     * Set office.
     *
     * @param string $office
     *
     * @return Company
     */
    public function setOffice($office) {
        $this->office = $office;

        return $this;
    }

    /**
     * Get office.
     *
     * @return string
     */
    public function getOffice() {
        return $this->office;
    }

    /**
     * Set fax.
     *
     * @param string $fax
     *
     * @return Company
     */
    public function setFax($fax) {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax.
     *
     * @return string
     */
    public function getFax() {
        return $this->fax;
    }

    /**
     * Set private.
     *
     * @param bool $private
     *
     * @return Company
     */
    public function setPrivate($private) {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private.
     *
     * @return bool
     */
    public function getPrivate() {
        return $this->private;
    }

    /**
     * @param UploadedFile $logoFile
     */
    public function setLogoFile(File $logoFile) {
        $this->logoFile = $logoFile;
        $this->updated = new \DateTime();
    }

    /**
     * @return File
     */
    public function getLogoFile() {
        return $this->logoFile;
    }

    /**
     * Set logo.
     *
     * @param string $logo
     *
     * @return Company
     */
    public function setLogo($logo) {
        $this->logo = $logo;
    }

    public function getUsers($selectFilds = false) {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('u')
                ->from('WWSC\ThalamusBundle\Entity\Company', 'c')
                ->join('WWSC\ThalamusBundle\Entity\CompanyUser', 'cu', 'WITH', '(c.id = cu.company)')
                ->join('WWSC\ThalamusBundle\Entity\User', 'u', 'WITH', '(cu.user = u.id)')
                ->where('c.id = '.$this->getId());

        if($selectFilds){
            foreach($qb->getQuery()->getResult() as $oUser){
                foreach ($selectFilds as $fild)
                $methodName = 'get'.ucfirst($fild);
                $aUser[] = $oUser->$methodName();
            }

            return $aUser;
        }

         return $qb->getQuery()->getResult();
    }

    /**
     * Get logo.
     *
     * @return string
     */
    public function getLogo() {
        return $this->logo;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Company
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
     * @return Company
     */
    public function setUpdated($updated) {
        $this->updated = new \DateTime('now');

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
     * Set is_deleted.
     *
     * @param bool $isDeleted
     *
     * @return Company
     */
    public function setIsDeleted($isDeleted) {
        $this->is_deleted = $isDeleted;

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
     * Set account.
     *
     * @param \WWSC\ThalamusBundle\Entity\Account $account
     *
     * @return Company
     */
    public function setAccount(\WWSC\ThalamusBundle\Entity\Account $account = null) {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account.
     *
     * @return \WWSC\ThalamusBundle\Entity\Account
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Set primary_company.
     *
     * @param bool $primaryCompany
     *
     * @return Company
     */
    public function setPrimaryCompany($primaryCompany) {
        $this->primary_company = $primaryCompany;

        return $this;
    }

    /**
     * Get primary_company.
     *
     * @return bool
     */
    public function getPrimaryCompany() {
        return $this->primary_company;
    }

    /**
     * Set roles.
     *
     * @param int $roles
     *
     * @return Company
     */
    public function setRoles($roles) {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return int
     */
    public function getRoles() {
        return $this->roles;
    }

    public function getRoleName() {
        return Company::$aRoles[$this->roles];
    }

    public static $aRoles = array
        (
        'ROLE_CLIENT' => 'Client',
        'ROLE_PROVIDER' => 'Provider (Agency)',
        'ROLE_FREELANCER' => 'Sub-Contractor (Freelancer)',
    );

    /**
     * Add projects.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $projects
     *
     * @return Company
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

    /**
     * Get projects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects() {
        return $this->projects;
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
        if('anon.' != WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()){
             $this->user_created = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        }

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
        if('anon.' != WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()){
             $this->user_updated = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        }

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
     * Get project.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->companyUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     *
     * @return Company
     */
    public function addCompanyUser($oUser , $enabled = 0 )
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $newCompanyUser = new \WWSC\ThalamusBundle\Entity\CompanyUser();
        $newCompanyUser->setCompany($this);
        $newCompanyUser->setUser($oUser);
        $newCompanyUser->setEnabled($enabled);
        $em->persist($newCompanyUser);
        $em->flush();
    }

    /**
     * Remove companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     */
    public function removeCompanyUser($oUser)
    {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $oCompanyUser = $em->getRepository('WWSCThalamusBundle:CompanyUser')->findOneBy(array('company' => $this, 'user' => $oUser));
        $em->remove($oCompanyUser);
        $em->flush();
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

    public function getTimeTrackToday() {
        $accountId = WWSCThalamusBundle::getContainer()->get('session')->get('account')->id;
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $filterDateFrom = date('Y-m-d').' 00:00:01';
        $filterDateTo = date('Y-m-d').' 23:59:59';
        $sql = 'SELECT
                SUM(tt.time) as total
                FROM time_tracker AS tt
                JOIN comment as c on (tt.comment_id = c.id)  
                JOIN taskitem as ti on (ti.id = c.parent_id and c.type = "TaskItem") 
                JOIN task as t on (ti.task_id = t.id)
                JOIN project as p on (t.project_id = p.id and p.account_id = '.$accountId.')
                JOIN company_user AS cu ON (tt.person_id = cu.user_id)
                JOIN company AS comp ON (cu.company_id = comp.id AND comp.account_id = '.$accountId.' and comp.roles ="ROLE_PROVIDER")
                WHERE tt.date >="'.$filterDateFrom.'" and tt.date <= "'.$filterDateTo.'"';

        $critSQL = WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll(); 
        if(isset($critSQL[0]['total']) && $critSQL[0]['total']){
            $hours = round($critSQL[0]['total'] / 60);
            $minutes = $critSQL[0]['total'] % 60;
            $hours < 10 ? $hours = '0'.$hours : $hours;
            $minutes < 10 ? $minutes = '0'.$minutes : $minutes;

            return $hours.':'.$minutes;
        }else{
             return '00:00';
        }
    }

    /**
     * Set rateInternal.
     *
     * @param float $rateInternal
     *
     * @return Company
     */
    public function setRateInternal($rateInternal)
    {
        $this->rate_internal = $rateInternal;

        return $this;
    }

    /**
     * Get rateInternal.
     *
     * @return float
     */
    public function getRateInternal()
    {
        return $this->rate_internal;
    }

    /**
     * Set rateExternal.
     *
     * @param float $rateExternal
     *
     * @return Company
     */
    public function setRateExternal($rateExternal)
    {
        $this->rate_external = $rateExternal;

        return $this;
    }

    /**
     * Get rateExternal.
     *
     * @return float
     */
    public function getRateExternal()
    {
        return $this->rate_external;
    }

    /**
     * Set expectedTurnover.
     *
     * @param float $expectedTurnover
     *
     * @return Company
     */
    public function setExpectedTurnover($expectedTurnover)
    {
        $this->expected_turnover = $expectedTurnover;

        return $this;
    }

    /**
     * Get expectedTurnover.
     *
     * @return float
     */
    public function getExpectedTurnover()
    {
        return $this->expected_turnover;
    }

    /**
     * Set abbreviation.
     *
     * @param string $abbreviation
     *
     * @return Company
     */
    public function setAbbreviation($abbreviation)
    {
        if('' != $this->getAbbreviation() && $abbreviation != $this->getAbbreviation()){
            $this->updateProjectUrl($abbreviation);
        }
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation.
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /* update all project url that related to this company */
    protected function updateProjectUrl($abbreviation){
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $q = $qb->update('WWSC\ThalamusBundle\Entity\Project', 'p')
            ->set('p.slug', $qb->expr()->concat($qb->expr()->literal($abbreviation), 'p.project_id'))
            ->where('p.responsible_company = '.$this->getId())
            ->getQuery();
        $q->execute();
    }
}