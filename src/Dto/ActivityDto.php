<?php

namespace App\Dto;

use App\Validator\FlexibleDateTimeConstraint;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class ActivityDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $id,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $computer_id,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $session_id,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $app_name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $window_title,

        #[Assert\Type('string', 'null')]
        public ?string $url,

        #[Assert\NotBlank]
        //#[Assert\DateTime(format: 'c')]  // ISO 8601
        #[FlexibleDateTimeConstraint]
        public string $start_time,

        #[Assert\NotBlank]
        //#[Assert\DateTime(format: 'c')]  // ISO 8601
        #[FlexibleDateTimeConstraint]
        public string $end_time,

        #[Assert\NotNull]
        #[Assert\Type('bool')]
        public bool $is_browser,

        #[Assert\NotNull]
        #[Assert\Type('bool')]
        public bool $is_active,

        #[Assert\NotBlank]
        #[FlexibleDateTimeConstraint]
        public string $timestamp,
    ) {
    }
}
