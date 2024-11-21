<?php

namespace Aldar\Project2\Request;
use Core\Request;

class ProductRequest extends Request
{
    public function getProductName():?string
    {
        return $this->data['name'] ?? null;
    }

    public function getProductPrice():?float
    {
        return $this->data['price'] ?? null;
    }

    public function getProductDescription():?string
    {
        return $this->data['description'] ?? null;
    }
    public function getProductImage():?string
    {
        return $this->data['image'] ?? null;
    }

    public function getProductId():?int
    {
        return $this->data['product_id'] ?? null;
    }

    public function getAmount():?float
    {
        return $this->data['amount'] ?? null;
    }

}