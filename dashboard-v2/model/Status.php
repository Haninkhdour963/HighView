<?php

require_once 'Model.php';

class Status extends Model
{
    public function __construct()
    {
        parent::__construct('statuses');
    }

    public function getStatusesByType($type)
    {
        $sql = "SELECT id, name FROM statuses WHERE type = :type";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
