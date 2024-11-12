<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/register/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../public/assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/main-style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link id="pagestyle" href="../public/assets/css/material-dashboard.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #666;
            --accent-color: #9f8fff;
            --success-color: #00ca72;
            --warning-color: #ff9800;
            --danger-color: #ff4444;
            --background-color: #ffffff;
            --surface-color: #f8f9fa;
            --text-primary: #1a1a1a;
            --text-secondary: #666;
            --border-radius: 1rem;
            --transition: all 0.3s ease;
        }

        .product-details {
            padding: 2rem;
            background: var(--background-color);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Product Category */
        .product-category {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--surface-color);
            color: var(--text-secondary);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Product Title */
        .product-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        /* Product Price */
        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .currency {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        /* Product Description */
        .product-description {
            margin: 2rem 0;
            padding: 2rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .description-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .description-content {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.1rem;
        }

        /* Product Info Grid */
        .product-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .info-card {
            padding: 1.5rem;
            background: var(--surface-color);
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .info-card .label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .info-card .label i {
            font-size: 1.25rem;
            color: var(--accent-color);
        }

        .info-card .value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 500;
        }

        .status-badge i {
            font-size: 1rem;
        }

        .in-stock {
            background: rgba(0, 202, 114, 0.1);
            color: var(--success-color);
        }

        .low-stock {
            background: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .out-of-stock {
            background: rgba(255, 68, 68, 0.1);
            color: var(--danger-color);
        }

        /* Product Images Carousel */
        .product-image-container {
            border-radius: var(--border-radius);
            overflow: hidden;
            background: var(--surface-color);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .carousel-item {
            height: 500px;
            background: var(--surface-color);
            border-radius: var(--border-radius);
        }

        .product-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            border-radius: var(--border-radius);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: var(--transition);
        }

        .carousel-control-prev {
            left: rem;
        }

        .carousel-control-next {
            right: 1rem;
        }

        .product-image-container:hover .carousel-control-prev,
        .product-image-container:hover .carousel-control-next {
            opacity: 1;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            position: absolute;
            z-index: 7;
            top: 250px;
            filter: invert(1) grayscale(100);
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: var(--surface-color);
            color: var(--text-primary);
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            margin-top: 2rem;
        }

        .back-button:hover {
            background: var(--accent-color);
            color: white;
            transform: translateX(-5px);
        }

        /* Product Not Found */
        .text-warning {
            color: var(--warning-color) !important;
        }

        .lead {
            font-size: 1.25rem;
            font-weight: 400;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .product-title {
                font-size: 2rem;
            }

            .carousel-item {
                height: 400px;
            }

            .product-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .product-info-grid {
                grid-template-columns: 1fr;
            }

            .product-price {
                font-size: 1.75rem;
            }

            .carousel-item {
                height: 300px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-details>* {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <div class="container py-5">
        <?php if ($product): ?>
            <div class="product-details">
                <div class="row g-4">



                    <div class="col-lg-7">
                        <span class="product-category">
                            <?php echo htmlspecialchars($product['category_name']); ?>
                        </span>

                        <h1 class="product-title">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h1>

                        <div class="product-price">
                            <span class="currency">JD</span>
                            <?php echo number_format($product['price'], 2); ?>
                        </div>

                        <div class="product-description">
                            <h3 class="description-title">Description</h3>
                            <p class="description-content">
                                <?php echo htmlspecialchars($product['description']); ?>
                            </p>
                        </div>

                        <div class="product-info-grid">
                            <div class="info-card">
                                <div class="label">
                                    <i class="fas fa-box"></i>
                                    Stock Status
                                </div>
                                <div class="value">
                                    <?php
                                    $stockLevel = intval($product['stock']);
                                    if ($stockLevel > 10) {
                                        echo '<span class="status-badge in-stock"><i class="fas fa-check-circle"></i> In Stock (' . $stockLevel . ')</span>';
                                    } elseif ($stockLevel > 0) {
                                        echo '<span class="status-badge low-stock"><i class="fas fa-exclamation-circle"></i> Low Stock (' . $stockLevel . ')</span>';
                                    } else {
                                        echo '<span class="status-badge out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="label">
                                    <i class="fas fa-ruler-combined"></i>
                                    Dimensions
                                </div>
                                <div class="value">
                                    <?php echo htmlspecialchars($product['width']) . ' x ' .
                                        htmlspecialchars($product['height']) . ' x ' .
                                        htmlspecialchars($product['weight']); ?>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="label">
                                    <i class="fas fa-certificate"></i>
                                    Quality Check
                                </div>
                                <div class="value">
                                    <?php echo htmlspecialchars($product['quality_checking']); ?>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="label">
                                    <i class="fas fa-info-circle"></i>
                                    Status
                                </div>
                                <div class="value">
                                    <?php echo htmlspecialchars($product['status']); ?>
                                </div>
                            </div>
                        </div>

                        <!-- <a href="/products" class="back-button">
                            <i class="fas fa-arrow-left"></i>
                            Back to Products
                        </a> -->
                    </div>
                    <div class="col-lg-5">
                        <div id="productCarousel" class="carousel slide product-image-container s_Product_carousel" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Display Front View Image -->
                                <?php if (!empty($product['front_view'])): ?>
                                    <div class="carousel-item active">
                                        <!-- <h6>Front View</h6> -->
                                        <img src="../../public/assets/images/<?php echo htmlspecialchars($product['front_view']); ?>"
                                            class="d-block h-100 w-100 product-image"
                                            alt="<?php echo htmlspecialchars($product['name']); ?> - Front View">
                                    </div>
                                <?php endif; ?>

                                <!-- Display Side View Image -->
                                <?php if (!empty($product['side_view'])): ?>
                                    <div class="carousel-item">
                                        <!-- <h6>Side View</h6> -->
                                        <img src="../../public/assets/images/<?php echo htmlspecialchars($product['side_view']); ?>"
                                            class="d-block h-100 w-100 product-image"
                                            alt="<?php echo htmlspecialchars($product['name']); ?> - Side View">
                                    </div>
                                <?php endif; ?>

                                <!-- Display Back View Image -->
                                <?php if (!empty($product['back_view'])): ?>
                                    <div class="carousel-item">
                                        <!-- <h6>Back View</h6> -->
                                        <img src="../../public/assets/images/<?php echo htmlspecialchars($product['back_view']); ?>"
                                            class="d-block h-100 w-100 product-image"
                                            alt="<?php echo htmlspecialchars($product['name']); ?> - Back View">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Carousel controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="product-details text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                <h2 class="mb-4">Product Not Found</h2>
                <p class="lead text-muted mb-4">The product you're looking for doesn't exist or has been removed.</p>
                <a href="/products" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'views/partials/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>