<?php

namespace WWSC\ThalamusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="role_user")
 */
class RoleUser {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=255)
     */
    protected $key;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /** 
     * @ORM\OneToMany(targetEntity="WWSC\ThalamusBundle\Entity\CompanyUser", mappedBy="role_user") 
     */
    private $companyUser;

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
     * Set key.
     *
     * @param string $key
     *
     * @return RoleUser
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return RoleUser
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
     * Constructor.
     */
    public function __construct()
    {
        $this->companyUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     *
     * @return RoleUser
     */
    public function addCompanyUser(\WWSC\ThalamusBundle\Entity\CompanyUser $companyUser)
    {
        $this->companyUser[] = $companyUser;

        return $this;
    }

    /**
     * Remove companyUser.
     *
     * @param \WWSC\ThalamusBundle\Entity\CompanyUser $companyUser
     */
    public function removeCompanyUser(\WWSC\ThalamusBundle\Entity\CompanyUser $companyUser)
    {
        $this->companyUser->removeElement($companyUser);
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
}
