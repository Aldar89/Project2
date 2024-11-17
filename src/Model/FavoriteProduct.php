<?php

namespace Model;

use Core\Model;

class FavoriteProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    public static function createFavoriteProduct(int $userId, int $productId)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO favorite_products (product_id, user_id) VALUES (:product_id, :user_id)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }
    public static function getFavoriteProduct(int $userId, int $productId):?FavoriteProduct
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM favorite_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        return self::hydrate($data);
    }

    public static function getFavoriteProductByUserId(int $userId):array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM favorite_products WHERE user_id = :user_id ");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchall();
        $favoriteProducts = [];
        foreach ($data as $item) {
            $favoriteProducts[] = self::hydrate($item);
        }
        return $favoriteProducts;
    }

    public static function deleteFavoriteProduct(int $userId, int $productId)
    {
        $stmt = self::getPdo()->prepare("DELETE FROM favorite_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public static function hydrate( $data){
        $obj = new self();
        $obj->id = $data['id'];

        $user = new User();
        $userFromDB = $user->getById($data['user_id']);
        $product = new Product();
        $productFromDB = $product->getProductById($data['product_id']);

        $obj->user = $userFromDB;
        $obj->product = $productFromDB;
        return $obj;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }


}