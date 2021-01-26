<?php

namespace App\Repository;

use App\Entity\CommitteePerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommitteePerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommitteePerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommitteePerson[]    findAll()
 * @method CommitteePerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommitteePersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommitteePerson::class);
    }

    // /**
    //  * @return CommitteePerson[] Returns an array of CommitteePerson objects
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
    public function findOneBySomeField($value): ?CommitteePerson
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
