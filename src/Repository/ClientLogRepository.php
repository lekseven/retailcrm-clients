<?php

namespace App\Repository;

use App\Entity\ClientLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClientLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientLog[]    findAll()
 * @method ClientLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientLog::class);
    }

    // /**
    //  * @return ClientLog[] Returns an array of ClientLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientLog
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
