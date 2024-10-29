<?php

namespace Service;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
class OrderService
{
   public static function addProductInOrder ($userId)
    {
        $userProducts = UserProduct::getAllByUserId($userId);
        $orderFromDb = Order::getOrderId( $userId);
        $orderId = $orderFromDb->getId();


        foreach ($userProducts as $userProduct) {


            $product = $userProduct->getProduct();
            $amount = $userProduct->getAmount();
            OrderProduct::createOrder($orderId, $product, $amount);

        }
    }
}