<?php

namespace App\Repository;

use App\Entity\SessionChair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SessionChair|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionChair|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionChair[]    findAll()
 * @method SessionChair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionChairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionChair::class);
    }

    // /**
    //  * @return SessionChair[] Returns an array of SessionChair objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SessionChair
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
