<?php

namespace App\Repository;

use App\Entity\HackathonSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HackathonSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method HackathonSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method HackathonSession[]    findAll()
 * @method HackathonSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HackathonSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HackathonSession::class);
    }

    // /**
    //  * @return HackathonSession[] Returns an array of HackathonSession objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HackathonSession
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
