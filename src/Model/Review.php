<?php

namespace Aldar\Project2\Model;
use Core\Model;

class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private string $comment;
    private float $grade;


    public  static function create(int $userId,int $productId, string $comment, float $grade)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO card_product (user_id, product_id, comment, grade) 
                                                VALUES (:user_id, :product_id, :comment, :grade)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'comment' => $comment, 'grade' => $grade]);
    }

    public static function getProductReviews(int $productId):array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM card_product WHERE product_id = :productId");
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetchall();
        $reviews = [];
        foreach ($data as $review) {
            $reviews[] = self::hydrate($review);
        }
        return $reviews;
    }

    public static function getReviewByUserId(int $userId, int $productId):?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM card_product WHERE user_id = :user_id AND product_id = :productId ");
        $stmt->execute(['user_id' => $userId,'productId' => $productId]);
        $data = $stmt->fetch();
        if (empty($data)) {
            return null;
        }
        return $review = self::hydrate($data);
    }

    private static function hydrate(array $data):self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->comment = $data['comment'];
        $obj->grade = $data['grade'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getGrade(): float
    {
        return $this->grade;
    }

}