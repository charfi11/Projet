<?php

namespace App\Repository;

use App\Entity\Trophee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Trophee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trophee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trophee[]    findAll()
 * @method Trophee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TropheeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trophee::class);
    }

    // /**
    //  * @return Trophee[] Returns an array of Trophee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trophee
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
