<?php

class CreateProductTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `product` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `price` decimal(10, 2) DEFAULT NULL,
            `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `description` text COLLATE utf8mb4_general_ci,
            `category_id` int DEFAULT NULL,
            `created_by` int DEFAULT NULL,  -- Make sure this column is defined
            `is_package` enum('yes', 'no') COLLATE utf8mb4_general_ci DEFAULT 'no',
            `stock` int DEFAULT NULL,
            `total_rating` int DEFAULT '0',
            `width` decimal(10, 2) DEFAULT NULL,
            `height` decimal(10, 2) DEFAULT NULL,
            `weight` decimal(10, 2) DEFAULT NULL,
            `quality_checking` enum('passed', 'failed') COLLATE utf8mb4_general_ci DEFAULT 'passed',
            `status` enum('hidden', 'visible') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'visible',
            `type_id` int DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `id_category` (`category_id`),
            KEY `id_user` (`created_by`),
            KEY `type_id` (`type_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `product`";
    }
}
