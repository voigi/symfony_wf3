<?php

namespace App\Repository;

use App\Entity\Auteurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Auteurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteurs[]    findAll()
 * @method Auteurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteurs::class);
    }

    // /**
    //  * @return Auteurs[] Returns an array of Auteurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Auteurs
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
