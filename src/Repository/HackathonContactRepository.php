<?php

namespace App\Repository;

use App\Entity\HackathonContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HackathonContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method HackathonContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method HackathonContact[]    findAll()
 * @method HackathonContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HackathonContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HackathonContact::class);
    }

    // /**
    //  * @return HackathonContact[] Returns an array of HackathonContact objects
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
    public function findOneBySomeField($value): ?HackathonContact
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
