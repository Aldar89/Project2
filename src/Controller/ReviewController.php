<?php

namespace Controller;

use Model\Order;
use Model\Review;
use Request\Request;
use Request\ReviewRequest;
use Service\Authentication\AuthServiceInterface;
use Service\GradeService;
use Service\OrderService;

class ReviewController
{
    private AuthServiceInterface $authService;
    private GradeService $gradeService;
    private OrderService $orderService;

   public function __construct(AuthServiceInterface $authService,GradeService $gradeService, OrderService $orderService)
    {
        $this->authService = $authService;
        $this->gradeService = $gradeService;
        $this->orderService = $orderService;
    }
    public function addReview(ReviewRequest $request )
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $productId = $request->getProductId();
        $comment = $request->getComment();
        $grade = $request->getGrade();


        Review::create($userId,$productId, $comment, $grade);

        header('Location: /catalog');
    }

    public function deleteReview()
    {

    }
}