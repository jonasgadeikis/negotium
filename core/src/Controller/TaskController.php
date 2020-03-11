<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\Task\TaskStatusChanger;
use App\Utilities\ResponseTrait;
use App\Utilities\SerializationTrait;
use App\Service\Task\TaskCreator;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("api/task", name="api_task_")
 */
class TaskController extends AbstractController
{
    use SerializationTrait, ResponseTrait;

    /**
     * @Route("/{id}", name="id", methods={"GET"})
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns single Task object",
     *     @SWG\Schema(
     *         type="object",
     *     )
     * )
     *
     * @SWG\Response(
     *     response="404",
     *     description="Task not found",
     *     @SWG\Schema(
     *         type="object",
     *     )
     * )
     * @param Request $request
     * @param TaskRepository $taskRepository
     * @return Response|JsonResponse
     */
    public function getSingleTask(Request $request, TaskRepository $taskRepository)
    {
        $task = $taskRepository->findTaskById($request->attributes->get('id'));

        if (!$task) {
            return $this->createNotFoundResponse();
        }

        $response = $this->serialize($task, 'json', ['task.default']);

        return $this->createSuccessResponse($response);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     * @param Request $request
     * @param TaskCreator $taskCreator
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createTask(Request $request, TaskCreator $taskCreator)
    {
        $task = $this->deserialize($request->getContent(), Task::class, 'json');
        $response = $taskCreator->create($task);

        return $this->json($response, 200);
    }

    /**
     * @Route("/change-status", name="change_status", methods={"POST"})
     * @param Request $request
     * @param TaskStatusChanger $taskStatusChanger
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changeTaskStatus(Request $request, TaskStatusChanger $taskStatusChanger)
    {
        $task = $this->deserialize($request->getContent(), Task::class, 'json');
        $response = $taskStatusChanger->changeStatus($task);

        return $this->json($response, 200);
    }
}
