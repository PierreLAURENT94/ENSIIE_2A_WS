<?php

namespace App\Repository;

use App\Entity\BilletClasseDispo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BilletClasseDispo>
 *
 * @method BilletClasseDispo|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilletClasseDispo|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilletClasseDispo[]    findAll()
 * @method BilletClasseDispo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletClasseDispoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilletClasseDispo::class);
    }

//    /**
//     * @return BilletClasseDispo[] Returns an array of BilletClasseDispo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BilletClasseDispo
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
