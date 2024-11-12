<?php

class CreateCouponTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `coupon` (
            `id` int NOT NULL AUTO_INCREMENT,
            `promocode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `percentage` int DEFAULT NULL,
            `expiry_date` date DEFAULT NULL,
            `created_by` int DEFAULT NULL,  -- Added created_by column
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`created_by`)  -- Index for created_by
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `coupon`";
    }
}
