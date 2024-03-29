<?php

namespace App\Repository;

use App\Entity\PosterSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PosterSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosterSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosterSession[]    findAll()
 * @method PosterSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosterSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosterSession::class);
    }

    /**
     * @return mixed
     */
    public function findAll(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.date, p.time_start')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return PosterSession[] Returns an array of PosterSession objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PosterSession
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
