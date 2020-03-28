<?php


namespace App\Entity;


interface ChangeSetFilterInterface
{
    public function filterChangeSet(array $changeSet): array;
}
