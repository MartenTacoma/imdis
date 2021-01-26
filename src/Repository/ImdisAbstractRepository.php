<?php

namespace App\Repository;

use App\Entity\ImdisAbstract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImdisAbstract|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImdisAbstract|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImdisAbstract[]    findAll()
 * @method ImdisAbstract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImdisAbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImdisAbstract::class);
    }

    // /**
    //  * @return ImdisAbstract[] Returns an array of ImdisAbstract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImdisAbstract
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
