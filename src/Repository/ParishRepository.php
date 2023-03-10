<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Parish;
use App\Entity\Presbytery;
use App\Entity\Province;
use App\Entity\Territory;
use App\Entity\Town;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parish>
 *
 * @method Parish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parish[]    findAll()
 * @method Parish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parish::class);
    }

    public function save(Parish $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Parish $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Parish[] Returns an array of Parish objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Parish
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @return Parish[] Returns an array of City objects
     */
    public function findByProvince(Province $province): array
    {
        //dd("ok");
        $qb = $this->createQueryBuilder('pa')
            ->setParameter('provinceId', $province->getId())
            ->orderBy('pa.id', 'DESC');
            
            $sub1 = $this->_em->createQueryBuilder();
            $sub1->from(Parish::class,"pa1")
            ->join('pa1.territory', 'ter')
            ->join('ter.province', 'prov')
            //->join('r.department', 'dr')
            //->andWhere('r.id = r1.id AND c.slug = :slug')
            ->where('pa.id = pa1.id AND prov.id = :provinceId')
            ->select( 'pa1')
            ;

            $sub2 = $this->_em->createQueryBuilder();
            $sub2->from(Parish::class,"pa2")
            ->join('pa2.town', 'tow')
            ->join('tow.city', 'c')
            ->join('c.province', 'prov1')
            ->where('pa.id = pa2.id AND prov1.id = :provinceId')
            ->select( 'pa2');

            $qb->orWhere($qb->expr()->exists($sub1->getDQL()));
            $qb->orWhere($qb->expr()->exists($sub2->getDQL()));

            return $qb->getQuery()
            ->getResult();
    }
    /**
     * @return Parish[] Returns an array of City objects
     */
    public function findByCity(City $city): array
    {
        
        return $this->createQueryBuilder('pa')
            ->join('pa.town', 'tow')
            ->join('tow.city', 'c')
            ->andWhere('c.id = :cityId')
            ->setParameter('cityId', $city->getId())
            ->orderBy('pa.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Parish[] Returns an array of City objects
     */
    public function findByTown(Town $town): array
    {
        return $this->createQueryBuilder('pa')
            ->join('pa.town', 'tow')
            ->andWhere('tow.id = :towId')
            ->setParameter('towId', $town->getId())
            ->orderBy('pa.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Parish[] Returns an array of City objects
     */
    public function findByTerritory(Territory $territory): array
    {        
        return $this->createQueryBuilder('pa')
            ->join('pa.territory', 't')
            ->andWhere('t.id = :territoryId')
            ->setParameter('territoryId', $territory->getId())
            ->orderBy('pa.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Parish[] Returns an array of City objects
     */
    public function findByPresbytery(Presbytery $presbytery): array
    {
        
        return $this->createQueryBuilder('pa')
            ->join('pa.presbytery', 'pres')
            ->andWhere('pres.id = :presId')
            ->setParameter('presId', $presbytery->getId())
            ->orderBy('pa.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

}
