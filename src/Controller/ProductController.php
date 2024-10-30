<?php
namespace Controller;
use Model\Product;
use Service\AuthenticationSession;
use Service\CartService;
//require_once './../Model/Product.php';
//require_once './../Controller/CartController.php';
class ProductController
{
    private AuthenticationSession $authenticationSession;
    public function __construct(AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
    }

    public function getAll()
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $products = Product::getAll();
       
        $allAmount = CartService::getAllAmount($userId);
        require_once './../View/catalog2.php';
    }
}