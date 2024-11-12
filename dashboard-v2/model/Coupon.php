<?php

require_once 'Model.php';

class Coupon extends Model
{
    public function __construct()
    {
        parent::__construct('coupon');
    }

    // Toggle the is_active status of a coupon
    public function toggleActiveStatus($couponId)
    {
        $coupon = $this->find($couponId);
        if ($coupon) {
            $newStatus = !$coupon['is_active']; // Toggle current is_active status
            return $this->update($couponId, ['is_active' => $newStatus]);
        }
        return false;
    }

    // Check if a coupon is valid and active (not expired)
    public function isValid($couponId)
    {
        $coupon = $this->find($couponId);
        if ($coupon) {
            $currentDate = date('Y-m-d H:i:s');
            return ($coupon['is_active'] && $coupon['expiry_date'] > $currentDate);
        }
        return false;
    }

    // Extend a coupon's expiry date
    public function extendExpiryDate($couponId, $newExpiryDate)
    {
        if (strtotime($newExpiryDate) > time()) { // Ensure new expiry is in the future
            return $this->update($couponId, ['expiry_date' => $newExpiryDate]);
        }
        return false; // Return false if new expiry date is not valid
    }
    public function exists($promocode)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM coupon WHERE promocode = :promocode");
        $stmt->execute([':promocode' => $promocode]);
        return $stmt->fetchColumn() > 0;
    }
}
