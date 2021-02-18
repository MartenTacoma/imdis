<?php

namespace App\Repository;

use App\Entity\UserPoster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPoster|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPoster|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPoster[]    findAll()
 * @method UserPoster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPosterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPoster::class);
    }

    // /**
    //  * @return UserPoster[] Returns an array of UserPoster objects
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
    public function findOneBySomeField($value): ?UserPoster
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
