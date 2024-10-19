<?php

namespace Controller;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Controller\CartController;


class OrderController

{
    public function getRegistrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $userProducts= new UserProduct();
        $userProduct = $userProducts->getAllByUserId($user_id);
        $cart = new CartController();
        $totalPrice = $cart->getTotalPrise();

        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $errors = $this->validate();
        if (empty($errors))
        {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $order = new Order();
            $order->create($user_id, $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone'], $date);

            $userProduct = new UserProduct();
            $userProducts = $userProduct->getAllByUserId($user_id);
            $orderId = $order->getOrderId($user_id);

            foreach ($userProducts as $userProduct) {
                $orderProduct = new OrderProduct();
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];
                $orderProduct->createOrder($orderId['id'], $productId, $amount);
            }

//            $userProduct->deleteAllInCart($user_id);
//            header("location: /catalog");
        }

    }
    public function validate()
    {
        if (isset($_POST['first_name'])) {
            $first_name = $_POST['first_name'];
        }
        if (isset($_POST['last_name'])) {
            $last_name = $_POST['last_name'];
        }
        if (isset($_POST['address'])) {
            $address = $_POST['address'];
        }
        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
        }

        $errors = [];
        if (empty($first_name)) {
            $errors['first_name'] = 'Имя не должно быть пустым!';
        } elseif (strtoupper($first_name[0] !==$first_name[0])){
            $errors['first_name'] = ' должно начинать с большой буквы';
        }
        if (strlen($first_name) < 2){
            $errors['first_name'] = ' не должно быть меньше двух символов';
        }
        if (empty($last_name)) {
            $errors['last_name'] = ' не должно быть пустым!';
        } elseif (strtoupper($last_name[0] !==$last_name[0])){
            $errors['last_name'] = ' должно начинать с большой буквы';
        }
        if (empty($address)) {
            $errors['address'] = ' не должно быть пустым!';
        } elseif(strlen($address) < 2) {
            $errors['address'] = ' не должно быть меньше двух символов';
        }
        if (empty($phone)) {
            $errors['phone'] = ' не должно быть пустым!';
        }
        elseif(strlen($phone) < 2) {
            $errors['phone'] = ' не должно быть меньше двух символов';
        }
        return $errors;
    }

}