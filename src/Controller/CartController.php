<?php
namespace Controller;
use Model\UserProduct;

//require_once './../Model/UserProduct.php';

class  CartController
{
    private UserProduct $userProduct;
    public function __construct()
    {
        $this->userProduct = new UserProduct();
    }
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

        $result = $this->userProduct->getByUserIdAndByProductId($user_id, $product_id);
        if ($result) {
            $amount =$amount + $result['amount'];
           $this->userProduct->addProduct($user_id, $product_id, $amount);

        } else {
           $this->userProduct->create($user_id, $product_id, $amount);

        }
        header('location: /catalog');

    }

    public function getAll()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }


        $userProducts = $this->userProduct->getAllByUserIdWhitoutJoin($user_id);
        $allAmount = $this->getAllCount();
        $totalPrice = $this->getTotalPrice();

        require_once './../View/cart.php';
    }



    public function getAllCount()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }


       $userProducts = $this->userProduct->getAllByUserIdWhitoutJoin($user_id);
        $allAmount = 0;

        foreach ($userProducts as $product) {
            $amount = $product->getAmount();
            $allAmount +=$amount;
        }
        return $allAmount;

    }

    public function getTotalPrice()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        $UserProducts = new UserProduct();
        $userProduct = $UserProducts->getAllByUserIdWhitoutJoin($user_id);
        $totalPrice = 0;
        foreach ($userProduct as $product) {
            $amount = $product->getAmount();
            $price  = $product->getProduct()->getPrice();
            $totalPrice +=$amount*$price;
        }
        return $totalPrice;

    }

    public function deleteCart()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        $UserProducts = new UserProduct();
        $UserProducts->deleteAllInCart($user_id);
    }

    public function removeProduct()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }
        $userProducts = new UserProduct();
        $userProducts->removeProduct($user_id, $productId);
        header('location: /cart');
    }



}