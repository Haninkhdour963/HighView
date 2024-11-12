<?php

require_once 'Model.php';

class Review extends Model
{
    public function __construct()
    {
        parent::__construct('user_review');
    }

    public function getAllWithDetails()
    {
        $sql = "
        SELECT 
            user_review.*,
            CONCAT(users.first_name, ' ', users.last_name) AS full_name,
            product.name AS product_name
        FROM 
           user_review
        LEFT JOIN 
            users ON user_review.id_user = users.id
        LEFT JOIN 
            product ON user_review.id_product = product.id
    ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Toggle visibility based on the status column
    // Toggle the is_active status of a coupon
    public function toggleActiveStatus($reviewId)
    {
        $review = $this->find($reviewId);
        if ($review) {
            $newStatus = !$review['is_visible']; // Toggle current is_active status
            return $this->update($reviewId, ['is_visible' => $newStatus]);
        }
        return false;
    }
    public function getReviewDetails($reviewId)
    {
        $sql = "
        SELECT 
           user_review.*,
            CONCAT(users.first_name, ' ', users.last_name) AS full_name,
            product.name AS product_name
        FROM 
           user_review
        LEFT JOIN 
            users ON user_review.id_user = users.id
        LEFT JOIN 
            product ON user_review.id_product = product.id
        WHERE
            user_review.id = :reviewId
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['reviewId' => $reviewId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
