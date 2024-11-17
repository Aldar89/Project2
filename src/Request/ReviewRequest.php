<?php

namespace Request;

class ReviewRequest extends Request
{
    public function getProductId():int
    {
        return $this->data['product_id'];
    }

    public function getGrade():float
    {
        return $this->data['grade'];
    }

    public function getComment():string
    {
        return $this->data['comment'];
    }
}