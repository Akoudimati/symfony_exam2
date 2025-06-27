<?php

namespace App\Controller;

use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BooksController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $books = $entityManager->getRepository(books::class)->findAll();;
        return $this->render('books/index.html.twig', [
            'books' => $books ,
        ]);
    }
}
