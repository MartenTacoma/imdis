<?php

namespace App\Repository;

use App\Entity\Committee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Committee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Committee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Committee[]    findAll()
 * @method Committee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommitteeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Committee::class);
    }

    // /**
    //  * @return Committee[] Returns an array of Committee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Committee
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
