<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DownloadController extends AbstractController
{
    #[Route('/download', name: 'app_download')]
    public function index(): Response
    {
        $downloads = [
            [
                'name' => 'MacWatch',
                'url' => '/MacWatch.pkg'
            ],
            [
                'name' => 'TGPro',
                'url' => '/TGPro.dmg'
            ]
        ];

        return $this->render('download/index.html.twig', [
            'controller_name' => 'DownloadController',
            'downloads' => $downloads
        ]);
    }
}
