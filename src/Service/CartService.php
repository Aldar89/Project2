<?php

namespace Aldar\Project2\Service;

use Aldar\Project2\Model\User;
use Aldar\Project2\Model\UserProduct;

class CartService
{
    public  function addProductInaCart($userId, $productId, $amount)
    {
        $result = UserProduct::getByUserIdAndByProductId($userId, $productId);

        if ($result) {
            $amount = $amount + $result->getAmount();
            UserProduct::addProduct($userId, $productId, $amount);

        } else {
            UserProduct::create($userId, $productId, $amount);
        }
    }

    public  function getAllAmount($userId):int
    {
        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = 0;

        foreach ($userProducts as $product) {
            $amount = $product->getAmount();
            $allAmount +=$amount;
        }
        return $allAmount;
    }
    public function getTotalPrice($userId):float
    {
        $userProduct = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $totalPrice = 0;
        foreach ($userProduct as $product) {
            $amount = $product->getAmount();
            $price  = $product->getProduct()->getPrice();
            $totalPrice +=$amount*$price;
        }
        return $totalPrice;

    }
    public function deleteCart($userId)
    {
        UserProduct::deleteAllInCart($userId);
    }
}