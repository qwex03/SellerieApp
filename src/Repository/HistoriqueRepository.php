<?php

namespace App\Repository;

use App\Entity\Historique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @extends ServiceEntityRepository<Historique>
 */
class HistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historique::class);
    }

    //    /**
    //     * @return Historique[] Returns an array of Historique objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Historique
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

        public function countRetard(): int
        {
            return $this->createQueryBuilder('h')
                ->select('COUNT(h.id)') 
                ->where('h.date_retour < :currentDate')
                ->andWhere('h.retour IS NULL') 
                ->setParameter('currentDate', new \DateTime()) 
                ->getQuery()
                ->getSingleScalarResult(); 
        }

        public function Retard(): array
        {
            return $this->createQueryBuilder('h')
                ->where('h.date_retour < :currentDate')
                ->andWhere('h.retour IS NULL')
                ->setParameter('currentDate', new \DateTime())
                ->getQuery()
                ->getResult();
        }
}
