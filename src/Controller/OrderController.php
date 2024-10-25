<?php

namespace Controller;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Controller\CartController;


class OrderController

{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private CartController $cartModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->cartModel = new CartController();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
    }

    public function getRegistrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $userProducts = $this->userProductModel->getAllByUserId($user_id);

        $totalPrice = $this->cartModel->getTotalPrice();

        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $errors = $this->validate();
        if (empty($errors))
        {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');

            $this->orderModel->create($userId, $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone'], $date);


            $userProducts = $this->userProductModel->getAllByUserId($userId);
            $orderId = $this->orderModel->getId();

            foreach ($userProducts as $userProduct) {
                $orderProduct = new OrderProduct();
                $productId = $this->userProductModel->getProduct()->getId();
                $amount = $this->userProductModel->getAmount();
                $orderProduct->createOrder($orderId, $productId, $amount);

            }

            $this->cartModel->deleteCart();
                header("location: /catalog");

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