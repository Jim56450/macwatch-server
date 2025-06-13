<?php

namespace App\Entity;

use App\Repository\ActivityEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityEntityRepository::class)]
class ActivityEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $computerId = '';

    #[ORM\Column(length: 255)]
    private ?string $sessionId = '';

    #[ORM\Column(length: 255)]
    private ?string $appName = '';

    #[ORM\Column(length: 255)]
    private ?string $windowTitle = '';

    #[ORM\Column(length: 255)]
    private ?string $url = '';

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $startTime = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $endTime = null;

    #[ORM\Column]
    private ?bool $isBrowser = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function get($key) : string|int|null
    {
        return match ($key) {
            'id' => $this->getId(),
            'computerId' => $this->getComputerId(),
            'sessionId' => $this->getSessionId(),
            'appName' => $this->getAppName(),
            'windowTitle' => $this->getWindowTitle(),
            default => null,
        };
    }

    public function getComputerId(): ?string
    {
        return $this->computerId;
    }

    public function setComputerId(string $computerId = 'none'): static
    {
        $this->computerId = $computerId;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId = ''): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function setAppName(?string $appName = 'No App Name'): static
    {
        $this->appName = $appName;

        return $this;
    }

    public function getWindowTitle(): ?string
    {
        return $this->windowTitle;
    }

    public function setWindowTitle(?string $windowTitle = ''): static
    {
        $this->windowTitle = $windowTitle;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url = ''): static
    {
        if (null === $url) {
            $url = '';
        }
        $this->url = $url;

        return $this;
    }

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeImmutable $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeImmutable $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function isBrowser(): ?bool
    {
        return $this->isBrowser;
    }

    public function setIsBrowser(?bool $isBrowser = false): static
    {
        $this->isBrowser = $isBrowser;

        return $this;
    }
}
