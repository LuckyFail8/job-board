<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Exceptions\ExistingCompanyName;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function index(CompanyRepository $companyRepository): Response
    {
        $companies = $companyRepository->findAll();

        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
            'companies' => $companies,
        ]);
    }

    private function addCompany(string $companyName, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $existingCompany = $entityManager->getRepository(Company::class)->findByUpperName($companyName);

        if ($existingCompany) {
            throw new ExistingCompanyName();
        } else {
            $company = new Company;
            $company->setName($companyName);
            $entityManager->persist($company);
            $entityManager->flush();
            echo ("La compagny : $companyName a été ajouté avec succès !");
        }
    }
}
