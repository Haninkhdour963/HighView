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

<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 ">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-people-fill me-3"></i>Customer Management
                    </h2>
                </div>

                <?php if (!empty($customers)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Full Name</th>
                                    <th>Contact Information</th>
                                    <th>Account Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                    <tr>
                                        <!-- <td><strong>#CUS-00<?php echo htmlspecialchars($customer['id']); ?></strong></td> -->
                                        <td>
                                            <?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?>
                                        </td>
                                        <td>
                                            <div><?php echo htmlspecialchars($customer['email']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($customer['phone']); ?></small>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $customer['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $customer['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="/customers/view?id=<?php echo htmlspecialchars($customer['id']); ?>"
                                                    class="btn btn-action btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    View
                                                </a>
                                                <form action="/customers/update-status" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer['id']); ?>">
                                                    <input type="hidden" name="status" value="<?php echo $customer['is_active'] ? 0 : 1; ?>">
                                                    <button type="submit"
                                                        class="btn btn-action <?php echo $customer['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?>">
                                                        <i class="fas fa-<?php echo $customer['is_active'] ? 'times-circle' : 'check-circle'; ?> me-1"></i>
                                                        <?php echo $customer['is_active'] ? 'Deactivate' : 'Activate'; ?>
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
                        <p class="lead text-muted">No customers found.</p>
                        <a href="/customers/add" class="btn btn-action btn-primary mt-3">
                            Add First Customer
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>