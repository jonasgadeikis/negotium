<?php

namespace App\Service\Board;

use App\Entity\Board;
use App\Entity\User;
use App\Repository\BoardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class BoardCreator
 * @package App\Service\Board
 */
class BoardCreator
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        BoardRepository $boardRepository,
        UserRepository $userRepository
    ) {
        $this->boardRepository = $boardRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Board $board
     * @param User $user
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Board $board, User $user)
    {
        $board->setUser($user);

        $result = $this->boardRepository->save($board);

        return $result;
    }
}