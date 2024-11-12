<?php

require_once 'model/Coupon.php';

class CouponController
{
    public function show()
    {
        // Initialize alert variables
        $showAlert = false;
        $alertType = '';
        $alertMessage = '';

        // Check session for alert messages
        if (isset($_SESSION['alert'])) {
            $showAlert = true;
            if ($_SESSION['alert'] === 'success') {
                $alertType = 'success';
                $alertMessage = 'Coupon status updated successfully!';
            } else {
                $alertType = 'danger';
                $alertMessage = 'Failed to update coupon status.';
            }

            // Clear the alert from session after getting it
            unset($_SESSION['alert']);
        }

        // Get all coupons
        $couponModel = new Coupon();
        $coupons = $couponModel->all();

        // Pass both coupons and alert data to the view
        require 'views/coupons/show.view.php';
    }

    public function create()
    {
        require 'views/coupons/create.view.php';
    }

    public function store()
    {
        $couponModel = new Coupon();
        $promocode = $_POST['promocode'];

        // Check if the coupon already exists
        if ($couponModel->exists($promocode)) {
            // Set a session error message
            $_SESSION['alert'] = 'danger';
            $_SESSION['alert_message'] = 'Coupon with this promo code already exists.';

            // Redirect back to the form
            header('Location: /coupons/create');
            exit;
        }

        // Prepare data for creating the new coupon
        $data = [
            'promocode' => $promocode,
            'percentage' => $_POST['percentage'],
            'created_by' => $_POST['created_by'], // Ensure this field is set correctly in your form
            'expiry_date' => $_POST['expiry_date'],
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        // Create the coupon
        $couponModel->create($data);

        // Set success message in session
        $_SESSION['alert'] = 'success';
        $_SESSION['alert_message'] = 'Coupon created successfully!';

        // Redirect to the coupons list
        header('Location: /coupons');
        exit;
    }



    public function updateStatus()
    {
        $couponModel = new Coupon();
        $couponId = $_POST['id'];

        // Toggle the active status
        $success = $couponModel->toggleActiveStatus($couponId);

        // Set a session message based on success or failure
        $_SESSION['alert'] = $success ? 'success' : 'danger';

        // Redirect back to the coupon listing page
        header('Location: /coupons');
        exit;
    }

    public function extendExpiry()
    {
        $couponModel = new Coupon();
        $couponId = $_POST['id'];
        $newExpiryDate = $_POST['new_expiry_date'];
        $couponModel->extendExpiryDate($couponId, $newExpiryDate);

        header('Location: /coupons');
        exit;
    }

    public function delete()
    {
        $couponModel = new Coupon();
        $id = $_POST['id'];
        $couponModel->delete($id);

        header('Location: /coupons');
        exit;
    }
}
