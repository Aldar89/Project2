<?php

namespace Aldar\Project2\Controller;

use Aldar\Project2\Model\Order;
use Aldar\Project2\Model\Review;
use Aldar\Project2\Request\ReviewRequest;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\GradeService;
use Aldar\Project2\Service\OrderService;

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