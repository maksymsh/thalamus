<?php

namespace WWSC\ThalamusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="project_for_screenshot_tool", uniqueConstraints={@ORM\UniqueConstraint(columns={"user_id", "project_id", "account_id"})})
 */
class ProjectForScreenshotTool
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $user_id;

    /**
     * @var int
     *
     * @ORM\Column(name="project_id", type="integer")
     */
    protected $project_id;

    /**
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer")
     */
    protected $account_id;

    /**
     * Set project_id.
     *
     * @param int $projectId
     *
     * @return ProjectForScreenshotTool
     */
    public function setProjectId($projectId)
    {
        $this->project_id = $projectId;

        return $this;
    }

    /**
     * Get project_id.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Set account_id.
     *
     * @param int $accountId
     *
     * @return ProjectForScreenshotTool
     */
    public function setAccountId($accountId)
    {
        $this->account_id = $accountId;

        return $this;
    }

    /**
     * Get account_id.
     *
     * @return int
     */
    public function getAccountId()
    {
        return $this->account_id;
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
     * Set user_id.
     *
     * @param int $userId
     *
     * @return ProjectForScreenshotTool
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
