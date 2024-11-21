<?php
namespace Aldar\Project2\Controller;
use Aldar\Project2\Model\Product;
use Aldar\Project2\Service\Authentication\AuthenticationSession;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\CartService;

//require_once './../Model/Product.php';
//require_once './../Controller/CartController.php';
class ProductController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;
    public function __construct(AuthServiceInterface $authService, CartService $cartService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
    }

    public function getAll()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $products = Product::getAll();

        $allAmount = $this->cartService->getAllAmount($userId);
        require_once './../View/catalog2.php';
    }
}