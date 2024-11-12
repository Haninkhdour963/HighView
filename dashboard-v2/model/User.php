<?php

require_once 'Model.php';

class User extends Model
{
    public function __construct(){
        parent::__construct('users');
    }
    public function getTotalUsers()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total_users FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
    }
}
