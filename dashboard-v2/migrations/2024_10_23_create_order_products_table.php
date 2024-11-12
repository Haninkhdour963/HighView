<?php

class CreateOrderProductsTable  // Class name should reflect its purpose
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `order_products` (
            `order_item_id` int NOT NULL AUTO_INCREMENT,
            `order_id` int DEFAULT NULL,
            `product_id` int DEFAULT NULL,
            `quantity` int DEFAULT NULL,
            `price_at_purchase` decimal(10, 2) DEFAULT NULL,
            `total` decimal(10, 2) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`order_item_id`),
            KEY `order_id` (`order_id`),
            KEY `product_id` (`product_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `order_products`";
    }
}
