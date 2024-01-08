<?php

namespace App\Repository;

use App\Entity\EssaiVirtuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EssaiVirtuel>
 *
 * @method EssaiVirtuel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EssaiVirtuel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EssaiVirtuel[]    findAll()
 * @method EssaiVirtuel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EssaiVirtuelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EssaiVirtuel::class);
    }

//    /**
//     * @return EssaiVirtuel[] Returns an array of EssaiVirtuel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EssaiVirtuel
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
