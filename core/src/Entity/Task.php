<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{
    const TASK_PRIORITY_LOW = 0;
    const TASK_PRIORITY_MEDIUM = 1;
    const TASK_PRIORITY_HIGH = 2;

    const TASK_ACTION_START = 'start';
    const TASK_ACTION_COMPLETE = 'complete';

    /**
     * @JMS\Groups({"board.single"})
     * @JMS\Type("int")
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups({"board.single"})
     * @JMS\Type("App\Entity\Board")
     *
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     *
     * @var Board
     */
    private $board;

    /**
     * @JMS\Groups({"board.single", "task.default"})
     * @JMS\Type("string")
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @JMS\Groups({"task.default"})
     * @JMS\Type("string")
     *
     * @ORM\Column(type="string", length=1000)
     *
     * @var string
     */
    private $description;

    /**
     * @JMS\Groups({"board.single", "task.default"})
     * @JMS\Type("int")
     *
     * @ORM\Column(type="integer", options={
     *     "comment"="0 - Low, 1 - Medium, 2 - High"
     * })
     *
     * @var int
     */
    private $priority;

    /**
     * @JMS\Groups({"board.single", "task.default"})
     * @JMS\SerializedName("isInProgress")
     *
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $isInProgress = false;

    /**
     * @JMS\Groups({"board.single", "task.default"})
     * @JMS\SerializedName("isCompleted")
     *
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $isCompleted = false;

    /**
     * @JMS\Groups({"task.default"})
     * @JMS\SerializedName("createdAt")
     *
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $createdAt;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    private $action;

    /**
     * @JMS\Exclude()
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param Board $board
     * @return $this
     */
    public function setBoard(Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsInProgress(): ?bool
    {
        return $this->isInProgress;
    }

    /**
     * @param bool $isInProgress
     * @return $this
     */
    public function setIsInProgress(bool $isInProgress): self
    {
        $this->isInProgress = $isInProgress;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return $this
     */
    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
