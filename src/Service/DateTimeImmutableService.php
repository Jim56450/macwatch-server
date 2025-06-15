<?php

namespace App\Service;


use DateTimeZone;

class DateTimeImmutableService
{
    private DateTimeZone $timeZone;
    public function __construct() {
        $this->timeZone = new DateTimeZone('Europe/Paris');
    }

    /**
     * @throws \Exception
     */
    public function new(string $dateTime): \DateTimeImmutable
     {
         return new \DateTimeImmutable($dateTime, $this->timeZone);
     }
}
