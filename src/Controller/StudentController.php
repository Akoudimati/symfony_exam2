<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $students = $entityManager->getRepository(Student::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/{id}', name: 'app_show_student')]
    public function showStudent(EntityManagerInterface $entityManager, int $id): Response
    {
        $student = $entityManager->getRepository(Student::class)->find($id);
        return $this->render('student/show-student.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/student-add', name: 'app_add_student')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash('success', 'De student is toegevoegd');

            return $this->redirectToRoute('app_student');
        }

        return $this->render('student/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/student-update/{id}', name: 'app_update_student')]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $student = $entityManager->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash('warning', 'De student is bijgewerkt');

            return $this->redirectToRoute('app_student', ['student' => $student->getId()]);
        }

        return $this->render('student/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/student-delete/{id}', name: 'app_delete_student')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response {

        $student = $entityManager->getRepository(Student::class)->find($id);
        $entityManager->remove($student);

        //We voeren de statements uit (het wordt nog gedelete)
        $entityManager->flush();

        //Uiteraard zetten we een flash-message
        $this->addFlash('danger', 'De student is uitgeschreven');

        return $this->redirectToRoute('app_student');
    }
}
