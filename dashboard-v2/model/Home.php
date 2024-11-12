<?php

require_once 'Model.php';

class Home extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) AS total_orders FROM orders";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
    }

    public function getTotalSales()
    {
        $sql = "SELECT SUM(amount) AS total_sales FROM orders";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];
    }

    public function getTotalUsers()
    {
        $sql = "SELECT COUNT(*) AS total_users FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
    }

    public function getRecentOrders($limit = 5)
    {
        $sql = "
            SELECT 
                orders.id AS order_id,
                CONCAT(users.first_name, ' ', users.last_name) AS customer_name,
                users.email AS customer_email,
                orders.created_at AS order_date,
                orders.amount AS order_amount,
                statuses.name AS status
            FROM 
                orders
            JOIN 
                users ON orders.user_id = users.id
            JOIN 
                statuses ON orders.status_id = statuses.id
            ORDER BY 
                orders.created_at DESC
            LIMIT :limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
