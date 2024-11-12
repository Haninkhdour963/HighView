<?php

class CreateProductColorTable  // Updated to match the expected name
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `product_color` (
            `id` int NOT NULL AUTO_INCREMENT,
            `color_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
            `type_id` int DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `color_name` (`color_name`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `product_color`";
    }
}
