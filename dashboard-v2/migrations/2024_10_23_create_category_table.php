<?php

class CreateCategoryTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `img` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    }
    
    public function down()
    {
        return "DROP TABLE IF EXISTS `category`;";
    }
}
