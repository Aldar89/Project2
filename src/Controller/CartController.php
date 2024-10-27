<?php
namespace Controller;
use Model\User;
use Model\UserProduct;
use Request\ProductRequest;

//require_once './../Model/UserProduct.php';

class  CartController
{
    private UserProduct $userProduct;

    public function getAddProduct()
    {
        require_once './../View/get_add-product.php';
    }
    public function addProduct(ProductRequest $request)
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $productId = $request->getProductId();
        $amount = $request->getAmount();


        $result = UserProduct::getByUserIdAndByProductId($userId, $productId);
        if ($result) {
            $amount =$amount + $result['amount'];
          UserProduct::addProduct($userId, $productId, $amount);

        } else {
           UserProduct::create($userId, $productId, $amount);

        }
        header('location: /catalog');

    }

    public function getAll()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }


        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = self::getAllCount();
        $totalPrice = self::getTotalPrice();

        require_once './../View/cart.php';
    }



    public function getAllCount()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }


       $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
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
        $userId = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }

        $userProduct = UserProduct::getAllByUserIdWhitoutJoin($userId);
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
        $userId = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }

        UserProduct::deleteAllInCart($userId);
    }

    public function removeProduct(ProductRequest $request)
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        $productId = $request->getProductId();


        UserProduct::removeProduct($userId, $productId);
        header('location: /cart');
    }



}