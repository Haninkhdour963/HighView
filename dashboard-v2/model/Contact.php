<?php

require_once 'Model.php';

class Contact extends Model
{



    public function __construct()
    {
        parent::__construct('contact');
    }

    public function getAllWithDetails()
    {
        $sql = "
    SELECT 
        contact.*,
        CASE 
            WHEN users.role = 'admin' THEN CONCAT(users.first_name, ' ', users.last_name)
            ELSE NULL
        END AS admin_name,
        CASE 
            WHEN users.role = 'customer' THEN CONCAT(users.first_name, ' ', users.last_name)
            ELSE NULL
        END AS customer_name,
        CASE 
            WHEN users.role = 'admin' THEN users.id
            ELSE NULL
        END AS admin_id
    FROM 
        contact
    LEFT JOIN 
        users ON contact.user_id = users.id
    ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateReplyStatus($contactId, $isReply)
    {
        $stmt = $this->pdo->prepare("UPDATE contact SET is_reply = :is_reply WHERE id = :id");
        return $stmt->execute([':is_reply' => $isReply, ':id' => $contactId]);
    }
}
