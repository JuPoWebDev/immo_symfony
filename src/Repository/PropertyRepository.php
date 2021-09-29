<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    
    public function findFilterProperties($criteria = [])
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.sell = false');
            if(array_key_exists("roomsMin", $criteria) && !empty($criteria['roomsMin'])) {
                $qb->andWhere($qb->expr()->gte('p.rooms',$criteria['roomsMin']));
            }
            if(array_key_exists("roomsMax", $criteria) && !empty($criteria['roomsMax'])) {
                $qb->andWhere($qb->expr()->lte('p.rooms',$criteria['roomsMax']));
            }
            if(array_key_exists("surfaceMin", $criteria) && !empty($criteria['surfaceMin'])) {
                $qb->andWhere($qb->expr()->gte('p.rooms',$criteria['surfaceMin']));
            }

            if(array_key_exists("surfaceMax", $criteria) && !empty($criteria['surfaceMax'])) {
                $qb->andWhere($qb->expr()->lte('p.rooms',$criteria['surfaceMax']));
            }

            if(array_key_exists("priceMin", $criteria) && !empty($criteria['priceMin'])) {
                $qb->andWhere($qb->expr()->gte('p.rooms',$criteria['priceMin']));
            }
            if(array_key_exists("priceMax", $criteria) && !empty($criteria['priceMax'])) {
                $qb->andWhere($qb->expr()->lte('p.rooms',$criteria['priceMax']));
            }

            return $qb->getQuery()->getResult();

        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBySearch( $roomsMin,  $roomsMax,  $surfaceMin,  $surfaceMax,  $priceMin,  $priceMax )
    {
        if($roomsMin == "") {
            $roomsMin = 1;
        }

        if($roomsMax == "") {
            $roomsMax = 10000;
        }

        if($surfaceMin == "") {
            $surfaceMin = 1;
        }

        if($surfaceMax == "") {
            $surfaceMax = 1000000;
        }

        if($priceMin == "") {
            $priceMin = 1;
        }

        if($priceMax == "") {
            $priceMax = 100000000000;
        }

        return $this->createQueryBuilder('property')
        ->andWhere('property.rooms > :roomsMin')
        ->andWhere('property.rooms < :roomsMax')
        ->andWhere('property.surface > :surfaceMin')
        ->andWhere('property.surface < :surfaceMax')
        ->andWhere('property.price > :priceMin')
        ->andWhere('property.price < :priceMax')
        ->setParameters(new ArrayCollection([
            new Parameter('roomsMin', $roomsMin),
            new Parameter('roomsMax', $roomsMax),
            new Parameter('surfaceMin', $surfaceMin),
            new Parameter('surfaceMax', $surfaceMax),
            new Parameter('priceMin', $priceMin),
            new Parameter('priceMax', $priceMax)
        ]))
        ->getQuery()
        ->getResult()
            ;
    }



}
