<?php

namespace App\Repository;

use App\Entity\TownPresbytery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TownPresbytery>
 *
 * @method TownPresbytery|null find($id, $lockMode = null, $lockVersion = null)
 * @method TownPresbytery|null findOneBy(array $criteria, array $orderBy = null)
 * @method TownPresbytery[]    findAll()
 * @method TownPresbytery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TownPresbyteryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TownPresbytery::class);
    }

    public function save(TownPresbytery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TownPresbytery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TownPresbytery[] Returns an array of TownPresbytery objects
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

//    public function findOneBySomeField($value): ?TownPresbytery
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
