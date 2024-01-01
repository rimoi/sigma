<?php

namespace App\Repository;

use App\Entity\FluxRss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FluxRss>
 *
 * @method FluxRss|null find($id, $lockMode = null, $lockVersion = null)
 * @method FluxRss|null findOneBy(array $criteria, array $orderBy = null)
 * @method FluxRss[]    findAll()
 * @method FluxRss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FluxRssRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FluxRss::class);
    }

//    /**
//     * @return FluxRss[] Returns an array of FluxRss objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FluxRss
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
