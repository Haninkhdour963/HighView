<?php if (session_status() === PHP_SESSION_NONE) {
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

.form-control, .form-select {
    border: 1.5px solid var(--border-color);
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: var(--transition);
    background-color: var(--background-color);
}

.form-control:focus, .form-select:focus {
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
#front-preview, #side-preview, #back-preview {
    min-height: 100px;
    border-radius: 0.5rem;
    overflow: hidden;
}

#front-preview img, #side-preview img, #back-preview img {
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
        <div class="col-12 col-lg-8">
            <div class="form-container">
                <div class="page-header">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Category
                    </h2>
                </div>

                <form action="/category/update" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- Hidden ID Field -->
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">

                        <!-- Name Input -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" id="name" name="name" class="form-control pe-5 ps-2"
                                    value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                <label for="name">Name</label>
                            </div>
                        </div>

                        <!-- Current Image Preview -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Current Image:</label>
                            <?php if (!empty($category['img'])): ?>
                                <div class="mb-3">
                                    <img src="/<?php echo htmlspecialchars($category['img']); ?>" class="img-thumbnail" style="width: 100px; height: auto;" alt="Product Image">
                                </div>
                            <?php else: ?>
                                <p>No image uploaded.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Image Upload Area with Drag and Drop -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Upload New Image:</label>
                            <div id="drop-area" class="border-dashed border-2 border-primary rounded px-3 py-4 text-center"
                                ondragover="event.preventDefault();" ondrop="handleDrop(event)">
                                <p>Drag & Drop image here or click to upload</p>
                                <input type="file" id="fileElem" name="img" accept="image/*" onchange="handleFiles(this.files)" style="display:none;">
                                <button type="button" onclick="document.getElementById('fileElem').click()" class="btn btn-secondary">Select Image</button>
                                <div id="preview" class="mt-3"></div>
                            </div>
                            <input type="hidden" name="current_img" value="<?php echo htmlspecialchars($category['img']); ?>">
                        </div>

                        <!-- Button Group -->
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Category
                                </button>
                                <a href="/category" class="btn btn-outline-secondary">
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