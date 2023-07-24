<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Exceptions\ExistingPlatformName;
use App\Repository\PlatformRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlatformController extends AbstractController
{
    #[Route('/platform', name: 'app_platform')]
    public function index(PlatformRepository $platformRepository): Response
    {
        $platforms = $platformRepository->findAll();

        return $this->render('platform/index.html.twig', [
            'controller_name' => 'PlatformController',
            'platforms' => $platforms,
        ]);
    }
    #[Route('/loadplatform', name: 'app_loadplatform')]

    public function loadCompanies(ManagerRegistry $doctrine): Response
    {
        $companies = [
            "Indeed",
            "LinkedIn",
            "Monster",
            "Pôle emploi ",
            "WeloveDevs",
            "HelloWork",
            "Welcome to the Jungle",
            "Glassdoor",
        ];
        foreach ($companies as $platform) {
            $platformName = $platform;
            $this->addPlatform($platformName, $doctrine);
        }

        return $this->render('platform/loadPlatform.html.twig', [
            'controller_name' => 'LoadPlatformController',
            'platformName' => $platformName,
        ]);
    }

    private function addPlatform(string $platformName, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $existingPlatform = $entityManager->getRepository(Platform::class)->findByUpperName($platformName);

        if ($existingPlatform) {
            throw new ExistingPlatformName();
        } else {
            $platform = new Platform;
            $platform->setName($platformName);
            $entityManager->persist($platform);
            $entityManager->flush();
            echo ("La compagny : $platformName a été ajouté avec succès !");
        }
    }
}
