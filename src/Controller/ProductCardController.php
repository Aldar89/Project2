<?php

namespace Controller;

use Model\Order;
use Model\Product;
use Model\Review;
use Request\ProductRequest;
use Service\Authentication\AuthServiceInterface;
use Service\GradeService;
use Model\User;
use Service\OrderService;


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