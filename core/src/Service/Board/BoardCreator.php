<?php

namespace App\Service\Board;

use App\Entity\Board;
use App\Repository\BoardRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class BoardCreator
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * @param Board $board
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Board $board)
    {
        $result = $this->boardRepository->save($board);

        return $result;
    }
}