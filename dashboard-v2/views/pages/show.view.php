<?php ob_start(); ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: /views/register/login.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/register/login.php");
    exit();
}
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=e_commerce", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch the user's name based on session user_id
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT first_name FROM users WHERE id = :id");
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $user['first_name'] ?? 'Admin'; // Fallback to 'Admin' if first_name is not found

// Fetch monthly sales data
$stmt = $pdo->prepare("
    SELECT DATE_FORMAT(created_at, '%M') AS month, SUM(order_total) AS total_sales
    FROM orders
    WHERE YEAR(created_at) = YEAR(CURDATE())
    GROUP BY MONTH(created_at)
    ORDER BY MONTH(created_at)
");
$stmt->execute();
$monthlySalesData = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthlySalesData[] = $row['total_sales'];
}
$totalSales = array_sum($monthlySalesData); // Sum of sales from each month
?>
<?php require('views/partials/header.php'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    /* Dashboard Layout */
    .dashboard-container {
        padding: 2rem;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .dashboard-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin: 0;
    }

    .current-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        transition: transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
    }

    .stats-card.orders .stats-icon {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .stats-card.sales .stats-icon {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .stats-card.customers .stats-icon {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }

    .stats-card.users .stats-icon {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .stats-info {
        flex: 1;
    }

    .stats-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .stats-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .stats-trend {
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stats-trend.positive {
        color: #198754;
    }

    .stats-trend.negative {
        color: #dc3545;
    }

    /* Orders Section Container */
    .orders-section {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }

    .btn-primary {
        color: white;
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #4F46E5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        border-radius: 0.75rem;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    /* Table Header */
    .dashboard-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #f1f5f9;
        text-align: left;
        white-space: nowrap;
    }

    .dashboard-table thead th:first-child {
        border-top-left-radius: 0.75rem;
    }

    .dashboard-table thead th:last-child {
        border-top-right-radius: 0.75rem;
    }

    /* Table Body */
    .dashboard-table tbody tr {
        transition: all 0.2s ease;
    }

    .dashboard-table tbody tr:hover {
        background: #f8fafc;
    }

    .dashboard-table tbody td {
        padding: 1rem 1.5rem;
        color: #334155;
        font-size: 0.9375rem;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .dashboard-table tbody tr:last-child td {
        border-bottom: none;
    }

    .dashboard-table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 0.75rem;
    }

    .dashboard-table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 0.75rem;
    }

    /* Status Styles */
    .dashboard-table td:last-child {
        font-weight: 500;
    }

    /* Status Colors */
    .status {
        position: relative;
        padding-left: 1.5rem;
        font-weight: 500;
    }

    .status::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    /* Define colors for each status */
    .status.pending::before {
        background-color: #FFA500;
        /* Orange for pending */
    }

    .status.completed::before,
    .status.delivered::before {
        background-color: #10B981;
        /* Green for completed or delivered */
    }

    .status.processing::before,
    .status.shipped::before {
        background-color: #3B82F6;
        /* Blue for processing or chipped */
    }

    .status.canceled::before {
        background-color: #EF4444;
        /* Red for canceled */
    }

    .status.paid::before {
        background-color: #4CAF50;
        /* Dark green for paid */
    }

    .status.unpaid::before {
        background-color: #FFC107;
        /* Yellow for unpaid */
    }


    /* Amount Column */
    .dashboard-table td:nth-child(4) {
        font-family: 'DM Mono', monospace;
        font-weight: 500;
        color: #1a1a1a;
    }

    /* Email Column */
    .dashboard-table td:nth-child(2) {
        color: #6366F1;
        font-weight: 500;
    }

    /* Date Column */
    .dashboard-table td:nth-child(3) {
        color: #64748b;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="welcome-section">
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, <?php echo htmlspecialchars($userName); ?></p>
        </div>
        <div class="date-section">
            <span class="current-date"><?php echo date('l, F j, Y'); ?></span>
        </div>
        <div class="header-actions">
            <a href="?action=logout" class="btn btn-secondary">Logout</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card orders">
            <div class="stats-icon">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="stats-info">
                <h3 class="stats-label">Total Orders</h3>
                <p class="stats-value"><?php echo $totalOrders; ?></p>
            </div>
        </div>

        <div class="stats-card sales">
            <div class="stats-icon">
                <i class="bi bi-graph-up"></i>
            </div>
            <div class="stats-info">
                <h3 class="stats-label">Total Sales</h3>
                <p class="stats-value"><?php echo 'JOD ' . number_format($totalSales); ?></p>
            </div>
        </div>

        <div class="stats-card users">
            <div class="stats-icon">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="stats-info">
                <h3 class="stats-label">Total Users</h3>
                <p class="stats-value"><?php echo $totalUsers; ?></p>
            </div>
        </div>
    </div>

    <!-- Monthly Sales Chart -->
    <div class="orders-section">
        <h2 class="section-title">Monthly Sales Overview</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Recent Orders Section -->
    <div class="orders-section">
        <div class="section-header">
            <h2 class="section-title">Recent Orders</h2>
            <a href="/orders" class="btn btn-primary btn-sm">View All Orders</a>
        </div>
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <!-- <th>Order ID</th> -->
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="recent-orders">
                    <?php foreach ($data['recentOrders'] as $order): ?>
                        <tr>
                            <!-- <td><?php echo htmlspecialchars($order['order_id']); ?></td> -->
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td>JOD <?php echo htmlspecialchars($order['order_amount']); ?></td>
                            <td class="status <?php echo strtolower(htmlspecialchars($order['status'])); ?>">
                                <?php echo htmlspecialchars($order['status']); ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
    // Monthly sales data retrieved from the database
    const monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Sales',
                data: monthlySalesData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<?php require('views/partials/footer.php'); ?>

<!-- **************************************************************************** -->