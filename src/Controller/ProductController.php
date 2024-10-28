<?php
namespace Controller;
use Model\Product;
//require_once './../Model/Product.php';
//require_once './../Controller/CartController.php';
class ProductController
{

    public function getAll()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $products = Product::getAll();
        $cart = new CartController();
        $allAmount = $cart->getAllCount();
        require_once './../View/catalog2.php';
    }
}