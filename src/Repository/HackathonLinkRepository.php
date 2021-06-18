<?php

namespace App\Repository;

use App\Entity\HackathonLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HackathonLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method HackathonLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method HackathonLink[]    findAll()
 * @method HackathonLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HackathonLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HackathonLink::class);
    }

    // /**
    //  * @return HackathonLink[] Returns an array of HackathonLink objects
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
    public function findOneBySomeField($value): ?HackathonLink
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
