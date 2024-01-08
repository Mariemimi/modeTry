<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EssayageVirtuelController extends AbstractController
{
    #[Route('/essayage/virtuel', name: 'app_essayage_virtuel')]
    public function index(): Response
    {
        return $this->render('essayage_virtuel/index.html.twig', [
            'controller_name' => 'EssayageVirtuelController',
        ]);
    }
}
