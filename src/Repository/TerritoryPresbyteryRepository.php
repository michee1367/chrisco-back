<?php

namespace App\Repository;

use App\Entity\TerritoryPresbytery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerritoryPresbytery>
 *
 * @method TerritoryPresbytery|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerritoryPresbytery|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerritoryPresbytery[]    findAll()
 * @method TerritoryPresbytery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerritoryPresbyteryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerritoryPresbytery::class);
    }

    public function save(TerritoryPresbytery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TerritoryPresbytery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TerritoryPresbytery[] Returns an array of TerritoryPresbytery objects
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

//    public function findOneBySomeField($value): ?TerritoryPresbytery
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
