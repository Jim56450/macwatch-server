<?php

namespace App\Controller;

use App\Request\ActivityRequestTransformer;
use App\Service\ActivityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

final class ActivityController extends AbstractController
{
    public function __construct(
        private readonly ActivityRequestTransformer $requestTransformer,
        private readonly ActivityService $activityService
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws \DateMalformedStringException
     * @throws \JsonException
     */
    #[Route('/macwatch/sync', name: 'app_activity', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $activityCollection = $this->requestTransformer->transform($request);

        $syncedIds = $this->activityService->saveActivities($activityCollection);

        return new JsonResponse([
            'status' => 'success',
            'synced_ids' => $syncedIds
        ]);
    }


    #[Route('/macwatch/ping', name: 'app_ping', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('pong');
    }
}
