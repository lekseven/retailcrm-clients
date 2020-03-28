<?php


namespace App\Entity;

/**
 * Trait FiltersChangeSet
 * @package App\Entity
 *
 * @property array $excludeProperties
 */
trait FiltersChangeSet
{
    public function filterChangeSet(array $changeSet): array
    {
        $output = [];
        foreach ($changeSet as $propertyName => $propertyChangeSet) {
            if (!in_array($propertyName, $this->excludeProperties)) {
                $output[$propertyName] = $propertyChangeSet;
            }
        }

        return $output;
    }
}
