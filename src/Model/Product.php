<?php

namespace Model;
class Product extends Model
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ");
        $products = $stmt->fetchAll();
        return $products;
    }


}