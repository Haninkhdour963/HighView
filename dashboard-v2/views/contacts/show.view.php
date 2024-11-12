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

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="fas fa-envelope me-2"></i>Contact Management
                    </h2>
                </div>

                <?php if (!empty($contacts)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>User</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <!-- <td class="fw-medium"><strong>#MSG-00<?php echo htmlspecialchars($contact['id']); ?></strong></td> -->
                                        <td class="fw-medium">
                                            <?php echo !empty($contact['customer_name']) ? htmlspecialchars($contact['customer_name']) : 'Guest'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $words = explode(' ', $contact['message']);
                                            $chunks = array_chunk($words, 4); // Split into chunks of 4 words

                                            foreach ($chunks as $chunk) {
                                                echo htmlspecialchars(implode(' ', $chunk)) . "<br>"; // Join each chunk and add a line break
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <span class="status-badge <?php echo $contact['is_reply'] ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $contact['is_reply'] ? 'Reply Sent' : 'Pending'; ?>
                                            </span>
                                        </td>

                                        <td><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></td>
                                        <td>
                                            <form action="/contacts/update-reply-status" method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($contact['id']); ?>">
                                                <input type="hidden" name="is_reply" value="1">
                                                <button type="submit" class="btn btn-outline-success btn-action">
                                                    <i class="fas fa-envelope me-1"></i>Email
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                        <p class="h5 text-muted">No contacts found</p>
                        <p class="text-muted">You have no messages to review</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>