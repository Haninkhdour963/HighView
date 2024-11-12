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
<!-- Enhanced Alert -->
<?php if ($showAlert): ?>
    <div id="alert" class="custom-alert alert-<?php echo $alertType; ?>">
        <i class="fas fa-<?php echo $alertType === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
        <?php echo $alertMessage; ?>
    </div>
<?php endif; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="fas fa-ticket-alt me-2"></i>Coupon Management
                        </h2>
                    </div>
                    <a href="/coupons/create" class="btn btn-primary btn-action">
                        <i class="fas fa-plus me-2"></i>Add New Coupon
                    </a>
                </div>

                <?php if (!empty($coupons)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Promo Code</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Expiry Date</th>
                                    <!-- <th>Created By</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($coupons as $coupon): ?>
                                    <tr>
                                        <!-- <td class="fw-medium"><strong>#COP-00<?php echo htmlspecialchars($coupon['id']); ?></strong></td> -->
                                        <td class="fw-medium"><?php echo htmlspecialchars($coupon['promocode']); ?></td>
                                        <td>
                                            <span class="fw-medium"><?php echo htmlspecialchars($coupon['percentage']); ?>%</span>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $coupon['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $coupon['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($coupon['expiry_date'])); ?></td>
                                        <!-- <td><?php echo htmlspecialchars($coupon['created_by']); ?></td> -->
                                        <td>
                                            <div class="d-flex gap-2">
                                                <form action="/coupons/update-status" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($coupon['id']); ?>">
                                                    <button type="submit" class="btn btn-action <?php echo $coupon['is_active'] ? 'btn-outline-warning' : 'btn-outline-success'; ?>">
                                                        <i class="fas fa-<?php echo $coupon['is_active'] ? 'times-circle' : 'check-circle'; ?> me-1"></i>
                                                        <?php echo $coupon['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                                    </button>
                                                </form>
                                                <form action="/coupons/delete" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($coupon['id']); ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-action"
                                                        onclick="return confirm('Are you sure you want to delete this coupon?');">
                                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                        <p class="h5 text-muted">No coupons found</p>
                        <p class="text-muted">Create your first coupon to get started</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>