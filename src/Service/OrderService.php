<?php

namespace  Aldar\Project2\Service;
use Core\Model;
use Aldar\Project2\DTO\CreateOrderDTO;
use Aldar\Project2\Model\Order;
use Aldar\Project2\Model\OrderProduct;
use Aldar\Project2\Model\UserProduct;
use Aldar\Project2\Model\Product;

class OrderService
{


   public function create (CreateOrderDTO $orderDTO, $userId)
    {
        Model::getPdo()->beginTransaction();

        try {
            Order::create($orderDTO->getUserId(),
                $orderDTO->getFirstName(),
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

            UserProduct::deleteAllInCart($orderDTO->getUserId());
        } catch (\PDOException $exception) {
            Model::getPdo()->rollBack();
            throw $exception;
        }
        Model::getPdo()->commit();

    }

    public function searchProductInOrderByUserId($userId, $productId)
    {
        $orders = Order::getAllOrders($userId);

        foreach ($orders as $order) {
            $orderId = $order->getId();
            $productFromOrder = OrderProduct::getOrderProduct($orderId, $productId);

           }
        return $productFromOrder;
    }

}