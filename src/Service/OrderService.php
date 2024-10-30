<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
class OrderService
{
    public function __construct(private Order $order, private UserProduct $userProduct)
    {

    }
   public function create (CreateOrderDTO $orderDTO)
    {
        $this->order->create($orderDTO->getUserId(),$orderDTO->getFirstName(),
            $orderDTO->getLastName(),
            $orderDTO->getAddress(),
            $orderDTO->getPhone(),
            $orderDTO->getDate());
        $userProducts = UserProduct::getAllByUserId($orderDTO->getUserId());
        $orderFromDb = Order::getOrderId( $orderDTO->getUserId());
        $orderId = $orderFromDb->getId();


        foreach ($userProducts as $userProduct) {


            $product = $userProduct->getProduct();
            $amount = $userProduct->getAmount();
            OrderProduct::createOrder($orderId, $product, $amount);

        }
    }

}