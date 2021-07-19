<?php

namespace App\Repository;

use App\Entity\WorkingGroupLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkingGroupLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkingGroupLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkingGroupLink[]    findAll()
 * @method WorkingGroupLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkingGroupLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkingGroupLink::class);
    }

    // /**
    //  * @return WorkingGroupLink[] Returns an array of WorkingGroupLink objects
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
    public function findOneBySomeField($value): ?WorkingGroupLink
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
