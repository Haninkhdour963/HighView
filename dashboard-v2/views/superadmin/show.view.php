    <?php ob_start();
    include 'views/partials/header.php'; ?>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        header("Location: /");  // Redirect to the homepage or another appropriate page
        exit();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: /views/register/login.php");
        exit();
    }
    ?>

    <link rel="stylesheet" href="../public/assets/css/main-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <div class="container-fluid px-4 py-5">
        <div class="row justify-content-center">
            <div class="col-12 ">
                <div class="dashboard-container">
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="bi bi-people-fill me-3"></i>Admin Management
                        </h2>
                        <a href="/superadmin/create" class="btn btn-primary btn-action">
                            <i class="fas fa-plus me-2"></i>Add Admin
                        </a>
                    </div>

                    <?php if (!empty($admins)): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>Full Name</th>
                                        <th>Contact Information</th>
                                        <th>Role</th>
                                        <th>Account Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <!-- <td><?php echo htmlspecialchars($admin['id']); ?></td> -->
                                            <td>
                                                <?php echo htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?>
                                            </td>
                                            <td>
                                                <div><?php echo htmlspecialchars($admin['email']); ?></div>
                                                <small class="text-muted"><?php echo htmlspecialchars($admin['phone']); ?></small>
                                            </td>
                                            <!-- Role Column -->
                                            <td>
                                                <?php echo htmlspecialchars(ucfirst($admin['role'])); ?>
                                            </td>
                                            <td>
                                                <span class="status-badge <?php echo $admin['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                                    <?php echo $admin['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="/superadmin/edit?id=<?php echo $admin['id']; ?>" class="btn btn-outline-warning btn-action">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                    <form action="/superadmin/update-status" method="POST" class="d-inline">
                                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>">
                                                        <input type="hidden" name="status" value="<?php echo $admin['is_active'] ? 0 : 1; ?>">
                                                        <button type="submit"
                                                            class="btn btn-action <?php echo $admin['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?>">
                                                            <i class="fas fa-<?php echo $admin['is_active'] ? 'times-circle' : 'check-circle'; ?> me-1"></i>
                                                            <?php echo $admin['is_active'] ? 'Deactivate' : 'Activate'; ?>
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
                            <p class="lead text-muted">No admins found.</p>
                            <a href="/admins/add" class="btn btn-action btn-primary mt-3">
                                Add First Admin
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php include 'views/partials/footer.php';
    ob_end_flush(); ?>