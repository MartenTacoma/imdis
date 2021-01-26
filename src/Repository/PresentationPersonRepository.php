<?php

namespace App\Repository;

use App\Entity\PresentationPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PresentationPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresentationPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresentationPerson[]    findAll()
 * @method PresentationPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresentationPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresentationPerson::class);
    }

    // /**
    //  * @return PresentationPerson[] Returns an array of PresentationPerson objects
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
    public function findOneBySomeField($value): ?PresentationPerson
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
