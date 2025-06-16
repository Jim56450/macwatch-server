<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ScriptController
{
    #[Route('/macwatch/script', name: 'get_script', methods: ['GET'])]
    public function getScript(Request $request): JsonResponse
    {
        // Example: allow script only if a valid token is sent
        $token = $request->headers->get('X-API-TOKEN');
        if ($token !== $_ENV['MACWATCH_SERVER_FETCH_SCRIPT_SECURE_TOKEN']) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        // Dummy logic: Send script every 5 minutes

        return new JsonResponse([
            'script' => 'echo "Hello from server B!" > ~/Desktop/hello.txt'
        ]);

        // Otherwise, no script to send
        return new JsonResponse(['script' => null]);
    }
}
