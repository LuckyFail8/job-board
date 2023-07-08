<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologieController extends AbstractController
{
    #[Route('/technologie', name: 'app_technologie')]
    public function index(): Response
    {
        return $this->render('technologie/index.html.twig', [
            'controller_name' => 'TechnologieController',
        ]);
    }
}
