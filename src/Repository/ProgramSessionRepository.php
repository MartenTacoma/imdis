<?php

namespace App\Repository;

use App\Entity\ProgramSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgramSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramSession[]    findAll()
 * @method ProgramSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramSession::class);
    }
    
    /**
     * @return mixed
     */
    public function findAll(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.date, p.time_start', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ProgramSession[] Returns an array of ProgramSession objects
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
    public function findOneBySomeField($value): ?ProgramSession
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
