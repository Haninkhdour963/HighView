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

<style>
    /* Modern Variables */
    :root {
        --primary-color: #4F46E5;
        --primary-hover: #4338CA;
        --secondary-color: #9CA3AF;
        --success-color: #10B981;
        --danger-color: #EF4444;
        --background-color: #F9FAFB;
        --card-background: #FFFFFF;
        --text-primary: #111827;
        --text-secondary: #6B7280;
        --border-color: #E5E7EB;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Global Styles */
    body {
        background-color: var(--background-color);
        color: var(--text-primary);
    }

    /* Form Container Styles */
    .form-container {
        background: var(--card-background);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        padding: 2rem;
        transition: var(--transition);
    }

    .page-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .page-header h2 {
        color: var(--primary-color);
        font-size: 1.875rem;
    }

    /* Form Controls */
    .form-floating {
        margin-bottom: 1rem;
    }

    .form-control,
    .form-select {
        border: 1.5px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        background-color: var(--background-color);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .form-control::placeholder {
        color: var(--text-secondary);
    }

    /* Custom Select Styling */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    /* Switch Toggle */
    .form-switch .form-check-input {
        height: 1.5rem;
        width: 3rem;
        border-radius: 2rem;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Drop Area Styling */
    .border-dashed {
        border: 2px dashed var(--primary-color);
        transition: var(--transition);
    }

    .border-dashed:hover {
        border-color: var(--primary-hover);
        background-color: rgba(79, 70, 229, 0.05);
    }

    /* Button Styling */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: var(--transition);
    }

    /* .btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
} */

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
    }

    /* .btn-outline-secondary {
    border: 2px solid var(--secondary-color);
    color: var(--text-secondary);
} */

    .btn-outline-secondary:hover {
        background-color: var(--secondary-color);
        color: white;
        transform: translateY(-1px);
    }

    /* Image Preview Area */
    #front-preview,
    #side-preview,
    #back-preview {
        min-height: 100px;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    #front-preview img,
    #side-preview img,
    #back-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* Loading State */
    .btn.loading {
        position: relative;
        color: transparent;
    }

    .btn.loading::after {
        content: "";
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="form-container">
                <div class="page-header">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </h2>
                </div>

                <form action="/products/create" method="POST" class="needs-validation" enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- Name Input -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="name" name="name" class="form-control pe-5 ps-2" placeholder="Enter product name" required>
                                <label for="name">Name</label>
                            </div>
                        </div>

                        <!-- Price Input -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" id="price" name="price" class="form-control pe-5 ps-2" step="0.01" placeholder="Enter price" required>
                                <label for="price">Price</label>
                            </div>
                        </div>

                        <!-- Description Input -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea id="description" name="description" class="form-control pe-5 ps-2" placeholder="Enter description" rows="3" required></textarea>
                                <label for="description">Description</label>
                            </div>
                        </div>

                        <!-- Category Select List -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="category_id">Category</label>
                            </div>
                        </div>
                        <!-- Category Select List -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="type_id" name="type_id" class="form-select" required>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?php echo htmlspecialchars($type['id']); ?>">
                                            <?php echo htmlspecialchars($type['type_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="type_id">Type</label>
                            </div>
                        </div>

                        <!-- Status Select List -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="status" name="status" class="form-select" required>
                                    <option value="visible">Visible</option>
                                    <option value="hidden">Hidden</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>

                        <!-- Quality Checking Select List -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="quality_checking" name="quality_checking" class="form-select" required>
                                    <option value="passed">Passed</option>
                                    <option value="failed">Failed</option>
                                </select>
                                <label for="quality_checking">Quality Checking</label>
                            </div>
                        </div>

                        <!-- Is Package Checkbox -->
                        <!-- <div class="col-md-10 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" id="is_package" name="is_package" class="form-check-input">
                                <label class="form-check-label" for="is_package">Is Package</label>
                            </div>
                        </div> -->

                        <!-- Dimensions Inputs -->
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" id="width" name="width" class="form-control  pe-5 ps-2" placeholder="Width">
                                <label for="width">Width</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" id="height" name="height" class="form-control  pe-5 ps-2" placeholder="Height">
                                <label for="height">Height</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" id="weight" name="weight" class="form-control pe-5 ps-2" placeholder="Weight">
                                <label for="weight">Weight</label>
                            </div>
                        </div>

                        <!-- Stock Input -->
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" id="stock" name="stock" class="form-control pe-5 ps-2" placeholder="Enter stock quantity" required>
                                <label for="stock">Stock</label>
                            </div>
                        </div>

                        <!-- Image Drag and Drop Area -->
                        <div class="row g-3">
                            <!-- Front View Image Upload -->
                            <div class="col-md-4">
                                <label class="form-label">Front View Image:</label>
                                <div id="front-drop-area" class="border-dashed border-2 border-primary rounded px-3 py-4 text-center">
                                    <p>Drag & Drop or click to upload</p>
                                    <input type="file" name="front_view" accept="image/*" onchange="handleFilesProduct(this.files, 'front-preview')" style="display:none;">
                                    <button type="button" onclick="this.previousElementSibling.click()" class="btn btn-secondary">Select Front Image</button>
                                    <div id="front-preview" class="mt-3"></div>
                                </div>
                            </div>

                            <!-- Side View Image Upload -->
                            <div class="col-md-4">
                                <label class="form-label">Side View Image:</label>
                                <div id="side-drop-area" class="border-dashed border-2 border-primary rounded px-3 py-4 text-center">
                                    <p>Drag & Drop or click to upload</p>
                                    <input type="file" name="side_view" accept="image/*" onchange="handleFilesProduct(this.files, 'side-preview')" style="display:none;">
                                    <button type="button" onclick="this.previousElementSibling.click()" class="btn btn-secondary">Select Side Image</button>
                                    <div id="side-preview" class="mt-3"></div>
                                </div>
                            </div>

                            <!-- Back View Image Upload -->
                            <div class="col-md-4">
                                <label class="form-label">Back View Image:</label>
                                <div id="back-drop-area" class="border-dashed border-2 border-primary rounded px-3 py-4 text-center">
                                    <p>Drag & Drop or click to upload</p>
                                    <input type="file" name="back_view" accept="image/*" onchange="handleFilesProduct(this.files, 'back-preview')" style="display:none;">
                                    <button type="button" onclick="this.previousElementSibling.click()" class="btn btn-secondary">Select Back Image</button>
                                    <div id="back-preview" class="mt-3"></div>
                                </div>
                            </div>
                        </div>


                        <!-- Button Group -->
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Add Product
                                </button>
                                <a href="/products" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>