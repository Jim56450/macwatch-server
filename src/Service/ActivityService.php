<?php

namespace App\Service;

use App\Dto\ActivityCollectionDto;
use App\Dto\ActivityDto;
use App\Entity\ActivityEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class ActivityService
{
    private bool $saveExclusionList;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private DateTimeImmutableService $dateTimeImmutableService,
        private array $exclusionList = []
    ) {
        $this->saveExclusionList = ($_ENV['SAVE_EXCLUSION_LIST'] ?? "false")==="true";
    }

    private function truncateString(?string $string = null,?int $length = 250,?string $ellipsis = '...'):?string
    {
        if (is_null($string)) {
            return '';
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
        $activity = null;
        foreach ($activityCollection as $activityDto) {
            $ids[] = $activityDto->id;
            if (!$this->saveExclusionList && ($this->exclusionList !== [] && in_array($activityDto->computer_id, $this->exclusionList, true))) {
                continue;
            }

            $activity = $activity ?? $this->entityManager->getRepository(ActivityEntity::class)->findLast($activityDto->computer_id, []);

            if ((null !== $activity)
                && ($activity->isBrowser() === $activityDto->is_browser)
                && ($this->truncateString($activity->getSessionId()) === $this->truncateString($activityDto->session_id))
                && ($this->truncateString($activity->getAppName()) === $this->truncateString($activityDto->app_name))
                && ($this->truncateString($activity->getWindowTitle()) === $this->truncateString($activityDto->window_title))
                && ($this->truncateString($activity->getUrl()) === $this->truncateString($activityDto->url))
            ) {
                $activity->setEndTime($this->dateTimeImmutableService->get($activityDto->end_time));
            } else {
                $activity = new ActivityEntity();
                $activity->setComputerId($activityDto->computer_id);
                $activity->setSessionId($this->truncateString($activityDto->session_id??'')); // truncate if too long
                $activity->setAppName($this->truncateString($activityDto->app_name));
                $activity->setWindowTitle($this->truncateString($activityDto->window_title)); // truncate if too long
                $activity->setUrl($this->truncateString($activityDto->url));
                $activity->setStartTime($this->dateTimeImmutableService->get($activityDto->start_time));
                $activity->setEndTime($this->dateTimeImmutableService->get($activityDto->end_time));
                $activity->setIsBrowser($activityDto->is_browser);
            }

            // Persist each entity
            $this->entityManager->persist($activity);
        }

        // Flush all changes to the database
        $this->entityManager->flush();
        return $ids;
    }
}
