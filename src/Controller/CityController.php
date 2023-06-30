<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Department;
use App\Exceptions\ExistingCityName;
use App\Repository\CityRepository;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    #[Route('/city', name: 'app_city')]
    public function index(CityRepository $cityRepository): Response
    {
        $cities = $cityRepository->findAll();
        return $this->render('city/index.html.twig', [
            'controller_name' => 'CityController',
            'cities' => $cities,
        ]);
    }

    #[Route('/loadcities', name: 'app_loadcities')]
    public function loadDepartmentInDatabase(KernelInterface $kernel, EntityManager $entityManager, DepartmentRepository $departmentRepository): Response
    {
        $projectDir = $kernel->getProjectDir();
        $citiesJsonPath = $projectDir . '/data/cities.json';
        $citiesJson = file_get_contents($citiesJsonPath);
        $citiesData = json_decode($citiesJson, true);

        foreach ($citiesData["cities"] as $citiyData) {
            $cityName =  $citiyData['label'];
            $cityPostalCode =  sprintf('%05d', (int)$citiyData['zip_code']);
            $departmentNumber = (int)$citiyData['department_number'];
            $department = $departmentRepository->findOneBy(['department_code' => $departmentNumber]);

            $this->addCity($cityName, $cityPostalCode, $department, $entityManager);
        }

        return $this->render('city/loadcities.html.twig', [
            'controller_name' => 'LoadCitiesController',
            'citiesData' => $citiesData,
            'cityName' => $cityName,
            'cityPostalCode' => $cityPostalCode,
        ]);
    }

    public function addCity(string $cityName, int $cityPostalCode, Department $department, EntityManager $entityManager): void
    {
        $cityRepository = $entityManager->getRepository(City::class);
        $idDepartment = $department->getId();
        $existingCityName = $cityRepository->findOneBy(['name' => $cityName]);

        if ($existingCityName) {
            throw new ExistingCityName();
        } else {
            $city = new City;
            $city->setName($cityName)
                ->setPostalCode($cityPostalCode)
                ->setDepartment($idDepartment);
            $entityManager->persist($city);
            $entityManager->flush();
            echo ("La ville : $cityName ($cityPostalCode) a été ajouté avec succès !");
        }
    }
}
