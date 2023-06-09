<?php

namespace App\Repository;

use App\Entity\Province;
use App\Entity\Territory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Territory>
 *
 * @method Territory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Territory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Territory[]    findAll()
 * @method Territory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerritoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Territory::class);
    }

    public function save(Territory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Territory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Territory[] Returns an array of Territory objects
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

//    public function findOneBySomeField($value): ?Territory
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @return Territory[] Returns an array of City objects
     */
    public function findByProvince(Province $province): array
    {
        return $this->createQueryBuilder('t')
            ->join('t.province', 'p')
            ->andWhere('p.id = :provinceId')
            ->setParameter('provinceId', $province->getId())
            ->orderBy('t.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
