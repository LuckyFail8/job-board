<?php

namespace App\Controller;

use App\Entity\Department;
use App\Exceptions\ExistingDepartmentCode;
use App\Exceptions\ExistingDepartmentName;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    #[Route('/department', name: 'app_department')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $departments = $entityManager->getRepository(Department::class)->findAll();
        dump($departments);

        return $this->render('department/index.html.twig', [
            'controller_name' => 'DepartmentController',
            'departments'     => $departments
        ]);
    }

    #[Route('/loaddepartment', name: 'app_loaddepartment')]
    public function loadDepartmentInDatabase(KernelInterface $kernel, ManagerRegistry $doctrine): Response
    {
        $projectDir = $kernel->getProjectDir();
        $departmentJsonPath = $projectDir . '/data/departements-region.json';
        $departmentJson = file_get_contents($departmentJsonPath);
        $departmentsData = json_decode($departmentJson, true);

        foreach ($departmentsData as $departmentData) {
            $departmentName =  $departmentData['dep_name'];
            $departmentCode =  (int)$departmentData['num_dep'];
            $this->addDepartment($departmentName, $departmentCode, $doctrine);
        }

        return $this->render('department/loaddepartment.html.twig', [
            'controller_name' => 'LoadDepartmentController',
            'departmentName' => $departmentName,
            'departmentCode' => $departmentCode,
        ]);
    }

    public function addDepartment(string $departmentName, int $departmentCode, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $existingDepartmentName = $entityManager->getRepository(Department::class)->findOneBy(['name' => $departmentName]);
        $existingDepartmentCode = $entityManager->getRepository(Department::class)->findOneBy(['department_code' => $departmentCode]);

        if ($existingDepartmentName) {
            throw new ExistingDepartmentName();
        } elseif ($existingDepartmentCode) {
            throw new ExistingDepartmentCode();
        } else {
            $department = new Department;
            $department->setName($departmentName)
                ->setDepartmentCode($departmentCode);
            $entityManager->persist($department);
            $entityManager->flush();
            echo ("Le département : $departmentName ($departmentCode) a été ajouté avec succès !");
        }
    }
}
