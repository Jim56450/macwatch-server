<?php

namespace App\Service;

use App\Dto\ActivityCollectionDto;
use App\Dto\ActivityDto;
use App\Entity\ActivityEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class ActivityService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    private function truncateString(string $string = null,int $length,?string $ellipsis = '...'):?string
    {
        if (is_null($string)) {
            return null;
        }
        if (strlen($string) <= $length) {
            return $string;
        }

        $truncatedString = substr($string, 0, $length);
        $lastSpace = strrpos($truncatedString, ' ');

        if ($lastSpace !== false) {
            $truncatedString = substr($truncatedString, 0, $lastSpace);
        }

        return $truncatedString . $ellipsis;
    }

    /**
     * @throws \DateMalformedStringException
     * @param ActivityDto[] $activityCollection
     */
    public function saveActivities(array $activityCollection): array
    {
        $ids = [];
        foreach ($activityCollection as $activityDto) {
            $ids[] = $activityDto->id;
            $activity = new ActivityEntity();
            $activity->setAppName($activityDto->app_name);
            $activity->setWindowTitle(substr($activityDto->window_title, 0, 255)); // truncate if too long

            $activity->setUrl($this->truncateString($activityDto->url, 250));
            $activity->setStartTime(new \DateTimeImmutable($activityDto->start_time));
            $activity->setEndTime(new \DateTimeImmutable($activityDto->end_time));
            $activity->setIsBrowser($activityDto->is_browser);

            // Persist each entity
            $this->entityManager->persist($activity);
        }

        // Flush all changes to the database
        $this->entityManager->flush();
        return $ids;
    }
}
