<?php

namespace App\Repository;

use App\Entity\ActivityLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActivityLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityLog[]    findAll()
 * @method ActivityLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityLog::class);
    }

    public function findByEntity($entity): array
    {
        $qb = $this->createQueryBuilder('log');

        $qb->orWhere($qb->expr()->andX(
            $qb->expr()->eq('log.entityId', ":entityId"),
            $qb->expr()->eq('log.entityType', ":entityType")
        ))
            ->setParameter("entityId", $entity->getId())
            ->setParameter("entityType", get_class($entity));

        $qb->orWhere($qb->expr()->andX(
            $qb->expr()->eq('log.parentId', ":parentId"),
            $qb->expr()->eq('log.parentType', ":parentType")
        ))
            ->setParameter("parentId", $entity->getId())
            ->setParameter("parentType", get_class($entity));

        return $qb->orderBy('log.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
