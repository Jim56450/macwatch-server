<?php

namespace App\Service;


class DateTimeImmutableService
{
    private string $timeZone;
    public function __construct() {
        $this->timeZone = 'Europe/Paris';
    }

    /**
     * @throws \Exception
     */
    public function new(string $dateTime): \DateTimeImmutable
     {
         return new \DateTimeImmutable($dateTime, $this->timeZone);
     }
}
