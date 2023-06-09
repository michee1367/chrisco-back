<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Province;
use App\Entity\Town;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Town>
 *
 * @method Town|null find($id, $lockMode = null, $lockVersion = null)
 * @method Town|null findOneBy(array $criteria, array $orderBy = null)
 * @method Town[]    findAll()
 * @method Town[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TownRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Town::class);
    }

    public function save(Town $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Town $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Town[] Returns an array of Town objects
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

//    public function findOneBySomeField($value): ?Town
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @return Town[] Returns an array of City objects
     */
    public function findByProvince(Province $province): array
    {
        
        return $this->createQueryBuilder('t')
            ->join('t.city', 'c')
            ->join('c.province', 'p')
            ->andWhere('p.id = :provinceId')
            ->setParameter('provinceId', $province->getId())
            ->orderBy('t.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Town[] Returns an array of City objects
     */
    public function findByCity(City $city): array
    {
        //dd($city);
        return $this->createQueryBuilder('t')
            ->join('t.city', 'c')
            ->andWhere('c.id = :cityId')
            ->setParameter('cityId', $city->getId())
            ->orderBy('t.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
