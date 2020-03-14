<?php

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use App\Service\Board\BoardCreator;
use App\Utilities\ResponseTrait;
use App\Utilities\SerializationTrait;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BoardController
 * @package App\Controller
 * @Route("/api/board", name="api_board_")
 */
class BoardController extends AbstractController
{
    use SerializationTrait, ResponseTrait;

    /**
     * @Route("/get", name="get", methods={"GET"})
     * @param Request $request
     * @param BoardRepository $boardRepository
     * @return Response
     */
    public function getAllBoards(Request $request, BoardRepository $boardRepository)
    {
        $boards = $boardRepository->findAllBoards();

        if (!$boards) {
            return $this->createNotFoundResponse();
        }

        $response = $this->serialize($boards, 'json', ['board.default']);

        return $this->createSuccessResponse($response);
    }

    /**
     * @Route("/{id}", name="id", methods={"GET"})
     * @param Request $request
     * @param BoardRepository $boardRepository
     * @return Response
     */
    public function getSingleBoard(Request $request, BoardRepository $boardRepository)
    {
        $board = $boardRepository->findBoardById($request->attributes->get('id'));

        if (!$board) {
            return $this->createNotFoundResponse();
        }

        $response = $this->serialize($board, 'json', ['board.single']);

        return $this->createSuccessResponse($response);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     * @param Request $request
     * @param BoardCreator $boardCreator
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createBoard(Request $request, BoardCreator $boardCreator)
    {
        $board = $this->deserialize($request->getContent(), Board::class, 'json');
        $response = $boardCreator->create($board);

        return $this->json($response, 200);
    }
}
