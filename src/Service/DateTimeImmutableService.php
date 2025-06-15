<?php

namespace App\Service;


use DateTimeZone;

class DateTimeImmutableService
{
    private DateTimeZone $timeZone;
    public function __construct() {
        $this->timeZone = new DateTimeZone('Europe/Paris');
    }

    public function get(string $dateTime): \DateTimeImmutable
     {
         try {
             return new \DateTimeImmutable($dateTime, $this->timeZone);
         } catch (\Exception $e) {
             return new \DateTimeImmutable("now", $this->timeZone);
         }
     }
}
