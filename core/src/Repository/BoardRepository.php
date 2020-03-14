<?php

namespace App\Repository;

use App\Entity\Board;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

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

    /**
     * @return Board[]
     */
    public function findAllBoards()
    {
        // TODO: Later by given User id (findAllBoardsByUserId)

        $boards = $this->findAll();

        return $boards;
    }

    /**
     * @param $id
     * @return Board|null
     */
    public function findBoardById($id)
    {
        $board = $this->find($id);

        return $board;
    }

    /**
     * @param $data
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($data)
    {
        $em = $this->getEntityManager();
        $em->persist($data);
        $em->flush();

        return array(
            'message' => 'Board was created successfully.',
        );
    }
}
