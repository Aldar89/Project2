<?php
namespace Aldar\Project2\Controller;
use Aldar\Project2\Model\UserProduct;
use Aldar\Project2\Request\ProductRequest;
use Aldar\Project2\Service\Authentication\AuthenticationSession;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\CartService;

//require_once './../Model/UserProduct.php';

class  CartController
{

    private AuthServiceInterface $authService;

    private CartService $cartService;

    public function __construct( AuthServiceInterface $authService, CartService $cartService )
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
    }

    public function getAddProduct()
    {
        require_once './../View/get_add-product.php';
    }
    public function addProduct(ProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $productId = $request->getProductId();
        $amount = $request->getAmount();

        $this->cartService->addProductInaCart($userId, $productId, $amount);

        header('location: /catalog');

    }

    public function getAll()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();


        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = $this->cartService->getAllAmount($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        require_once './../View/cart.php';
    }



//    public  function getAllCount()
//    {
//        if(session_status() === PHP_SESSION_NONE) session_start();
//        $userId = $_SESSION['user_id'];
//        if (!isset($user_id)) {
//            header('Location: /login');
//        }
//
//        CartService::getAllAmount($userId);
//    }

//    public function getTotalPrice()
//    {
//        if(session_status() === PHP_SESSION_NONE) session_start();
//        $userId = $_SESSION['user_id'];
//        if (!isset($user_id)) {
//            header('Location: /login');
//        }
//
//       CartService::getTotalPrice($userId);
//    }



    public function removeProduct(ProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();
        $productId = $request->getProductId();


        UserProduct::removeProduct($userId, $productId);
        header('location: /cart');
    }



}