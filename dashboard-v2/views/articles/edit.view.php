<?php include 'views/partials/header.php'; ?>
<link rel="stylesheet" href="../public/assets/css/main-style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="form-container">
                <div class="page-header">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Article
                    </h2>
                </div>

                <form action="/articles/update" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">

                    <div class="row g-4">
                        <!-- Title Input -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control pe-5 ps-2"
                                    id="title"
                                    name="title"
                                    placeholder="Enter article title"
                                    value="<?php echo htmlspecialchars($article['title']); ?>"
                                    required>
                                <label for="title">Title</label>
                            </div>
                        </div>

                        <!-- Body Input -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control pe-5 ps-2"
                                    id="body"
                                    name="body"
                                    placeholder="Enter article body"
                                    rows="4"
                                    required><?php echo htmlspecialchars($article['body']); ?></textarea>
                                <label for="body">Body</label>
                            </div>
                        </div>

                        <!-- Featured Image URL Input -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control pe-5 ps-2"
                                    id="featured_img"
                                    name="featured_img"
                                    placeholder="Enter featured image URL"
                                    value="<?php echo htmlspecialchars($article['featured_img']); ?>">
                                <label for="featured_img">Featured Image URL</label>
                            </div>
                        </div>

                        <!-- Created By Input -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control pe-5 ps-2"
                                    id="created_by"
                                    name="created_by"
                                    placeholder="Enter creator name"
                                    value="<?php echo htmlspecialchars($article['created_by']); ?>"
                                    required>
                                <label for="created_by">Created By</label>
                            </div>
                        </div>

                        <!-- Button Group -->
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Article
                                </button>
                                <a href="/articles" class="btn btn-outline-secondary">
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