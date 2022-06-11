<?php

namespace App\Repository;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExchangeRate>
 *
 * @method ExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRate[]    findAll()
 * @method ExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    public function add(ExchangeRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExchangeRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ExchangeRate[] Returns an array of ExchangeRate objects
     */
    public function findExchangeRates($base, $quote, $time_start, $time_end): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin("e.assetPair", "ea")
            ->andWhere('ea.base = :base')
            ->andWhere('ea.quote = :quote')
            ->andWhere('e.time >= :time_start')
            ->andWhere('e.time <= :time_end')
            ->setParameter('base', $base)
            ->setParameter('quote', $quote)
            ->setParameter('time_start', $time_start)
            ->setParameter('time_end', $time_end)
            ->orderBy('e.time', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?ExchangeRate
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
