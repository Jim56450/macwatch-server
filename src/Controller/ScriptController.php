<?php

namespace App\Controller;

use App\Service\ScriptService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class ScriptController
{
    public function __construct(private readonly ScriptService $scriptService) {}

    #[Route('/macwatch/script/{computerId}', name: 'get_script', defaults: ['computerId' => null], methods: ['GET'])]
    public function getScript(Request $request, ?string $computerId): JsonResponse
    {
        // Example: allow script only if a valid token is sent
        $token = $request->headers->get('X-API-TOKEN');
        if ($token !== $_ENV['MACWATCH_SERVER_FETCH_SCRIPT_SECURE_TOKEN']) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        // List of domains to target
        $domains = ['facebook.com', 'instagram.com'];
        $domainList = implode(' ', $domains);

        // Shell script with both block and unblock functions

        $script = $this->scriptService->getScript($computerId);

        return new JsonResponse([
             'script' => $script
        ]);

        // Otherwise, no script to send
        return new JsonResponse(['script' => null]);
    }
}
