<?php

namespace Controller;
use Model\FavoriteProduct;
use Model\UserProduct;
use Model\Product;
use Request\ProductRequest;
use Request\Request;
use Service\AuthenticationSession;

class FavoriteController
{
    private FavoriteProduct $favoriteProduct;
    private AuthenticationSession $authenticationSession;

    public function __construct(AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
    }

    public function addFavorite(ProductRequest $request)
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        }
        $productId = $request->getProductId();

        $result = FavoriteProduct::getFavoriteProduct($userId, $productId);
        if (!$result){
           FavoriteProduct::createFavoriteProduct($userId, $productId);
        }
        header("location:/catalog");


    }

    public function getFavorite(ProductRequest $request)
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

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
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $productId = $request->getProductId();

        FavoriteProduct::deleteFavoriteProduct($userId, $productId);
        header("location:/catalog");

    }

}