<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Repository\BoardRepository;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class TaskCreator
 * @package App\Service\Task
 */
class TaskCreator
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(
        BoardRepository $boardRepository,
        TaskRepository $taskRepository
    )
    {
        $this->boardRepository = $boardRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Task $task
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Task $task)
    {
        $task->setBoard($this->boardRepository->find($task->getBoard()->getId()));
        $task->setCreatedAt(new DateTime());

        $result = $this->taskRepository->save($task);

        return $result;
    }
}