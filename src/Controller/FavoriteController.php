<?php

namespace Controller;
use Model\FavoriteProduct;
use Model\Product;
use Request\ProductRequest;
use Service\Authentication\AuthenticationSession;
use Service\Authentication\AuthServiceInterface;

class FavoriteController
{

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function addFavorite(ProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

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

    public function getFavorite()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $favoriteProducts = FavoriteProduct::getFavoriteProductByUserId($userId);
        $productIds = [];
        foreach ($favoriteProducts as $favoriteProduct) {
            $productIds[] = $favoriteProduct->getId();
        }
        $products =[];

        foreach ($productIds as $productId) {
            $product = new Product();
            $id = $productId;
            $products[] = $product->getProductById($id);
        }
        require "./../View/favorite.php";
    }

    public function removeFavorite(ProductRequest $request){
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $productId = $request->getProductId();

        FavoriteProduct::deleteFavoriteProduct($userId, $productId);
        header("location:/catalog");

    }

}