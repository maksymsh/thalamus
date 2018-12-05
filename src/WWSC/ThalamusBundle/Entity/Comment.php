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
 * @ORM\Table(name="comment", indexes={@ORM\Index(columns={"description"}, flags={"fulltext"})})
 */
class Comment extends Base
{
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    private $private = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer")
     */
    private $parent_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    private $save_to_log = 1;

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
     * @ORM\OneToOne(targetEntity="WWSC\ThalamusBundle\Entity\TimeTracker", mappedBy="comment", cascade={"all"})
     */
    protected $time_tracker;

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
     * Set description.
     *
     * @param string $description
     *
     * @return Task
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
        $description = htmlspecialchars_decode ($this->description);
        if (preg_match('!!u', utf8_decode($description))) {
            return utf8_decode($description);
        } else {
            return $description;
        }
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Task
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
     * @return Task
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
    public function setUserUpdated()
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
     * @return Task
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        if (1 == $isDeleted) {
            if ($this->getTimeTracker()) {
                foreach ($this->getTimeTracker() as $item) {
                    $item->setIsDeleted(1);
                }
            }
            if ($this->getFiles()) {
                foreach ($this->getFiles() as $item) {
                    $item->removeFile();
                }
            }
        }

        return $this;
    }

    /**
     * Get is_deleted.
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Comment
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
     * Set parent_id.
     *
     * @param int $parentId
     *
     * @return Comment
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;

        return $this;
    }

    /**
     * Get parent_id.
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    public function getParentInfo()
    {
        if ($this->type) {
            $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
            $critFile = array(
                'is_deleted' => 0,
                'id' => $this->parent_id,
            );

            return $entityManager->getRepository('WWSCThalamusBundle:'.$this->type)->findOneBy($critFile);
        } else {
            return false;
        }
    }

    public function canBeEdited()
    {
        $oUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        if (WWSCThalamusBundle::getContainer()->get('security.context')->isGranted('ROLE_PROVIDER') || $oUser->getId() == $this->getUserCreated()->getId()) {
            $timeCanBeEdited = strtotime('+15 minutes', strtotime($this->created->format('Y-m-d H:i:s'))) - strtotime('now');
            if ($timeCanBeEdited > 0) {
                $timeCanBeEdited = date('i:s', $timeCanBeEdited);

                return $timeCanBeEdited;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getFiles($formatFile = false)
    {
        $entityManager = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $critFile = array(
            'is_deleted' => 0,
            'parent' => $this->id,
            'type' => 'Comment',
        );
        if ($formatFile) {
            $critFile['format_file'] = $formatFile;
        }

        return $entityManager->getRepository('WWSCThalamusBundle:Files')->findBy($critFile);
    }

    /**
     * Set time_tracker.
     *
     * @param \WWSC\ThalamusBundle\Entity\TimeTracker $timeTracker
     *
     * @return Comment
     */
    public function setTimeTracker(\WWSC\ThalamusBundle\Entity\TimeTracker $timeTracker = null)
    {
        $this->time_tracker = $timeTracker;

        return $this;
    }

    /**
     * Get time_tracker.
     *
     * @return \WWSC\ThalamusBundle\Entity\TimeTracker
     */
    public function getTimeTracker()
    {
        return $this->time_tracker;
    }

    private function getLogInfoByComment($entity)
    {
        if (!$entity->save_to_log) {
            return false;
        }
        $aRes = array();
        $aRes['object_id'] = $entity->getId();
        if ($parent = $entity->getParentInfo()) {
            switch ($entity->getType()) {
                case 'TaskItem':
                    $oTask = $parent->getTask();
                    $oProject = $oTask->getProject();
                    $aRes['project'] = $oProject;
                    $url = '/project/'.$oProject->getSlug().'/task/'.$oTask->getId().'/item/'.$parent->getId().'/comments';
                    if (!$description = $parent->getDescription()) {
                        $description = $parent->gettask()->getName();
                    }
                    $aRes['description'] = "<a href='".$url.'#c_'.$entity->getId()."'>Re:"
                        .$this->truncation($description, 100)
                        .'</a>';
                    break;
                case 'Message' :
                    $oProject = $parent->getProject();
                    $aRes['project'] = $oProject;
                    $url = '/project/'.$oProject->getSlug().'/message/'.$parent->getId().'/comments';
                    $aRes['description'] = "<a href='".$url.'#c_'.$entity->getId()."'>Re:"
                        .$this->truncation($parent->getTitle(), 100)
                        .'</a>';
                    break;
                case 'Writeboard' :
                    $oProject = $parent->getProject();
                    $aRes['project'] = $oProject;
                    $url = '/project/'.$oProject->getSlug().'/Writeboard/'.$parent->getId().'/comments';
                    $aRes['description'] = "<a href='".$url.'#c_'.$entity->getId()."'>Re:"
                        .$this->truncation($parent->getDescription(), 100)
                        .'</a>';
                    break;
            }
        }

        return $aRes;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if (!$args->hasChangedField('is_deleted')) {
            $aParams = $this->getLogInfoByComment($args->getEntity());
            $aParams['action'] = 'Updated by';
            $this->things[] = $aParams;
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if ($aParams = $this->getLogInfoByComment($args->getEntity())) {
            $aParams['action'] = 'Posted by';
            $this->saveLog($aParams);
        }
    }

    /**
     * Set private.
     *
     * @param bool $private
     *
     * @return Comment
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private.
     *
     * @return boolean
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set saveToLog.
     *
     * @param bool $saveToLog
     *
     * @return Comment
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
