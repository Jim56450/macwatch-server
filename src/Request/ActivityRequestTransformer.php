<?php

namespace App\Request;

use App\Dto\ActivityCollectionDto;
use App\Dto\ActivityDto;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class ActivityRequestTransformer
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws \JsonException
     * @returns ActivityDto[]
     */
    public function transform(Request $request): array
    {
        $data = $request->getContent();
        $this->logger->warning('Received activity data', ['data' => $data]);

        /** @var ActivityCollectionDto $dto */
        try {
            //$dto = $this->serializer->deserialize($data, ActivityCollectionDto::class, 'json');
            $dto = $this->serializer->deserialize($data, ActivityDto::class . '[]', 'json');
            //$dto = $this->serializer->deserialize($data, array::class, 'json');

        }catch (\Exception $e) {
            $this->logger->error('Deserialization failed for activity data', [$e]);
            throw new BadRequestHttpException('Invalid JSON data');
        }

        $this->logger->warning('Received activity data');

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            // Log the original request data
            $this->logger->error('Validation failed for activity data', [
                'request_data' => json_decode($data, true, 512, JSON_THROW_ON_ERROR),
                'violations' => array_map(
                    static function ($violation) {
                        return [
                            'property' => $violation->getPropertyPath(),
                            'value' => $violation->getInvalidValue(),
                            'message' => $violation->getMessage(),
                        ];
                    },
                    iterator_to_array($violations)
                ),
            ]);

            throw new BadRequestHttpException((string) $violations);
        }

        return $dto;
    }
}
