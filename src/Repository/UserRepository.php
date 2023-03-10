<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Parish;
use App\Entity\Presbytery;
use App\Entity\Province;
use App\Entity\Territory;
use App\Entity\Town;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    /**
     * @return User[] Returns an array of City objects
     */
    public function findByProvince(Province $province): array
    {
        //dd("ok");
        try {
            $qb = $this->createQueryBuilder('u')
                ->setParameter('provinceId', $province->getId())
                ->orderBy('u.id', 'DESC');
                
                $sub1 = $this->_em->createQueryBuilder();
                $sub1->from(User::class,"u1")
                ->join('u1.parish', 'pa1')
                ->join('pa1.territory', 'ter')
                ->join('ter.province', 'prov')
                //->join('r.department', 'dr')
                //->andWhere('r.id = r1.id AND c.slug = :slug')
                ->where('u.id = u1.id AND prov.id = :provinceId')
                ->select( 'u1.id')
                ;
    
                $sub2 = $this->_em->createQueryBuilder();
                $sub2->from(User::class,"u2")
                ->join('u2.parish', 'pa2')
                ->join('pa2.town', 'tow')
                ->join('tow.city', 'c')
                ->join('c.province', 'prov1')
                ->where('u.id = u2.id AND prov1.id = :provinceId')
                ->select( 'u2.id');
    
                $qb->orWhere($qb->expr()->exists($sub1->getDQL()));
                $qb->orWhere($qb->expr()->exists($sub2->getDQL()));
                //dd($qb->getQuery()->getSQL());
                return $qb->getQuery()
                ->getResult();
            
        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
        }
    }
    /**
     * @return User[] Returns an array of City objects
     */
    public function findByCity(City $city): array
    {
        
        return $this->createQueryBuilder('u')
            ->join('u.parish', 'pa')
            ->join('pa.town', 'tow')
            ->join('tow.city', 'c')
            ->andWhere('c.id = :cityId')
            ->setParameter('cityId', $city->getId())
            ->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return User[] Returns an array of City objects
     */
    public function findByTown(Town $town): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.parish', 'pa')
            ->join('pa.town', 'tow')
            ->andWhere('tow.id = :towId')
            ->setParameter('towId', $town->getId())
            ->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[] Returns an array of City objects
     */
    public function findByTerritory(Territory $territory): array
    {        
        return $this->createQueryBuilder('u')
            ->join('u.parish', 'pa')
            ->join('pa.territory', 't')
            ->andWhere('t.id = :territoryId')
            ->setParameter('territoryId', $territory->getId())
            ->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[] Returns an array of City objects  Parish
     */
    public function findByPresbytery(Presbytery $presbytery): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.parish', 'pa')
            ->join('pa.presbytery', 'pres')
            ->andWhere('pres.id = :presId')
            ->setParameter('presId', $presbytery->getId())
            ->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[] Returns an array of City objects  Parish
     */
    public function findByParish(Parish $parish): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.parish', 'pa')
            ->andWhere('pa.id = :parishId')
            ->setParameter('parishId', $parish->getId())
            ->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

}
