<?php


namespace App\EventListener;


use App\Entity\ActivityLog;
use App\Entity\ChangeSetFilterInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $log->setEntity($entity->getId(), get_class($entity));

        $changeSet = $uow->getEntityChangeSet($entity);
        if ($entity instanceof ChangeSetFilterInterface) {
            $changeSet = $entity->filterChangeSet($changeSet);
        }
        $log->setChangeSet($changeSet);

        $em->persist($log);
        $uow->computeChangeSet($em->getClassMetadata(ActivityLog::class), $log);
    }
}
