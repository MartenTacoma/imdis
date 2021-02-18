<?php

namespace App\Repository;

use App\Entity\UserPresentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPresentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPresentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPresentation[]    findAll()
 * @method UserPresentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPresentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPresentation::class);
    }

    // /**
    //  * @return UserPresentation[] Returns an array of UserPresentation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPresentation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
