<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
/**
 * Category.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="category")
 */
class Category {
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
     * @ORM\Column(name="name" ,type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type",type="string", length=255)
     */
    private $type;

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
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\Project", inversedBy="project")
     */
    private $project;
    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=true)
     */
    private $is_deleted = 0;

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
     * @param string $name
     *
     * @return File
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
     * Set type.
     *
     * @param string $type
     *
     * @return Category
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

    public static function getACategory($par){
        $critCategory = WWSCThalamusBundle::getContainer()->get('doctrine')->getRepository('WWSCThalamusBundle:Category')->findBy(array(
            'is_deleted' => 0,
            'project' => $par['project'],
            'type' => $par['type'],
        ));
        $aCategory = array();
        if($critCategory){
            foreach($critCategory as $oCategory){
                $aCategory[$oCategory->getId()] = $oCategory->getName();
            }
        }
        $aCategory['add!'] = '— add a new category —';

        return $aCategory;
    }

    /**
     * Set project.
     *
     * @param \WWSC\ThalamusBundle\Entity\Project $project
     *
     * @return Category
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
}
