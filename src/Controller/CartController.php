<?php
namespace Controller;
use Model\UserProduct;

//require_once './../Model/UserProduct.php';

class  CartController
{
    public function getAddProduct()
    {
        require_once './../View/get_add-product.php';
    }
    public function addProduct()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }
        $userProduct = new UserProduct();
        $result = $userProduct->getByUserIdAndByProductId($user_id, $product_id);
        if ($result) {
            $amount =$amount + $result['amount'];
           $userProduct->addProduct($user_id, $product_id, $amount);
        } else {
           $userProduct->create($user_id, $product_id, $amount);
        }

    }

    public function getAll()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $UserProductModel = new UserProduct();
        $userProduct = $UserProductModel->getAllByUserId($user_id);
        $allAmount = $this->getAllCount();
        $totalPrice = $this->getTotalPrise();

        require_once './../View/cart.php';
    }



    public function getAllCount()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }

        $UserProducts = new UserProduct();
        $userProduct = $UserProducts->getAllByUserId($user_id);
        $allAmount = 0;

        foreach ($userProduct as $product) {
            $amount = $product['amount'];
            $allAmount +=$amount;
        }
        return $allAmount;

    }

    public function getTotalPrise()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        $UserProducts = new UserProduct();
        $userProduct = $UserProducts->getAllByUserId($user_id);
        $totalPrice = 0;
        foreach ($userProduct as $product) {
            $amount = $product['amount'];
            $price = $product['price'];
            $totalPrice +=$amount*$price;
        }
        return $totalPrice;

    }



}