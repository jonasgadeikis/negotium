<?php

namespace App\Repository;

use App\Entity\Board;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Board|null find($id, $lockMode = null, $lockVersion = null)
 * @method Board|null findOneBy(array $criteria, array $orderBy = null)
 * @method Board[]    findAll()
 * @method Board[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Board::class);
    }

    public function findAllBoards()
    {
        // TODO: Later by given User id (findAllBoardsByUserId)

        $boards = $this->findAll();

        return $boards;
    }

    public function findBoardById($id)
    {
        $board = $this->find($id);

        return $board;
    }
}
