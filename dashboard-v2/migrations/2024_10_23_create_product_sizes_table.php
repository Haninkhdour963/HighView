<?php

class CreateProductSizesTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `product_sizes` (
            `id` int NOT NULL AUTO_INCREMENT,
            `product_id` int NOT NULL,
            `size` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
            `type_id` int DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `product_id` (`product_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `product_sizes`";
    }
}
