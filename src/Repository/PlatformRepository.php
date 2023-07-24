<?php

namespace App\Repository;

use App\Entity\Platform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use RuntimeException;

/**
 * @extends ServiceEntityRepository<Platform>
 *
 * @method Platform|null find($id, $lockMode = null, $lockVersion = null)
 * @method Platform|null findOneBy(array $criteria, array $orderBy = null)
 * @method Platform[]    findAll()
 * @method Platform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Platform::class);
    }

    public function save(Platform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Platform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *  This function check if the platform being entered does not already exist 
     * @param string $platformName 
     * @return null|Platform 
     */
    public function findByUpperName(string $platformName): ?Platform
    {
        $uppercasedPlatformName = strtoupper($platformName);

        return $this->createQueryBuilder('c')
            ->andWhere('UPPER(c.name) = :uppercasedPlatformName')
            ->setParameter('uppercasedPlatformName', $uppercasedPlatformName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Platform[] Returns an array of Platform objects
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

    //    public function findOneBySomeField($value): ?Platform
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
