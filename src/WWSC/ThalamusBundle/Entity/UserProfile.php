<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\Entity\User as User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Table(name="userprofile")
 */
class UserProfile {
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="office", type="string", length=255, nullable=true)
     */
    private $office;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="home", type="string", length=255, nullable=true)
     */
    private $home;

    /**
     * @var string
     *
     * @ORM\Column(name="im_name", type="string", length=100, nullable=true)
     */
    private $imName;

    /**
     * @var string
     *
     * @ORM\Column(name="service_im", type="string", length=100, nullable=true)
     */
    private $serviceIm;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="WWSC\ThalamusBundle\Entity\User", inversedBy="profile")
     */
    private $user;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set office.
     *
     * @param string $office
     *
     * @return UserProfile
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
     * Set mobile.
     *
     * @param string $mobile
     *
     * @return UserProfile
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Set fax.
     *
     * @param string $fax
     *
     * @return UserProfile
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
     * Set home.
     *
     * @param string $home
     *
     * @return UserProfile
     */
    public function setHome($home) {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home.
     *
     * @return string
     */
    public function getHome() {
        return $this->home;
    }

    /**
     * Set imName.
     *
     * @param string $imName
     *
     * @return UserProfile
     */
    public function setImName($imName) {
        $this->imName = $imName;

        return $this;
    }

    /**
     * Get imName.
     *
     * @return string
     */
    public function getImName() {
        return $this->imName;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return UserProfile
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
     * Set user.
     *
     * @param \WWSC\ThalamusBundle\Entity\User $user
     *
     * @return UserProfile
     */
    public function setUser(\WWSC\ThalamusBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return UserProfile
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set serviceIm.
     *
     * @param string $serviceIm
     *
     * @return UserProfile
     */
    public function setServiceIm($serviceIm) {
        $this->serviceIm = $serviceIm;

        return $this;
    }

    /**
     * Get serviceIm.
     *
     * @return string
     */
    public function getServiceIm() {
        return $this->serviceIm;
    }
}
