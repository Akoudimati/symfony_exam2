<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
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
            $product = $entityManager->getRepository(Product::class)->find($id);
            if ($product) {
                $cartWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->getPrice() * $quantity;
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
        // Require login
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

        // Check if product exists
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            $this->addFlash('error', 'Product not found');
            return $this->redirectToRoute('app_cart');
        }

        // Get cart from session
        $cart = $session->get('cart', []);

        // Add or increment product
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        // Save cart back to session
        $session->set('cart', $cart);

        // Return appropriate response based on request type
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => array_sum($cart)
            ]);
        }

        // Regular request - redirect to cart
        $this->addFlash('success', 'Item added to cart');
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
                'message' => 'Item removed from cart successfully'
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/update/{id}/{quantity}', name: 'cart_update_quantity')]
    public function updateQuantity($id, $quantity, Request $request, SessionInterface $session): JsonResponse
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = max(1, intval($quantity)); // Ensure quantity is at least 1
        }

        $session->set('cart', $cart);

        return new JsonResponse([
            'success' => true,
            'cartCount' => count($cart),
            'message' => 'Cart updated successfully'
        ]);
    }

    #[Route('/checkout', name: 'cart_checkout')]
    public function checkout(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);

        if (empty($cart)) {
            $this->addFlash('error', 'Your cart is empty');
            return $this->redirectToRoute('app_cart');
        }

        $purchase = new Purchase();
        $purchase->setUser($this->getUser());
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $entityManager->getRepository(Product::class)->find($productId);
            if ($product) {
                $purchaseItem = new PurchaseItem();
                $purchaseItem->setProduct($product);
                $purchaseItem->setQuantity($quantity);
                $purchaseItem->setPrice($product->getPrice());
                $purchase->addItem($purchaseItem);
                $total += $product->getPrice() * $quantity;
            }
        }

        $purchase->setTotalAmount((string)$total);

        $entityManager->persist($purchase);
        $entityManager->flush();

        // Clear the cart
        $session->remove('cart');

        $this->addFlash('success', 'Your order has been placed successfully!');
        return $this->redirectToRoute('app_cart');
    }
} 