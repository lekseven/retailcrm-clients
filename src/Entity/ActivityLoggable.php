<?php


namespace App\Entity;


interface ActivityLoggable
{
    public function getDeniedProperties(): array;
}
