<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class TaskStatusChanger
 * @package App\Service\Task
 */
class TaskStatusChanger
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Task $task
     * @return null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changeStatus(Task $task)
    {
        $foundTask = $this->taskRepository->find($task->getId());

        switch ($task->getAction()) {
            case Task::TASK_ACTION_START:
                $foundTask->setIsInProgress(true);
                break;
            case Task::TASK_ACTION_COMPLETE:
                $foundTask->setIsInProgress(false);
                $foundTask->setIsCompleted(true);
                break;
        }

        $result = $this->taskRepository->save($foundTask);

        return $result;
    }
}