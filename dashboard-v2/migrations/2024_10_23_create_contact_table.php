<?php
class CreateContactTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `contact` (
            `id` int NOT NULL AUTO_INCREMENT,
            `user_id` int DEFAULT NULL,
            `message` text COLLATE utf8mb4_general_ci,
            `status` enum('replied', 'not_replied') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'not_replied',
            `admin_id` int DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }
    
    public function down()
    {
        return "DROP TABLE IF EXISTS contact";
    }
}