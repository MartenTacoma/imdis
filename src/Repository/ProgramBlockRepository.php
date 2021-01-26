<?php

namespace App\Repository;

use App\Entity\ProgramBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgramBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramBlock[]    findAll()
 * @method ProgramBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramBlock::class);
    }

    public function findAll(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.date, p.time_start', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return ProgramBlock[] Returns an array of ProgramBlock objects
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
    public function findOneBySomeField($value): ?ProgramBlock
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
