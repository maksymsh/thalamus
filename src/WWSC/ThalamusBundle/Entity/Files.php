<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Files.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="files", indexes={@ORM\Index(columns={"name", "description"}, flags={"fulltext"})})
 */
class Files extends Base
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
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
    private $private;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent;

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
     * @var text
     *
     * @ORM\Column(name="annotations", type="text", nullable=true)
     */
    private $annotations;

    private $save_to_log = 1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $file_src;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $file_size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $format_file;

    /**
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;

    /**
     * @Assert\File(maxSize="349M")
     */
    public $file;

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
     * Set description.
     *
     * @param string $description
     *
     * @return File
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
     * Set private.
     *
     * @param bool $private
     *
     * @return Files
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
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
     * Set type.
     *
     * @param string $type
     *
     * @return Files
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set parent.
     *
     * @param int $parent
     *
     * @return Files
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Files
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
     * @return Files
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
     * Set is_deleted.
     *
     * @param bool $isDeleted
     *
     * @return Files
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

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
     * Set user_created.
     *
     * @ORM\PrePersist()
     *
     * @param \WWSC\ThalamusBundle\Entity\User $userCreated
     *
     * @return Files
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
     * @return Files
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
     * Set name.
     *
     * @param string $name
     *
     * @return Files
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
     * Set file_src.
     *
     * @param string $fileSrc
     *
     * @return Files
     */
    public function setFileSrc($fileSrc)
    {
        if ('GOOGLE_DRIVE' != $this->format_file) {
            $this->file_src = '/uploads/files/'.$fileSrc;
        } else {
            $this->file_src = $fileSrc;
        }

        return $this;
    }

    /**
     * Get file_src.
     *
     * @return string
     */
    public function getFileSrc()
    {
        return $this->file_src;
    }

    /**
     * Set file_size.
     *
     * @param string $fileSize
     *
     * @return Files
     */
    public function setFileSize($fileSize)
    {
        $this->file_size = $fileSize;

        return $this;
    }

    /**
     * Get file_size.
     *
     * @return string
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Files
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
     * Set category.
     *
     * @param int $category
     *
     * @return Files
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getParentInfo()
    {
        if ($this->type) {
            $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
            $critFile = array(
                'is_deleted' => 0,
                'id' => $this->parent,
            );

            return $entityManager->getRepository('WWSCThalamusBundle:'.$this->type)->findOneBy($critFile);
        } else {
            return false;
        }
    }

    public function getFileIcon()
    {
        if ('FILE' == $this->getFormatFile()) {
            $fileIcon = '/bundles/wwscthalamus/images/icon_file.png';
        } else if ('GOOGLE_DRIVE' == $this->getFormatFile()) {
            $fileIcon = '/bundles/wwscthalamus/images/gd-icon.png';
        } else {
            $fileIcon = $this->getFileSrc();
        }

        return $fileIcon;
    }

    public static $aImgFormats = array('jpg', 'jpeg', 'png', 'gif');

    /**
     * Set format_file.
     *
     * @param string $formatFile
     */
    public function setFormatFile($formatFile)
    {
        $this->format_file = $formatFile;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function checkFormatFile($formatFile)
    {
        if ('GOOGLE_DRIVE' != $this->getFormatFile()) {
            if (!in_array(pathinfo($this->getFileSrc(), PATHINFO_EXTENSION), self::$aImgFormats)) {
                $this->setFormatFile('FILE');
            } else {
                $this->setFormatFile('IMG');
            }
        }
    }

    public static function saveAttachmentFiles($gFiles, $parentId, $oProject, $type){
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        foreach($gFiles as $key => $aFile){
            $newFile = new \WWSC\ThalamusBundle\Entity\Files();
            $newFile->setName($aFile['original_name']);
            $newFile->setProject($oProject);
            $newFile->setParent($parentId);
            $newFile->setType($type);
            if(isset($aFile['annotations']) && $aFile['annotations']){
                $newFile->setAnnotations($aFile['annotations']);
            }
            if(isset($aFile['format_file']) && 'GOOGLE_DRIVE' == $aFile['format_file']){
                $newFile->setFormatFile('GOOGLE_DRIVE');
                $newFile->setFileSrc($aFile['url']);
            }else{
                $newFile->setFileSize($aFile['size']);
                $newFile->setFileSrc($key);
            }
            $em->persist($newFile);
        }
        $em->flush();
    }

    /**
     * Get format_file.
     *
     * @return string
     */
    public function getFormatFile()
    {
        return $this->format_file;
    }

    private function getLogInfoByFile($entity){
        if(!$entity->save_to_log){
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        $aRes['description'] = "<img src='/bundles/wwscthalamus/images/attachment_icon.png'>&nbsp;<a href='".$entity->getFileSrc()."'>".$this->truncation($entity->getName(), 100).'</a>';
        $aRes['project'] = $entity->getProject();

        return $aRes;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if(!$args->hasChangedField('is_deleted')){
            $aParams = $this->getLogInfoByFile($args->getEntity());
            $aParams['action'] = 'Updated by';
            $this->things[] = $aParams;
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if($aParams = $this->getLogInfoByFile($args->getEntity())){
            $aParams['action'] = 'Uploaded by';
            $this->saveLog($aParams);
        }
    }

    /**
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return Files
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

    public function removeFile(){
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $fileSrc = __DIR__.'/../../../../web'.$this->getFileSrc();
        if(file_exists($fileSrc)){
            unlink($fileSrc);
        }
        $em->remove($this);
        $em->flush();
    }

    /**
     * Set annotations.
     *
     * @param string $annotations
     *
     * @return Files
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
