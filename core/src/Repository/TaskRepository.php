<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findTaskById($id)
    {
        $task = $this->find($id);

        return $task;
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
            'message' => 'Task was created successfully.',
        );
    }
}
