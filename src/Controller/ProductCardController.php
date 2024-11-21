<?php

namespace Aldar\Project2\Controller;

use Aldar\Project2\Model\Order;
use Aldar\Project2\Model\Product;
use Aldar\Project2\Model\Review;
use Aldar\Project2\Request\ProductRequest;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\GradeService;
use Aldar\Project2\Model\User;
use Aldar\Project2\Service\OrderService;


class ProductCardController
{
    private AuthServiceInterface $authService;
    private GradeService $gradeService;
    private OrderService $orderService;

    public function __construct(AuthServiceInterface $authService, GradeService $gradeService, OrderService $orderService)
    {
        $this->authService = $authService;
        $this->gradeService = $gradeService;
        $this->orderService = $orderService;
    }

    public function getProductCard(ProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $productId = $request->getProductId();
        $product = Product::getProductById($productId);
        $reviews = Review::getProductReviews($productId);
        $avarage = $this->gradeService->getAvarageRate($reviews);


        $productFromOrder = $this->orderService->searchProductInOrderByUserId($userId, $productId);




        require_once './../View/product-card.php';
    }
}