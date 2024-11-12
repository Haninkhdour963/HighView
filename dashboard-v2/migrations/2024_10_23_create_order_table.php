<?php

class CreateOrderTable  // Updated to match the expected name
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `orders` (
            `order_id` int NOT NULL AUTO_INCREMENT,
            `user_id` int DEFAULT NULL,
            `order_total` decimal(10, 2) DEFAULT NULL,
            `order_status` enum(
                'Pending',
                'Processing',
                'Shipped',
                'Delivered',
                'Cancelled'
            ) COLLATE utf8mb4_general_ci DEFAULT 'Pending',
            `payment_status` enum('Paid', 'Unpaid') COLLATE utf8mb4_general_ci DEFAULT 'Unpaid',
            `shipping_address` text COLLATE utf8mb4_general_ci,
            `product_quantity` int DEFAULT '0',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`order_id`),
            KEY `user_id` (`user_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `orders`";
    }
}
