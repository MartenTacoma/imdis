<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    
    /**
     * @return mixed
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null){
        if(is_array($orderBy) && array_key_exists('country', $orderBy)){
            return $this->createQueryBuilder('u')
                ->join('u.country', 'c')
                ->orderBy('c.name', $orderBy['country'])
                ->addOrderBy('u.name', $orderBy['name'])
                ->addOrderBy('u.email', $orderBy['name'])
                ->getQuery()
                ->getResult();
        } else {
            return parent::findBy($criteria,$orderBy, $limit, $offset);
        }
    }
    
    /**
     * @return mixed
     */
    public function findAll(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.name, p.email', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @return mixed
     */
    public function findAllStatistics($event = null){
        $q = $this->createQueryBuilder('u')
            ->select(
                "count(u.id) AS total",
                "count(distinct(u.country)) AS countries",
                "sum(CASE WHEN u.show_in_list='public' THEN 1 ELSE 0 END) AS public",
                "sum(CASE WHEN u.show_in_list='login' THEN 1 ELSE 0 END) AS login",
                "sum(CASE WHEN u.show_in_list='hide' THEN 1 ELSE 0 END) AS hide",
                "count(u.id)-count(u.country) AS no_country"
            );
        if (!empty($event)){
            $q->join('u.event', 'e')
                ->andWhere('e.id = '.$event->getId());
        }
        return $q->getQuery()
            ->getResult()[0];
    }
    
    /**
     * @return mixed
     */
    public function findAllCountries($event = null){
        $q = $this->createQueryBuilder('u')
            ->join('u.country', 'c')
            ->select(
                'c.id, c.continent, c.name',
                'count(u.id) as registrations',
                "sum(CASE WHEN u.show_in_list='public' THEN 1 ELSE 0 END) AS public",
                "sum(CASE WHEN u.show_in_list='login' THEN 1 ELSE 0 END) AS login",
                "sum(CASE WHEN u.show_in_list='hide' THEN 1 ELSE 0 END) AS hide"
            )
            ->groupBy('c.continent, c.id, c.name')
            ->orderBy('c.continent, c.name', 'ASC');
        if (!empty($event)){
            $q->join('u.event', 'e')
                ->andWhere('e.id = '.$event->getId());
        }
        return $q->getQuery()
            ->getResult();
    }
    
    public function findByEvent($event, $orderBy = null) {
        $q = $this->createQueryBuilder('u')
            ->join('u.event', 'e')
            ->andWhere('e.id = '.$event->getId());
            if(is_array($orderBy) && array_key_exists('country', $orderBy)){
                $q->join('u.country', 'c')
                ->orderBy('c.name', $orderBy['country'])
                ->addOrderBy('u.name', $orderBy['name'])
                ->addOrderBy('u.email', $orderBy['name']);
            } else {
                foreach($orderBy as $key=>$dir){
                    $q->addOrderBy('u.' . $key, $dir);
                }
            }
            return $q->getQuery()->getResult();
    }
}
