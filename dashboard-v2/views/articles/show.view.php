<?php include 'views/partials/header.php'; ?>

<link rel="stylesheet" href="../public/assets/css/main-style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-newspaper me-3"></i>Article Management
                    </h2>
                    <a href="/articles/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Article
                    </a>
                </div>

                <?php if (!empty($articles)): ?>
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Title</th>
                                    <th>Views</th>
                                    <th>Body</th>
                                    <th>Created By</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articles as $article): ?>
                                    <tr>
                                        <!-- <td><?php echo htmlspecialchars($article['id']); ?></td> -->
                                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                                        <td><?php echo htmlspecialchars($article['views']); ?></td>
                                        <td><?php echo htmlspecialchars($article['body']); ?></td>
                                        <td><?php echo htmlspecialchars($article['created_by']); ?></td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="/articles/edit?id=<?php echo htmlspecialchars($article['id']); ?>" class="btn btn-action btn-outline-warning">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <form action="/articles/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">
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
                        <p class="lead text-muted">No articles found.</p>
                        <a href="/articles/create" class="btn btn-action btn-primary mt-3">
                            Add First Article
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>