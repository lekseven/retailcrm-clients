<?php


namespace App\Entity;


interface ActivityLoggable
{
    public function getExcludedProperties(): array;

    public function getParentEntity();
}
