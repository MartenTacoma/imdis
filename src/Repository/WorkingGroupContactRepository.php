<?php

namespace App\Repository;

use App\Entity\WorkingGroupContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkingGroupContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkingGroupContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkingGroupContact[]    findAll()
 * @method WorkingGroupContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkingGroupContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkingGroupContact::class);
    }

    // /**
    //  * @return WorkingGroupContact[] Returns an array of WorkingGroupContact objects
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
    public function findOneBySomeField($value): ?WorkingGroupContact
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
