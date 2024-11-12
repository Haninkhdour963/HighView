<?php

class CreateUserReviewsTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `user_review` (
            `id` int NOT NULL AUTO_INCREMENT,
            `id_user` int DEFAULT NULL,
            `id_product` int DEFAULT NULL,
            `review` text COLLATE utf8mb4_general_ci,
            `rate` int DEFAULT NULL,
            `status` enum('appear', 'hide') COLLATE utf8mb4_general_ci DEFAULT 'appear',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `id_user` (`id_user`),
            KEY `id_product` (`id_product`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS user_review";
    }
}
