<?php include 'views/partials/header.php'; ?>
<link rel="stylesheet" href="../public/assets/css/main-style.css">


<style>
/* Modern Variables */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --success-color: #059669;
    --danger-color: #dc2626;
    --light-bg: #f8fafc;
    --border-radius: 0.75rem;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

/* Review Detail Container */
.card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    padding: 2rem;
}

h2 {
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
}

strong {
    font-weight: 600;
    color: #374151;
}

p {
    color: #6b7280;
    line-height: 1.5;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mt-4 {
    margin-top: 1.5rem;
}

/* Star Rating */
.star-rating {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 1.25rem;
    overflow: hidden;
}

.stars {
    display: inline-flex;
    gap: 4px;
    position: relative;
    color: #e5e7eb;
}

.stars::before,
.stars::after {
    content: "★★★★★";
    font-family: Arial, sans-serif;
    letter-spacing: 4px;
}

.stars::after {
    color: #fbbf24;
    position: absolute;
    left: 0;
    top: 0;
    width: calc(var(--rating) * 20%);
    overflow: hidden;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-active {
    background-color: #dbeafe;
    color: var(--primary-color);
}

.status-inactive {
    background-color: #fee2e2;
    color: var(--danger-color);
}

/* Buttons */
.btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    transition: var(--transition);
}

.btn-outline-secondary {
    color: #6b7280;
    border-color: #6b7280;
}

.btn-outline-secondary:hover {
    background-color: #6b7280;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card {
        padding: 1.5rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
}
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card p-4">
                <h2 class="fw-bold text-primary mb-3">Review Details</h2>

                <div class="mb-3">
                    <strong>User:</strong> <?php echo htmlspecialchars($review['full_name']); ?>
                </div>

                <div class="mb-3">
                    <strong>Product:</strong> <?php echo htmlspecialchars($review['product_name']); ?>
                </div>

                <div class="mb-3">
                    <strong>Rating:</strong>
                    <div class="star-rating">
                        <div class="stars" style="--rating: <?php echo htmlspecialchars($review['rate']); ?>"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Review:</strong>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="status-badge <?php echo $review['is_visible'] ? 'status-active' : 'status-inactive'; ?>">
                        <?php echo $review['is_visible'] ? 'Visible' : 'Hidden'; ?>
                    </span>
                </div>

                <div class="mt-4">
                    <a href="/reviews" class="btn btn-outline-secondary">Back to Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>