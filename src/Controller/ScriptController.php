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

        // List of domains to target
        $domains = ['facebook.com', 'instagram.com'];
        $domainList = implode(' ', $domains);

        // Shell script with both block and unblock functions

        $script = <<<EOT
#!/bin/sh

block_domains() {
    domains="\$@"
    for domain in \$domains; do
        if ! grep -q "^127.0.0.1 \$domain\$" /etc/hosts; then
            echo "Blocking \$domain"
            echo "127.0.0.1 \$domain" | tee -a /etc/hosts > /dev/null
        else
            echo "\$domain is already blocked"
        fi
    done
}

unblock_domains() {
    domains="\$@"
    for domain in \$domains; do
        echo "Unblocking \$domain"
        sed -i.bak "/^127.0.0.1 \$domain\$/d" /etc/hosts
    done
}

# Choose one of the following:
block_domains $domainList
#unblock_domains $domainList
EOT;

        return new JsonResponse([
            //'script' => 'echo "Hello from server B!" > ~/Desktop/hello.txt'
             'script' => $script
        ]);

        // Otherwise, no script to send
        return new JsonResponse(['script' => null]);
    }
}
