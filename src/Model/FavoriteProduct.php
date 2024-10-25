<?php

namespace Model;

class FavoriteProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    public function createFavoriteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO favorite_products (product_id, user_id) VALUES (:product_id, :user_id)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }
    public function getFavoriteProduct(int $userId, int $productId):?FavoriteProduct
    {
        $stmt = $this->pdo->prepare("SELECT * FROM favorite_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        return $this->hydrate($data);
    }

    public function getFavoriteProductByUserId(int $userId):array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM favorite_products WHERE user_id = :user_id ");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchall();
        $favoriteProducts = [];
        foreach ($data as $item) {
            $favoriteProducts[] = $this->hydrate($item);
        }
        return $favoriteProducts;
    }

    public function deleteFavoriteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM favorite_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function hydrate( $data){
        $obj = new self();
        $this->id = $data['id'];

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