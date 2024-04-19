<?php

namespace App\Repository;

use App\Entity\Twoote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Twoote>
 *
 * @method Twoote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Twoote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Twoote[]    findAll()
 * @method Twoote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwooteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Twoote::class);
    }

    //    /**
    //     * @return Twoote[] Returns an array of Twoote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Twoote
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
