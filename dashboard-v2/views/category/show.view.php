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
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-list-ul me-3"></i>Category List
                    </h2>
                    <a href="/category/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Category
                    </a>
                </div>

                <?php if (!empty($categories)): ?>
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Name</th>
                                    <th>Image</th>
                                    <!-- <th>Created</th> -->
                                    <th>Updated</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <!-- <td><strong>#CAT-00<?php echo htmlspecialchars($category['id']); ?></strong></td> -->
                                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                                        <td><img src="../../public/assets/images/<?php echo htmlspecialchars($category['img']); ?>" alt="Category Image" class="img-thumbnail" width="50"></td>
                                        <!-- <td><?php echo date('Y-m-d / H:i', strtotime($category['created_at'])); ?></td> -->
                                        <td>
                                            <?php if (!empty($category['updated_at'])): ?>
                                                <?php echo date('Y-m-d / H:i', strtotime($category['updated_at'])); ?>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="/category/edit?id=<?php echo htmlspecialchars($category['id']); ?>" class="btn btn-action btn-outline-warning">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <form action="/category/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">
                                                    <button type="submit" class="btn btn-action btn-outline-danger">
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
                        <p class="lead text-muted">No categories found.</p>
                        <a href="/category/create" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Add First Category
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>