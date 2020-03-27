<?php


namespace App\EventListener;


use App\Entity\ClientLog;
use Doctrine\ORM\Event\OnFlushEventArgs;

class EntityLogListener
{
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $clientLog = new ClientLog();
            $clientLog->setAction('insert');
            $clientLog->setChanges($uow->getEntityChangeSet($entity));
            $clientLog->setClient($entity->getId());

            $em->persist($clientLog);
            $metadata = $em->getClassMetadata(ClientLog::class);
            $uow->computeChangeSet($metadata, $clientLog);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $clientLog = new ClientLog();
            $clientLog->setAction('update');
            $clientLog->setChanges($uow->getEntityChangeSet($entity));
            $clientLog->setClient($entity->getId());

            $em->persist($clientLog);
            $metadata = $em->getClassMetadata(ClientLog::class);
            $uow->computeChangeSet($metadata, $clientLog);
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {

        }

        foreach ($uow->getScheduledCollectionDeletions() as $col) {

        }

        foreach ($uow->getScheduledCollectionUpdates() as $col) {

        }
    }
}