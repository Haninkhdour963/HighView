<?php 

require_once 'Model.php';

class Discount extends Model {

    public function __construct() {
        parent::__construct('discount'); // Assuming the table name is 'discounts'
    }

    public function getAllWithDetails() {
        $sql = "
        SELECT 
            discount.*, 
            product.name AS product_name 
        FROM 
            discount 
        LEFT JOIN 
            product ON discount.id_product = product.id
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
