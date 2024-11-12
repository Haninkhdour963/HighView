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
                    <?php if (!empty($admin['img'])): ?>
                        <img src="<?php echo htmlspecialchars($admin['img']); ?>"
                            alt="<?php echo htmlspecialchars($admin['first_name']); ?>"
                            class="profile-avatar">
                    <?php else: ?>
                        <div class="profile-avatar-placeholder">
                            <?php echo strtoupper(substr($admin['first_name'], 0, 1) . substr($customer['last_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="profile-body text-center">
                    <h3 class="profile-name">
                        <?php echo htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?>
                    </h3>
                    <p class="profile-email text-muted">
                        <?php echo htmlspecialchars($admin['email']); ?>
                    </p>

                    <div class="profile-status">
                        <span class="status-badge <?php echo $admin['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo $admin['is_active'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </div>

                    <div class="profile-actions mt-4">
                        <form action="/superadmin/update-status" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>">
                            <input type="hidden" name="status" value="<?php echo $admin['is_active'] ? 0 : 1; ?>">
                            <button type="submit"
                                class="btn btn-action <?php echo $admin['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?>">
                                <?php echo $admin['is_active'] ? 'Deactivate Account' : 'Activate Account'; ?>
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
                            <?php echo htmlspecialchars($admin['email']); ?>
                        </li>
                        <li>
                            <i class="bi bi-phone"></i>
                            <?php echo htmlspecialchars($admin['phone']); ?>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <?php echo htmlspecialchars($admin['city'] . ', ' . $admin['district'] . ', ' . $admin['street'] . ' St'); ?>
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
                                        <p><?php echo htmlspecialchars($admin['created_at']); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label>Last Updated</label>
                                        <p><?php echo htmlspecialchars($admin['updated_at']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>