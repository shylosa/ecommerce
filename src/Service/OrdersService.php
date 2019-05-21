<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrdersService
{
    const CART_SESSION_KEY = 'cart';
    private $session;
    private $orderRepository;
    private $entityManager;
    public function __construct(
        SessionInterface $session,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->session = $session;
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }
    public function getOrderFromCart()
    {
        $order = null;
        $orderId = $this->session->get(self::CART_SESSION_KEY);
        if ($orderId) {
            $order = $this->orderRepository->find($orderId);
        }
        if (!$order) {
            $order = new Order();
        }
        return $order;
    }
    public function addToCart(Product $product, int $count = 1): Order
    {
        $order = $this->getOrderFromCart();
        $orderItem = null;
        foreach ($order->getOrderItems() as $item) {
            if ($item->getProduct() === $product) {
                $orderItem = $item;
            }
        }
        if (!$orderItem) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $order->addOrderItem($orderItem);
        }
        $orderItem->setCount($orderItem->getCount() + $count);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->session->set(self::CART_SESSION_KEY, $order->getId());
        return $order;
    }
    public function setCount(OrderItem $orderItem, int $count): Order
    {
        $orderItem->setCount($count);
        $this->entityManager->flush();
        return $orderItem->getOrder();
    }

    public function deleteItem (OrderItem $orderItem) : Order
    {
        $order = $orderItem->getOrder();
        $order->removeOrderItem($orderItem);
        $this->entityManager->remove($orderItem);
        $this->entityManager->flush();

        return $order;
    }
}