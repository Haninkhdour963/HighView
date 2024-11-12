<?php

class CreateTypeTable
{
    public function up()
    {
        return"CREATE TABLE IF NOT EXISTS `type` (
            `id` int NOT NULL AUTO_INCREMENT,
            `type_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `type_name` (`type_name`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS type";
    }
}
