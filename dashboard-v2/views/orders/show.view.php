<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/register/login.php");
    exit();
}
?>
<?php include 'views/partials/header.php'; ?>
<link rel="stylesheet" href="../public/assets/css/main-style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php

$showAlert = false;
$alertType = '';
$alertMessage = '';

// Check session for alert message
if (isset($_SESSION['alert'])) {
    $showAlert = true; // Set to true to show the alert
    if ($_SESSION['alert'] === 'success') {
        $alertType = 'success';
        $alertMessage = 'Order updated successfully!';
    } else {
        $alertType = 'danger';
        $alertMessage = 'Failed to update order.';
    }

    // Clear the alert from session after displaying it
    unset($_SESSION['alert']);
}
?>

<!-- Display Alert -->
<div id="alert" class="alert alert-<?php echo $alertType; ?>" style="<?php echo $showAlert ? '' : 'display: none;'; ?>">
    <?php echo $alertMessage; ?>
</div>

<script>
    // Check if the alert element exists
    const alert = document.getElementById('alert');
    if (alert.style.display !== 'none') {
        // Set a timeout to hide the alert after 3 seconds (3000 milliseconds)
        setTimeout(() => {
            alert.style.display = 'none'; // Hide the alert
        }, 2000);
    }
</script>

<style>
    /* Modern Variables */
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --success-color: #059669;
        --dark-color: #1f2937;
        --light-bg: #f8fafc;
        --border-radius: 0.5rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Container Styles */
    .dashboard-container {
        background: var(--light-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h2 {
        font-size: 1.75rem;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Table Styles */
    .table {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }

    .table thead {
        background: var(--dark-color);
        color: white;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.05em;
        padding: 1rem;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background-color: rgba(37, 99, 235, 0.05);
    }

    /* Form Elements */
    .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 0.5rem;
        font-size: 0.875rem;
        transition: var(--transition);
        cursor: pointer;
        width: auto;
        min-width: 140px;
    }

    .form-select:hover {
        border-color: var(--primary-color);
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Status Selects */
    .order-status {
        background-color: #f3f4f6;
    }

    .payment-status {
        background-color: #f3f4f6;
    }

    /* Button Styles */
    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline-success {
        color: var(--success-color);
        border-color: var(--success-color);
    }

    .btn-outline-success:hover {
        background-color: var(--success-color);
        color: white;
    }

    /* Empty State */
    .text-muted {
        color: #6b7280;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .table td,
        .table th {
            padding: 0.75rem 0.5rem;
        }

        .form-select {
            min-width: 120px;
        }
    }

    /* Loading State Animation */
    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .loading {
        animation: pulse 1.5s infinite;
    }

    /* Subtle Row Animation */
    .table tbody tr {
        transform: translateX(0);
        opacity: 1;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .table tbody tr:hover {
        transform: translateX(4px);
    }
</style>

<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-cart-fill me-3"></i>Order List
                    </h2>
                </div>

                <?php if (!empty($orders)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>User</th>
                                    <th>Order Total</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <!-- <th>Shipping Address</th> -->
                                    <!-- <th>Product Quantity</th> -->
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <!-- <td><strong>#ORD-00<?php echo htmlspecialchars($order['order_id']); ?></strong></td> -->
                                        <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                        <td>JD <?php echo htmlspecialchars($order['order_total']); ?></td>

                                        <td>
                                            <form action="/orders/update" method="POST">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                                <select name="order_status_id" class="form-select form-select-sm order-status">
                                                    <?php foreach ($orderStatuses as $status): ?>
                                                        <option value="<?php echo htmlspecialchars($status['id']); ?>"
                                                            <?php echo ($order['order_status_id'] == $status['id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($status['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </td>

                                        <td>
                                            <select name="payment_status_id" class="form-select form-select-sm payment-status">
                                                <?php foreach ($paymentStatuses as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status['id']); ?>"
                                                        <?php echo ($order['payment_status_id'] == $status['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($status['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <!-- <td><?php echo htmlspecialchars($order['shipping_address']); ?></td> -->
                                        <!-- <td><?php echo htmlspecialchars($order['product_quantity']); ?></td> -->
                                        <td class="text-end">
                                            <button type="submit" class="btn btn-action btn-outline-success">
                                                <i class="fas fa-sync-alt"></i>Update
                                            </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <p class="lead text-muted">No orders found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>