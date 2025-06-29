<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Form\CheckoutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function index(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $book = $entityManager->getRepository(Books::class)->find($id);
            if ($book) {
                $cartWithData[] = [
                    'book' => $book,
                    'quantity' => $quantity
                ];
                $total += $book->getPrice() * $quantity;//+dady
            }
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/add/{id}', name: 'cart_add')]
    public function add($id, Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'loginRequired' => true,
                    'loginUrl' => $this->generateUrl('app_login')
                ], 401);
            }
            return $this->redirectToRoute('app_login');
        }

        $book = $entityManager->getRepository(Books::class)->find($id);
        if (!$book) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }
            return $this->redirectToRoute('app_cart');
        }

        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'success' => true,
                'message' => 'Book added to cart',
                'cartCount' => array_sum($cart)
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove($id, Request $request, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'success' => true,
                'cartCount' => count($cart),
                'message' => 'Book removed from cart'
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/update/{id}/{quantity}', name: 'cart_update_quantity')]
    public function updateQuantity($id, $quantity, Request $request, SessionInterface $session): JsonResponse
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = max(1, intval($quantity));
        }

        $session->set('cart', $cart);

        return new JsonResponse([
            'success' => true,
            'cartCount' => count($cart),
            'message' => 'Cart updated'
        ]);
    }

    #[Route('/checkout', name: 'cart_checkout')]
    public function checkout(Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);

        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        $purchase = new Purchase();
        $purchase->setUser($this->getUser());
        
        $total = 0;
        $cartWithData = [];

        foreach ($cart as $bookId => $quantity) {
            $book = $entityManager->getRepository(Books::class)->find($bookId);
            if ($book) {
                $cartWithData[] = [
                    'book' => $book,
                    'quantity' => $quantity
                ];
                $total += $book->getPrice() * $quantity;
            }
        }

        $form = $this->createForm(CheckoutType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($cart as $bookId => $quantity) {
                $book = $entityManager->getRepository(Books::class)->find($bookId);
                if ($book) {
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem->setBooks($book);
                    $purchaseItem->setQuantity($quantity);
                    $purchaseItem->setPrice($book->getPrice());
                    $purchase->addItem($purchaseItem);
                }
            }

            $purchase->setTotalAmount((string)$total);

            $entityManager->persist($purchase);
            $entityManager->flush();

            $session->remove('cart');

            return $this->render('cart/success.html.twig', [
                'purchase' => $purchase
            ]);
        }

        return $this->render('cart/checkout.html.twig', [
            'form' => $form->createView(),
            'items' => $cartWithData,
            'total' => $total
        ]);
    }
} 