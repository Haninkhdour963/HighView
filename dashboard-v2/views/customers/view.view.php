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

<link rel="stylesheet" href="../public/assets/css/customer-profile.css">

<div class="container-fluid customer-profile-container">
    <div class="row g-4">
        <!-- Profile Sidebar -->
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-header">
                    <?php if (!empty($customer['img'])): ?>
                        <img src="/<?php echo htmlspecialchars($customer['img']); ?>"
                            alt="<?php echo htmlspecialchars($customer['first_name']); ?>"
                            class="profile-avatar">
                    <?php else: ?>
                        <div class="profile-avatar-placeholder">
                            <?php echo strtoupper(substr($customer['first_name'], 0, 1) . substr($customer['last_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="profile-body text-center">
                    <h3 class="profile-name">
                        <?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?>
                    </h3>
                    <p class="profile-email text-muted">
                        <?php echo htmlspecialchars($customer['email']); ?>
                    </p>

                    <div class="profile-status">
                        <span class="status-badge <?php echo $customer['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo $customer['is_active'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </div>

                    <div class="profile-actions mt-4">
                        <form action="/customers/update-status" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer['id']); ?>">
                            <input type="hidden" name="status" value="<?php echo $customer['is_active'] ? 0 : 1; ?>">
                            <button type="submit"
                                class="btn btn-action <?php echo $customer['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?>">
                                <?php echo $customer['is_active'] ? 'Deactivate Account' : 'Activate Account'; ?>
                            </button>
                        </form>
                        <form action="/customers/delete" method="POST">
                            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger btn-action" onclick="return confirm('Are you sure you want to delete this Customer?');">
                                <i class="fas fa-trash-alt me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact-info-card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled contact-details">
                        <li>
                            <i class="bi bi-envelope"></i>
                            <?php echo htmlspecialchars($customer['email']); ?>
                        </li>
                        <li>
                            <i class="bi bi-phone"></i>
                            <?php echo htmlspecialchars($customer['phone']); ?>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <?php echo htmlspecialchars($customer['city'] . ', ' . $customer['district'] . ', ' . $customer['street'] . ' St'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Customer Details and Order History -->
        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Customer Details Card -->
                <div class="col-12">
                    <div class="details-card">
                        <div class="card-header">
                            <h4 class="mb-0">Account Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex align-items-center justify-content-between ps-4">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label>Registration Date</label>
                                        <p><?php echo htmlspecialchars($customer['created_at']); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label>Last Updated</label>
                                        <p><?php echo htmlspecialchars($customer['updated_at']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <style>
                    /* Adjust table width to fit content without scrolling */
                    .order-table {
                        width: fit-content;
                        max-width: 600px;
                        /* Adjust the width as needed */
                        font-size: 0.859em;
                        /* Reduce font size for compact view */
                    }

                    .order-table th,
                    .order-table td {
                        padding: 0.3rem;
                        /* Reduce padding for a smaller table */
                    }
                </style> -->

                <!-- Order History Card -->
                <div class="col-12">
                    <div class="order-history-card">
                        <div class="card-header">
                            <h4 class="mb-0">Order History</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($orderHistory)): ?>
                                <div class="table-responsive ">
                                    <table class="table table-sm order-table">
                                        <thead>
                                            <tr>
                                                <!-- <th>Order ID</th> -->
                                                <th>Total</th>
                                                <!-- <th>Quantity</th> -->
                                                <th>Date</th>
                                                <th>Payment Status</th>
                                                <th>Order Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody>
                                            <?php foreach ($orderHistory as $order): ?>
                                                <tr>
                                                    <!-- <td>#<?php echo htmlspecialchars($order['order_id']); ?></td> -->
                                                    <td>JD <?php echo number_format($order['order_total'], 2); ?></td>
                                                    <!-- <td><?php echo htmlspecialchars($order['product_quantity']); ?></td> -->
                                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                                    <td><?php echo htmlspecialchars($order['payment_status']); ?></td> <!-- Use 'payment_status' -->
                                                    <td><?php echo htmlspecialchars($order['order_status']); ?></td> <!-- Use 'order_status' -->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                        </tbody>

                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                                    <p class="lead text-muted">No orders found</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>