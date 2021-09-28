<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

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

    public function findBySearch(int $roomsMin, int $roomsMax, int $surfaceMin, int $surfaceMax, int $priceMin, int $priceMax )
    {
        $queryBuilder = $this->createQueryBuilder('property')
        ->where('property.rooms >= :roomsMin')
        ->andWhere('property.rooms <= :roomsMax')
        ->andWhere('property.surface >= :surfaceMin')
        ->andWhere('property.surface <= :surfaceMax')
        ->andWhere('property.price >= :priceMin')
        ->andWhere('property.price <= :priceMax')
        ->setParameters(new ArrayCollection([
            new Parameter('roomsMin', $roomsMin),
            new Parameter('roomsMax', $roomsMax),
            new Parameter('surfaceMin', $surfaceMin),
            new Parameter('surfaceMax', $surfaceMax),
            new Parameter('priceMin', $priceMin),
            new Parameter('priceMax', $priceMax)
        ]))
        ;
    }



}
