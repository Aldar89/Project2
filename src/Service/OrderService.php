<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Model\Model;
class OrderService
{

   public function create (CreateOrderDTO $orderDTO, $userId)
    {
        Model::getPdo()->beginTransaction();
        Order::create($orderDTO->getUserId(),$orderDTO->getFirstName(),
            $orderDTO->getLastName(),
            $orderDTO->getAddress(),
            $orderDTO->getPhone(),
            $orderDTO->getDate());
        $userProducts = UserProduct::getAllByUserId($orderDTO->getUserId());
        $orderFromDb = Order::getOrderId( $orderDTO->getUserId());
        $orderId = $orderFromDb->getId();

        try {
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

}