<?php

namespace WWSC\ThalamusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company.
 *
 * @ORM\Entity
 * @ORM\Table(name="last_visit_to_task")
 */
class LastVisitToTask {
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
     * @ORM\Column(name="task_id", type="integer", nullable=true)
     */
    private $task;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;   

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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return LastVisitToTask
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set task.
     *
     * @param int $task
     *
     * @return LastVisitToTask
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task.
     *
     * @return int
     */
    public function getTask()
    {
        return $this->task;
    }  

    /**
     * Set user.
     *
     * @param int $user
     *
     * @return LastVisitToTask
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }
}
