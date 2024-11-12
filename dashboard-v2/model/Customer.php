<?php

require_once 'Model.php';

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    // Fetch customer details by customer ID
    public function findCustomerById($customerId)
    {
        return $this->find($customerId);
    }

    // Fetch all customers with role 'customer'
    public function allCustomers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'user'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update customer account status
    public function updateStatus($customerId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_active = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $customerId]);
    }

    // Retrieve customer order history
    public function getOrderHistory($customerId)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            orders.order_id,
            orders.order_total,
            orders.shipping_address,
            orders.product_quantity,
            orders.created_at,
            os.name AS order_status,
            ps.name AS payment_status
        FROM orders
        LEFT JOIN statuses AS os ON orders.order_status_id = os.id AND os.type = 'order'
        LEFT JOIN statuses AS ps ON orders.payment_status_id = ps.id AND ps.type = 'payment'
        WHERE orders.user_id = :id
        ORDER BY orders.created_at DESC
    ");
        $stmt->execute([':id' => $customerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Retrieve customer addresses
    public function getSavedAddresses($customerId)
    {
        $stmt = $this->pdo->prepare("SELECT city, district, street, building_num FROM users WHERE id = :id");
        $stmt->execute([':id' => $customerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
