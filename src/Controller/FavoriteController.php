<?php

namespace Controller;
use Model\FavoriteProduct;
use Model\UserProduct;
use Model\Product;

class FavoriteController
{
    private FavoriteProduct $favoriteProduct;
    public function __construct()
    {
        $this->favoriteProduct = new FavoriteProduct();
    }
    public function addFavorite()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }

        $result = $this->favoriteProduct->getFavoriteProduct($userId, $productId);
        if (!$result){
            $this->favoriteProduct->createFavoriteProduct($userId, $productId);
        }
        header("location:/catalog");


    }

    public function getFavorite()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }
        $favoriteProducts = $this->favoriteProduct->getFavoriteProductByUserId($userId);
//        $productIds = [];
//        foreach ($favoriteProducts as $favoriteProduct) {
//            $productIds[] = $favoriteProduct->getProductId();
//        }
//        $products =[];
//
//        foreach ($productIds as $productId) {
//            $product = new Product();
//            $id = $productId;
//            $products[] = $product->getProductById($id);
//        }
        require "./../View/favorite.php";
    }

    public function removeFavorite(){
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }
        $favoriteProduct = new FavoriteProduct();
        $favoriteProduct->deleteFavoriteProduct($userId, $productId);
        header("location:/catalog");

    }

}