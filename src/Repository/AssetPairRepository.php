<?php

namespace App\Repository;

use App\Entity\AssetPair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssetPair>
 *
 * @method AssetPair|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetPair|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetPair[]    findAll()
 * @method AssetPair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetPairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssetPair::class);
    }

    public function add(AssetPair $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssetPair $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



}
