<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Company.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="writeboard", indexes={
 *     @ORM\Index(columns={"name", "description"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"name"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"description"}, flags={"fulltext"}),
 * })
 */
class Writeboard extends Base {
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
     * @var string
     *
     * @ORM\Column(name="reply_uid", type="string", length=255, nullable=true)
     */
    private $replyUID;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=true)
     */
    private $version;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    private $save_to_log = 1;

    /**
     * Constructor.
     */ /**
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
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;

    private $comments;

    /**
     * Get id.
     *
     * @return integer
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
     * @return Writeoboard
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
     * Get replyUID.
     *
     * @return string
     */
    public function getReplyUID()
    {
        return $this->replyUID;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Writeoboard
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
     * Set sort.
     *
     * @param int $sort
     *
     * @return Writeoboard
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Writeoboard
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
     * @return Writeoboard
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
     * @return Writeoboard
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted.
     *
     * @return boolean
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
     * Get userUpdated.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUserUpdated()
    {
        return $this->user_updated;
    }

    public function getVersionsWriteboard()
    {
        $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $qb->select('w.id, w.name, w.version, w.created')
                ->from('WWSC\ThalamusBundle\Entity\Writeboard', 'w')
                ->where('w.is_deleted = 0')
                ->andWhere('w.number ='.$this->getNumber())
                ->orderBy('w.created ', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Writeoboard
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

    /**
     * @return Writeboard
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version.
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

     public  function  getActiveSubscribed($typeShow = 'id'){
    $qb = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->createQueryBuilder();
    $qb->select('se')
            ->from('WWSC\ThalamusBundle\Entity\SubscribeEmail', 'se')
            ->join('WWSC\ThalamusBundle\Entity\User', 'u', 'WITH', '(se.user = u.id)')
            ->join('u.project', 'p')
            ->where("se.type = 'Writeboard'")
            ->andWhere('se.parent ='.$this->getNumber())
            ->andWhere('p.id ='.$this->getProject()->getId());

     $critSubspeople = $qb->getQuery()->getResult();

     $aSubspeople = array();

     if('id' == $typeShow){
         foreach($critSubspeople as $oSubsPeople){
            $aSubspeople[$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getId();
         }
     }
     if('info' == $typeShow){
         foreach($critSubspeople as $oSubsPeople){
            $aSubspeople['email'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getEmail();
            $aSubspeople['lang'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getLanguageCode();
            $aSubspeople['name'][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getFirstName().' '.$oSubsPeople->getUser()->getLastName();
         }
     }
     if('company-info' == $typeShow){
        foreach($critSubspeople as $oSubsPeople){
             if($oSubsPeople->getUser()->getCompany()){
                $aSubspeople[$oSubsPeople->getUser()->getCompany()->getName()][$oSubsPeople->getUser()->getId()] = $oSubsPeople->getUser()->getFirstName().' '.$oSubsPeople->getUser()->getLastName();
             }
        }
     }

     return $aSubspeople;
    }

    public function getFiles($formatFile = false)
    {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $critFile = array(
            'is_deleted' => 0,
            'parent' => $this->id, 
            'type' => 'Writeboard',
        );
        if($formatFile){
            $critFile['format_file'] = $formatFile;
        }

        return $entityManager->getRepository('WWSCThalamusBundle:Files')->findBy($critFile);
    }

    private function getLogInfoByWriteboard($entity){
        if(!$entity->save_to_log){
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        $oProject = $entity->getProject();
        if(!$this->number){
            $number = $this->id;
        }else{
            $number = $this->number;
        }
        $url = '/project/'.$oProject->getSlug().'/writeboards/'.$number.'/show';
        $aRes['description'] = "<a href='".$url."'>".$this->truncation($entity->getDescription(), 100).'</a>';
        $aRes['project'] = $entity->getProject();

        return $aRes;
    }        

    /**
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if($aParams = $this->getLogInfoByWriteboard($args->getEntity())){
            $aParams['action'] = 'Updated by';
            if(!$this->version){
                $this->version = 1;
                $aParams['action'] = 'Posted by';
            }
            if(!$this->number){
                $this->number = $this->id;
            }
            $this->saveLog($aParams);
        }
    }

    public function hasAccessToWriteboard(){
       $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
       if('ROLE_PROVIDER' != $activeUser->getCompany()->getRoles()){
            $sql = 'SELECT id FROM subscribe_email as se WHERE se.type = "Writeboard" and se.parent = '.$this->number.' and se.user_id = '.$activeUser->getId().' LIMIT 1 ';
            if(0 == count(WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll())){
                return false;
            }
        }

        return true;
    }    

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Writeboard
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Writeboard
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
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
        $this->replyUID = 'w_'
            .$this->getId()
            .md5(uniqid(rand(), true));
        WWSCThalamusBundle::getContainer()->get('doctrine')->getManager()->flush();

        return $this;
    }

    /**
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return Writeboard
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
}
