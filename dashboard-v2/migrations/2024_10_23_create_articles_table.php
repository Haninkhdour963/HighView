<?php

class CreateArticlesTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `articles` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `body` TEXT COLLATE utf8mb4_general_ci,
            `views` INT DEFAULT '0',
            `featured_img` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `title` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `created_by` INT DEFAULT NULL,  -- Added created_by field
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`created_by`)  -- Ensure this key matches the created_by column
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    }
    
    public function down()
    {
        return "DROP TABLE IF EXISTS `articles`;";
    }
}
