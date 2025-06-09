<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ActivityCollectionDto
{
    /**
     * @param ActivityDto[] $activities
     */
    public function __construct(
//        #[Assert\NotBlank]
//        #[Assert\Type('string')]
//        public string $computer_id,

        #[Assert\NotNull]
        #[Assert\Valid]
        #[Assert\Type('array')]
        public array $activities,
    ) {
    }
}
