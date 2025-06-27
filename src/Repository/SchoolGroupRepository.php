<?php

namespace App\Repository;

use App\Entity\SchoolGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SchoolGroup>
 *
 * @method SchoolGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchoolGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchoolGroup[]    findAll()
 * @method SchoolGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchoolGroup::class);
    }

//    /**
//     * @return SchoolGroup[] Returns an array of SchoolGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SchoolGroup
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
