<?php

namespace App\Controller;

use App\Entity\Vacation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VacationController extends AbstractController
{
    #[Route('/vacation', name: 'app_vacation')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vacations = $entityManager->getRepository(Vacation::class)->findAll();
        return $this->render('vacation/index.html.twig', [
            'vacations' => $vacations,
        ]);
    }
}
