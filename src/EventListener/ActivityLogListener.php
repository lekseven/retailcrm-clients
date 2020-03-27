<?php


namespace App\EventListener;


use App\Entity\ActivityLog;
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

        $log = new ActivityLog();
        $log->setAction($action);

        if ($action == ActivityLog::ACTION_DELETE) {
            $log->setChangeSet((array)$entity);
        } else {
            $log->setChangeSet($uow->getEntityChangeSet($entity));
        }

        $log->setEntity($entity->getId(), get_class($entity));

        $em->persist($log);
        $uow->computeChangeSet($em->getClassMetadata(ActivityLog::class), $log);
    }
}