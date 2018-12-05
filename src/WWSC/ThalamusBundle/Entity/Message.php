<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Comment.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="message", indexes={
 *     @ORM\Index(columns={"title", "description"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"title"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"description"}, flags={"fulltext"})
 * })
 */
class Message extends Base{
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Category")
     */
    private $category;

    /**
     * @var bool
     *
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    private $private = 0;

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
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;

    private $comments;

    /**
     * Get id.
     *
     * @return int
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
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
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
            if($this->getComments()){
                foreach($this->getComments() as $item){
                    $item->setIsDeleted(1);
                }
            }
            if($this->getFiles()){
                foreach($this->getFiles() as $item){
                    $item->removeFile();
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

    public function getComments() {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository('WWSCThalamusBundle:Comment')->findBy(array(
                    'is_deleted' => 0, 'parent_id' => $this->id, 'type' => 'Message',
        ));
    }    

    public function getFiles($formatFile = false)
    {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $critFile = array(
            'is_deleted' => 0,
            'parent' => $this->id, 
            'type' => 'Message',
        );
        if($formatFile){
            $critFile['format_file'] = $formatFile;
        }

        return $entityManager->getRepository('WWSCThalamusBundle:Files')->findBy($critFile);
    }    

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set category.
     *
     * @param \WWSC\ThalamusBundle\Entity\Category $category
     *
     * @return Message
     */
    public function setCategory(\WWSC\ThalamusBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \WWSC\ThalamusBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Message
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
     * Set private.
     *
     * @param bool $private
     *
     * @return Message
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }    

    private function getLogInfoByMessage($entity){
        if(!$entity->save_to_log){
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        $oProject = $entity->getProject();
        $url = '/project/'.$oProject->getSlug().'/message/'.$entity->getId().'/comments';
        $aRes['description'] = "<a href='".$url."'>".$this->truncation($entity->getTitle(), 100).'</a>';
        $aRes['project'] = $entity->getProject();

        return $aRes;
    }     

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if(!$args->hasChangedField('is_deleted')){
            $aParams = $this->getLogInfoByMessage($args->getEntity());
            $aParams['action'] = 'Updated by';
            $this->things[] = $aParams;
        }
    }

    public function hasAccessToMessage (){
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if(1 == $this->getPrivate() && $this->getUserCreated()->getCompany()->getId() != $activeUser->getCompany()->getId()){
            return false;
        }
        if('ROLE_PROVIDER' != $activeUser->getCompany()->getRoles()){
            $sql = 'SELECT id FROM subscribe_email as se join company_user as cu ON se.user_id = cu.user_id
                 WHERE se.type = "Message" and se.parent = '.$this->id.' and cu.company_id = '.$activeUser->getCompany()->getId().' LIMIT 1 ';
            if(0 == count(WWSCThalamusBundle::getContainer()->get('database_connection')->query($sql)->fetchAll())){
                return false;
            }
        }

        return true;
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if($aParams = $this->getLogInfoByMessage($args->getEntity())){
            $aParams['action'] = 'Posted by';
            $this->saveLog($aParams);
        }
    }

   public  function  getActiveSubscribed($typeShow = 'id'){
     $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
     $critSubspeople = $em->getRepository('WWSCThalamusBundle:SubscribeEmail')->findBy(array('type' => 'Message', 'parent' => $this->id));
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

    /**
     * Get private.
     *
     * @return bool
     */
    public function getPrivate()
    {
        return $this->private;
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
        $this->replyUID = 'm_'
            .$this->getId()
            .md5(uniqid(rand(), true));
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
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return Message
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
}
