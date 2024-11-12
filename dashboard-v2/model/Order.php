<?php

require_once 'Model.php';

class Orders extends Model
{
    public function  __construct()
    {
        parent::__construct("orders");
    }

    public function allWithStatuses()
    {
        $sql = "SELECT orders.*, 
                   os.name AS order_status, 
                   ps.name AS payment_status,
                   CONCAT(users.first_name, ' ', users.last_name) AS full_name
            FROM orders
            LEFT JOIN statuses AS os ON orders.order_status_id = os.id AND os.type = 'order'
            LEFT JOIN statuses AS ps ON orders.payment_status_id = ps.id AND ps.type = 'payment'
            LEFT JOIN users ON orders.user_id = users.id"; // Join with users table

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalOrders()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total_orders FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
    }

    public function getTotalSales()
    {
        $stmt = $this->pdo->query("SELECT SUM(order_total) as total_sales FROM orders");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'] ?? 0;
    }


    public function getRecentOrders($limit = 5)
    {
        $stmt = $this->pdo->prepare("
        SELECT orders.order_id, 
               CONCAT(users.first_name, ' ', users.last_name) AS customer_name,
               users.email AS customer_email,
               orders.created_at AS order_date,
               orders.order_total AS order_amount,
               statuses.name AS status
        FROM orders
        LEFT JOIN users ON orders.user_id = users.id
        LEFT JOIN statuses ON orders.order_status_id = statuses.id
        ORDER BY orders.created_at DESC
        LIMIT :limit
    ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
