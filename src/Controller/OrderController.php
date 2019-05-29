<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
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
    /**
     * @Route("/cart/delete-item/{id}", name="order_delete_item")
     */
    public function deleteItem(OrderItem $orderItem, OrdersService $ordersService, Request $request)
    {
        $order = $ordersService->getOrderFromCart();
        if ($orderItem->getOrder() !== $order) {
            return $this->createAccessDeniedException('Invalid order item');
        }
        $ordersService->deleteItem($orderItem);
        if ($request->isXmlHttpRequest()) {
            return $this->render('order/cartTable.html.twig', [
                'order' => $order,
            ]);
        }
        return $this->redirectToRoute('order_cart');
    }
    /**
     * @Route("/order/make", name="order_make_order")
     */
    public function makeOrder(OrdersService $ordersService, Request $request)
    {
        $order = $ordersService->getOrderFromCart();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ordersService->makeOrder($order);
            return $this->redirectToRoute('order_thanks');
        }
        return $this->render('order/makeOrder.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/order/thanks", name="order_thanks")
     */
    public function thanks()
    {
        return $this->render('order/thanks.html.twig');
    }
}