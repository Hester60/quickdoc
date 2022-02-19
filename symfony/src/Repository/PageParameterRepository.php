<?php

namespace App\Repository;

use App\Entity\PageParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageParameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageParameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageParameter[]    findAll()
 * @method PageParameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageParameter::class);
    }

    // /**
    //  * @return PageParameter[] Returns an array of PageParameter objects
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
    public function findOneBySomeField($value): ?PageParameter
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
