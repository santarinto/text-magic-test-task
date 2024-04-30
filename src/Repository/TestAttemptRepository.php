<?php

namespace App\Repository;

use App\Entity\TestAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestAttempt>
 *
 * @method TestAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestAttempt[]    findAll()
 * @method TestAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestAttemptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, TestAttempt::class);
    }

    /**
     * @return TestAttempt[] Returns an array of TestAttempt objects
     */
    public function getLast20TestAttempts(): array {
        return $this
            ->createQueryBuilder('ta')
            ->orderBy('ta.id', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }
}
