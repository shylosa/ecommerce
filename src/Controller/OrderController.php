<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/add-to-cart/{id}", name="order_add_to_cart")
     */
    public function addToCart(Product $product, OrdersService $ordersService, Request $request)
    {
        $ordersService->addToCart($product);
        if ($request->isXmlHttpRequest()) {
            return $this->headerCart($ordersService);
        }
        $referer = $request->headers->get('Referer');
        return $this->redirect($referer);
    }
    /**
     * @Route("/cart", name="order_cart")
     */
    public function cart(OrdersService $ordersService)
    {
        return $this->render('order/cart.html.twig', [
            'order' => $ordersService->getOrderFromCart(),
        ]);
    }
    public function headerCart(OrdersService $ordersService)
    {
        return $this->render('order/headerCart.html.twig', [
            'order' => $ordersService->getOrderFromCart(),
        ]);
    }
    /**
     * @Route("/cart/update-count/{id}", name="order_update_count")
     */
    public function updateCount(OrderItem $orderItem, OrdersService $ordersService, Request $request)
    {
        $order = $ordersService->getOrderFromCart();

        if ($orderItem->getOrder() !== $order) {
            return $this->createAccessDeniedException('Invalid order item');
        }

        $count = $request->request->getInt('count');
        $ordersService->setCount($orderItem, $count);

        return $this->render('order/cartTable.html.twig', [
            'order' => $order,
        ]);
    }
}