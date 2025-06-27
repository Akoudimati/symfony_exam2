<?php

namespace App\Controller;

use App\Entity\SchoolGroup;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SchoolGroupController extends AbstractController
{
    #[Route('/', name: 'app_school_group')]
    public function index(): Response
    {
        return $this->render('school_group/index.html.twig');
    }

    #[Route('/school_group', name: 'app_school_group_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $schoolGroups = $entityManager->getRepository(SchoolGroup::class)->findAll();

        return $this->render('school_group/show.html.twig', [
            'school_groups' => $schoolGroups
        ]);
    }

    #[Route('/school_group/{id}', name: 'app_school_group_show_students')]
    public function showStudents(EntityManagerInterface $entityManager, int $id): Response
    {
        $schoolGroup = $entityManager->getRepository(SchoolGroup::class)->find($id);
        $students = $schoolGroup->getStudents();
        
        return $this->render('school_group/show-students.html.twig', [
            'students' => $students
        ]);
    }

}
