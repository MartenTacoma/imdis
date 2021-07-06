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
    
    public function findOneByCurrentOrNext(): ?ProgramBlock
    {
        $ts = time() + (15 * 60);
        $q = $this->createQueryBuilder('p');
        return $q->where($q->expr()->orX(
                $q->expr()->gt('p.date', ':date'),
                $q->expr()->andX(
                    $q->expr()->eq('p.date', ':date'),
                    $q->expr()->gt('p.time_end', ':time')
                )
            ))
            ->setParameter('date', date('Y-m-d', $ts))
            ->setParameter('time', date('H:i', $ts))
            ->orderBy('p.date, p.time_start', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function findOneByAnchor($date, $time, $events){
        $q = $this->createQueryBuilder('p');
        $result = $q->where(
            $q->expr()->andX(
                $q->expr()->eq('p.date', ':date'),
                $q->expr()->eq('p.time_start', ':time')
            )
        )
        ->setParameter('date', $date)
        ->setParameter('time', $time)
        ->getQuery()
        ->getResult();
        if(count($result) == 1){
            return $result[0];
        } else {
            foreach($result as $block){
                $blockEvents = [];
                foreach ($block->getEvent() as $blockEvent) {
                    $blockEvents[] = $blockEvent->getSlug();
                }
                if(count(array_diff($blockEvents, $events)) == 0 && count(array_diff($events, $blockEvents)) == 0){
                    return $block;
                }
            }
            return null;
        }
    }
}
