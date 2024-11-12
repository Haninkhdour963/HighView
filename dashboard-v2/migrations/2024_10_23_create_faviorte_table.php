<?php

class CreateFaviorteTable  // Updated class name
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `favorite` (
            `id` int NOT NULL AUTO_INCREMENT,
            `user_id` int DEFAULT NULL,       -- User who favorited the product
            `product_id` int DEFAULT NULL,    -- ID of the favorited product
            `created_by` int DEFAULT NULL,    -- ID of the user who created the favorite entry
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),        -- Index for user_id for faster lookups
            KEY `product_id` (`product_id`)   -- Index for product_id for faster lookups
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `favorite`;";
    }
}
