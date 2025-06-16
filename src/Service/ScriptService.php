<?php

namespace App\Service;

class ScriptService
{

    public function getScript(?string $computerId = null): ?string
    {
        if (null === $computerId) {
            return null;
        }

        return null;

        // Example
        $blockingScript = $this->getBlockingScript(['xvideo.com', 'pornhub.com']);
        $unBlockingScript = $this->getUnBlockingScript(['microsoft.com', 'google.com']);
        return $this->makeShellScript([$blockingScript, $unBlockingScript]);

    }

    private function makeShellScript(array $scriptsToRun): string
    {
        $shellScript = "#!/bin/sh \n";
        foreach($scriptsToRun as $scriptToRun) {
            $shellScript .= $scriptToRun . "\n";
        }
        return $shellScript;
    }


    /**
     * Returns a Shell script that blocks domains in /etc/hosts
     *
     * @param array $domains - Example : $domains = ['facebook.com', 'instagram.com']
     * @return string
     */
    private function getBlockingScript(array $domains): string
    {
        $domainList = implode(' ', $domains);

        return <<<EOT
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
block_domains $domainList
EOT;
    }

    /**
     * Returns a Shell script that unblocks domains in /etc/hosts
     *
     * @param array $domains - Example : $domains = ['facebook.com', 'instagram.com']
     * @return string
     */
    private function getUnBlockingScript(array $domains): string
    {
        $domainList = implode(' ', $domains);

        return <<<EOT
unblock_domains() {
    domains="\$@"
    for domain in \$domains; do
        echo "Unblocking \$domain"
        sed -i.bak "/^127.0.0.1 \$domain\$/d" /etc/hosts
    done
}
unblock_domains $domainList
EOT;
    }
}
