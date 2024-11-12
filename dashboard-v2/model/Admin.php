<?php

require_once 'Model.php';

class Admin extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    // Fetch customer details by customer ID
    public function findAdminById($adminId)
    {
        return $this->find($adminId);
    }

    // Fetch all customers with role 'customer'
    public function allAdmins()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'admin'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update customer account status
    public function updateStatus($adminId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_active = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $adminId]);
    }

    // Retrieve customer order history
    // public function getOrderHistory($adminId)
    // {
    //     $stmt = $this->pdo->prepare("
    //     SELECT 
    //         orders.id,
    //         orders.order_total,
    //         orders.shipping_address,
    //         orders.product_quantity,
    //         orders.created_at,
    //         os.name AS order_status,
    //         ps.name AS payment_status
    //     FROM orders
    //     LEFT JOIN statuses AS os ON orders.order_status_id = os.id AND os.type = 'order'
    //     LEFT JOIN statuses AS ps ON orders.payment_status_id = ps.id AND ps.type = 'payment'
    //     WHERE orders.user_id = :id
    //     ORDER BY orders.created_at DESC
    // ");
    //     $stmt->execute([':id' => $adminId]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }



    // Retrieve customer addresses
    public function getSavedAddresses($adminId)
    {
        $stmt = $this->pdo->prepare("SELECT city, district, street, building_num FROM users WHERE id = :id");
        $stmt->execute([':id' => $adminId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
