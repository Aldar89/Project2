<?php

require_once './../Model/Product.php';
class ProductController
{
    public function getAll()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        //$user_id = $_COOKIE['user_id'];
          if (!isset($user_id)) {
            header('Location: /login');
        }
       $productModel = new Product();
        $products = $productModel->getAll();
        require_once './../View/catalog2.php';
    }
}