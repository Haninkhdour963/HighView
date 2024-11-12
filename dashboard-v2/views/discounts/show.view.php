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
<!-- <?php if ($showAlert): ?>
    <div id="alert" class="custom-alert alert-<?php echo $alertType; ?>">
        <i class="fas fa-<?php echo $alertType === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
        <?php echo $alertMessage; ?>
    </div>
<?php endif; ?> -->

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="fas fa-tags me-2"></i>Discount Management
                        </h2>
                    </div>
                    <a href="/discounts/create" class="btn btn-primary btn-action">
                        <i class="fas fa-plus me-2"></i>Add New Discount
                    </a>
                </div>

                <?php if (!empty($discounts)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Product</th>
                                    <th>New Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($discounts as $discount): ?>
                                    <tr>
                                        <!-- <td class="fw-medium"><strong>#DSC-00<?php echo htmlspecialchars($discount['id']); ?></strong></td> -->
                                        <td class="fw-medium"><?php echo htmlspecialchars($discount['product_name']); ?></td>
                                        <td class="fw-medium"><?php echo htmlspecialchars($discount['newprice']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($discount['startdate'])); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($discount['enddate'])); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="/discounts/edit?id=<?php echo $discount['id']; ?>" class="btn btn-outline-warning btn-action">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <form action="/discounts/delete" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $discount['id']; ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-action" onclick="return confirm('Are you sure you want to delete this discount?');">
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
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <p class="h5 text-muted">No discounts found</p>
                        <p class="text-muted">Create your first discount to get started</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>