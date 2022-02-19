<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function searchByTermQuery(?string $term): Query {
        return $this->createQueryBuilder('page')
            ->where('page.name LIKE :term')
            ->orWhere('page.body LIKE :term')
            ->setParameter('term', sprintf('%%%s%%', $term))
            ->orderBy('page.name', 'ASC')
            ->getQuery();
    }
}
