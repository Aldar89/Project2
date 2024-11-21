<?php

namespace Aldar\Project2\Controller;
use Aldar\Project2\Model\FavoriteProduct;
use Aldar\Project2\Model\Product;
use Aldar\Project2\Request\ProductRequest;
use Aldar\Project2\Service\Authentication\AuthenticationSession;
use Core\Authentication\AuthServiceInterface;

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