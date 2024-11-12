<?php

class CreateDiscountTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `discount` (
            `id` int NOT NULL AUTO_INCREMENT,
            `id_product` int DEFAULT NULL,
            `newprice` decimal(10, 2) DEFAULT NULL,
            `startdate` date DEFAULT NULL,
            `enddate` date DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;";
    }
    
    public function down()
    {
        return "DROP TABLE IF EXISTS `discount`;";
    }
}

