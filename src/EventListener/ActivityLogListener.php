<?php


namespace App\EventListener;


use App\Entity\ActivityLog;
use App\Entity\ActivityLoggable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;

class ActivityLogListener
{
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->logActivity($em, ActivityLog::ACTION_INSERT, $entity);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->logActivity($em, ActivityLog::ACTION_UPDATE, $entity);
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $this->logActivity($em, ActivityLog::ACTION_DELETE, $entity);
        }

        foreach ($uow->getScheduledCollectionDeletions() as $col) {
            /** @var Collection $col */
            $col->forAll(function ($entity) use ($em) {
                $this->logActivity($em, ActivityLog::ACTION_DELETE, $entity);
            });
        }

        foreach ($uow->getScheduledCollectionUpdates() as $col) {

        }
    }

    private function logActivity(EntityManager $em, string $action, $entity)
    {
        $uow = $em->getUnitOfWork();

        $activityLog = new ActivityLog();
        $activityLog->setAction($action);
        $activityLog->setEntity($entity->getId(), get_class($entity));

        if ($action === ActivityLog::ACTION_UPDATE) {
            $changeSet = $uow->getEntityChangeSet($entity);
        } else {
            $changeSet = $uow->getOriginalEntityData($entity);
        }

        if ($entity instanceof ActivityLoggable) {
            $activityLog->setChangeSet($changeSet, $entity->getExcludedProperties());
            $activityLog->setParentEntity($entity->getParentEntity());
        } else {
            $activityLog->setChangeSet($changeSet);
        }

        $em->persist($activityLog);
        $uow->computeChangeSet($em->getClassMetadata(ActivityLog::class), $activityLog);
    }
}
