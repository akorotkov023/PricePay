<?php

namespace App\Repository;

use App\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 */
class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function existsByCode(string $code): bool
    {
        return null !== $this->findOneBy(['code' => $code]);
    }

    public function findValueByCode(string $code): int
    {
        return $this->createQueryBuilder('c')
            ->select('c.value')
            ->where('c.code = :val')
            ->setParameter('val', $code)
            ->getQuery()
            ->getFirstResult();
    }

    //    public function findOneBySomeField($value): ?Coupon
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
