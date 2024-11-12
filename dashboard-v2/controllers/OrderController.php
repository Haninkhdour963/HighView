<?php
require 'model/Order.php';
require 'model/Status.php';

class OrderController
{
    public function show()
    {
        $orderModel = new Orders();
        $statusModel = new Status();

        // Fetch orders with their current statuses
        $orders = $orderModel->allWithStatuses();

        // Fetch available statuses for dropdowns
        $orderStatuses = $statusModel->getStatusesByType('order');
        $paymentStatuses = $statusModel->getStatusesByType('payment');

        require 'views/orders/show.view.php';
    }


    public function update()
{
    $orderModel = new Orders();

    if (!isset($_POST['id'])) { // Update this to match the HTML form name="id"
        header('Location: /orders');
        exit;
    }

    $orderId = $_POST['id'];
    $data = [
        'order_status_id' => $_POST['order_status_id'] ?? null,
        'payment_status_id' => $_POST['payment_status_id'] ?? null,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $updateSuccess = $orderModel->updateId($orderId, $data, 'order_id'); // Pass `order_id` as primary key

    $_SESSION['alert'] = $updateSuccess ? 'success' : 'fail';

    header('Location: /orders');
    exit;
}


}
