<?php

namespace App\Controller;

use App\Repository\BoardRepository;
use App\Utilities\ResponseTrait;
use App\Utilities\SerializationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
