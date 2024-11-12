<?php

class CreateProductImagesTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `product_images` (
            `id` int NOT NULL AUTO_INCREMENT,
            `product_id` int NOT NULL,
            `front_view` varchar(255) DEFAULT NULL,
            `side_view` varchar(255) DEFAULT NULL,
            `back_view` varchar(255) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `product_id` (`product_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS product_images";
    }
}
