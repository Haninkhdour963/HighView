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

<style>
    /* Star Rating Container */
    .star-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.9rem;
    }

    /* Star Icons Base Style */
    .stars {
        display: inline-flex;
        gap: 2px;
        position: relative;
        color: #e5e7eb;
        margin-right: 4px;
    }

    /* Individual Star */
    .stars::before,
    .stars::after {
        content: "★★★★★";
        font-family: Arial, sans-serif;
        letter-spacing: 2px;
    }

    /* Filled Stars (Overlapping) */
    .stars::after {
        color: #fbbf24;
        position: absolute;
        left: 0;
        top: 0;
        width: calc(var(--rating) * 20%);
        overflow: hidden;
    }

    /* Numeric Display */
    .rating-number {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.875rem;
    }

    /* Hover Animation */
    .star-rating:hover .stars::after {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    /* Optional: Different color schemes */
    .stars.gold::after {
        color: #fbbf24;
        /* Default gold */
    }

    .stars.yellow::after {
        color: #facc15;
        /* Brighter yellow */
    }

    .stars.amber::after {
        color: #f59e0b;
        /* Amber */
    }
</style>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="fas fa-comments me-2"></i>Review Management
                        </h2>
                    </div>
                </div>

                <?php if (!empty($reviews)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>User</th>
                                    <th>Product</th>
                                    <!-- <th>Review</th> -->
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reviews as $review): ?>
                                    <tr>
                                        <!-- <td class="fw-medium"><strong><?php echo htmlspecialchars($review['id']); ?></strong></td> -->
                                        <td class="fw-medium"><?php echo htmlspecialchars($review['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                                        <!-- <td><?php echo htmlspecialchars($review['review']); ?></td> -->
                                        <td>
                                            <div class="star-rating">
                                                <div class="stars" style="--rating: <?php echo htmlspecialchars($review['rate']); ?>"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $review['is_visible'] ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $review['is_visible'] ? 'Visible' : 'Hidden'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="/reviews/view?id=<?php echo htmlspecialchars($review['id']); ?>"
                                                    class=" btn-action btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <form action="/reviews/update-status" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($review['id']); ?>">
                                                    <button type="submit" class="btn btn-action <?php echo $review['is_visible'] ? 'btn-outline-warning' : 'btn-outline-success'; ?>">
                                                        <i class="fas fa-<?php echo $review['is_visible'] ? 'eye-slash' : 'eye'; ?> me-1"></i>
                                                        <?php echo $review['is_visible'] ? 'Hide' : 'Visible'; ?>

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
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="h5 text-muted">No reviews found</p>
                        <p class="text-muted">Reviews will appear here once submitted by users</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>