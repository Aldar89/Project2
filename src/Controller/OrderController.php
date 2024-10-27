<?php

namespace Controller;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Controller\CartController;
use Request\OrderRequest;


class OrderController

{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private CartController $cartModel;
    private OrderProduct $orderProductModel;

        public function getRegistrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $userProducts = UserProduct::getAllByUserId($user_id);

        $totalPrice = $this->cartModel->getTotalPrice();

        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder(OrderRequest $request)
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $errors = $request->validate();
        if (empty($errors))
        {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $firstName = $request->getFirstName();
            $lastName = $request->getLastName();
            $address = $request->getAddress();
            $phone = $request->getPhone();


            $this->orderModel->create($userId, $firstName, $lastName, $address, $phone, $date);


            $userProducts = UserProduct::getAllByUserId($userId);
            $orderFromDb = Order::getOrderId( $userId);
            $orderId = $orderFromDb->getId();


            foreach ($userProducts as $userProduct) {


                $product = UserProduct::getProduct();
                $amount = UserProduct::getAmount();
                OrderProduct::createOrder($orderId, $product, $amount);

            }

            $this->cartModel->deleteCart();
                header("location: /catalog");

        }

    }

}