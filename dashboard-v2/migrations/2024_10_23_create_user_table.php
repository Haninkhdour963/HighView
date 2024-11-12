<?php

class CreateUserTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `users` (
            `id` int NOT NULL AUTO_INCREMENT,
            `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `role` enum(
                'admin',
                'user',
                'super_admin'
            ) COLLATE utf8mb4_general_ci DEFAULT 'user',
            `city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `district` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `street` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `building_num` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS users";
    }
}
