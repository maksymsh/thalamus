<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="search_history")
 */
class SearchHistory {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     */
    private $scope;

    /**
     * @var int
     *
     * @ORM\Column(name="project_id", type="integer", nullable=true)
     */
    private $project_id;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=255)
     */
    private $search;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

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
     * Set scope.
     *
     * @param string $scope
     *
     * @return SearchHistory
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set projectId.
     *
     * @param int $projectId
     *
     * @return SearchHistory
     */
    public function setProjectId($projectId)
    {
        $this->project_id = $projectId;

        return $this;
    }

    /**
     * Get projectId.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Set search.
     *
     * @param string $search
     *
     * @return SearchHistory
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search.
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return SearchHistory
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
     * Set user.
     *
     * @ORM\PrePersist()
     *
     * @param \WWSC\ThalamusBundle\Entity\User $user
     *
     * @return SearchHistory
     */
    public function setUser($user)
    {
        $this->user = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();

        return $this;
    }

    /**
     * Get user.
     *
     * @return \WWSC\ThalamusBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public static function saveSearchHistory($search, $scope = null, $projectId = null)
    {
        $userId = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $newSearchHistory = new SearchHistory();
        $newSearchHistory->setScope($scope);
        $newSearchHistory->setSearch($search);
        $newSearchHistory->setUser($userId);
        $newSearchHistory->setProjectId($projectId);
        $em->persist($newSearchHistory);
        $em->flush();
    }

    public static function getSearchHistory($projectId = null)
    {
        $userId = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();

        return $em->getRepository('WWSCThalamusBundle:SearchHistory')->findBy(array('project_id' => $projectId, 'user' => $userId));
    }

    public static function clearSearchHistory($projectId = null){
        $userId = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser()->getId();
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        if($projectId){
            $remove = $em->createQuery("DELETE FROM WWSC\ThalamusBundle\Entity\SearchHistory as sh WHERE sh.project_id='$projectId' and sh.user = $userId")->getResult();
        }else{
            $remove = $em->createQuery("DELETE FROM WWSC\ThalamusBundle\Entity\SearchHistory as sh WHERE sh.user = $userId")->getResult();
        }
    }
}
