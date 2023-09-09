<?php

namespace App\Repository;

use App\Entity\TrainV2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainV2>
 *
 * @method TrainV2|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainV2|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainV2[]    findAll()
 * @method TrainV2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainV2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainV2::class);
    }

//    /**
//     * @return TrainV2[] Returns an array of TrainV2 objects
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

//    public function findOneBySomeField($value): ?TrainV2
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
