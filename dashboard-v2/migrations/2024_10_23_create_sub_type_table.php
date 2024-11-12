<?php

class CreateSubTypeTable
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS `subtype` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `typeId` INT NOT NULL,
            `name` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    }

    public function down()
    {
        return "DROP TABLE IF EXISTS `subtype`;";
    }
}
