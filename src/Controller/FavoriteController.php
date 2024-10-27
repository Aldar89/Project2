<?php

namespace Controller;
use Model\FavoriteProduct;
use Model\UserProduct;
use Model\Product;
use Request\ProductRequest;

class FavoriteController
{
    private FavoriteProduct $favoriteProduct;

    public function addFavorite()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }

        $result = FavoriteProduct::getFavoriteProduct($userId, $productId);
        if (!$result){
           FavoriteProduct::createFavoriteProduct($userId, $productId);
        }
        header("location:/catalog");


    }

    public function getFavorite(ProductRequest $request)
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $productId = $request->getProductId();
        $favoriteProducts =FavoriteProduct::getFavoriteProductByUserId($userId);
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

    public function removeFavorite(ProductRequest $request){
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $productId = $request->getProductId();

        FavoriteProduct::deleteFavoriteProduct($userId, $productId);
        header("location:/catalog");

    }

}