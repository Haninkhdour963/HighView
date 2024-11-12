<?php

require_once 'Model.php';

class Products extends Model
{



    public function __construct()
    {
        parent::__construct('product');
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("
        SELECT 
            product.id, 
            product.name, 
            product.price, 
            product.description, 
            product.stock, 
            category.name AS category_name,
            product_images.front_view, 
            product_images.side_view, 
            product_images.back_view
        FROM product
        LEFT JOIN category ON product.category_id = category.id
        LEFT JOIN product_images ON product_images.product_id = product.id
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithCategory($id)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            product.id, 
            product.name, 
            product.price, 
            product.description, 
            product.stock, 
            product.width, 
            product.height, 
            product.weight, 
            product.quality_checking, 
            product.category_id, 
            product.type_id, 
            product.status, 
            product.created_at, 
            product.updated_at, 
            category.name AS category_name,
            product_images.front_view, 
            product_images.side_view, 
            product_images.back_view
        FROM product
        LEFT JOIN category ON product.category_id = category.id
        LEFT JOIN type ON product.type_id = type.id
        LEFT JOIN product_images ON product_images.product_id = product.id
        WHERE product.id = :id
    ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
