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
                <div class="page-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-box-fill me-3"></i>Product List
                    </h2>
                    <a href="/products/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>

                <?php if (!empty($products)): ?>
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Name</th>
                                    <th>Price</th>
                                    <!-- <th>Image</th> -->
                                    <!-- <th>Description</th> -->
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <!-- <td><strong>#PRD-00<?php echo htmlspecialchars($product['id']); ?></strong></td> -->
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>JD <?php echo htmlspecialchars($product['price']); ?></td>
                                        <!-- <td>
                                            <img src="<?php echo htmlspecialchars($product['image_id']); ?>" class="img-thumbnail" style="width: 100px;" alt="Product Image">
                                        </td> -->
                                        <!-- <td><?php echo htmlspecialchars($product['description']); ?></td> -->
                                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="/products/view?id=<?php echo htmlspecialchars($product['id']); ?>"
                                                    class=" btn-action btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="/products/edit?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-action btn-outline-warning">
                                                    <i class="fas fa-edit"></i>Edit
                                                </a>
                                                <form action="/products/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                                    <button type="submit" class="btn btn-action btn-outline-danger">
                                                        <i class="fas fa-trash-alt"></i>Delete
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
                        <p class="lead text-muted">No products found.</p>
                        <a href="/products/create" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Add First Product
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>