<?php
session_start();

// Only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites") or die(mysqli_connect_error());

// Handle Delete Order
if (isset($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];
    // Delete items first
    mysqli_query($con, "DELETE FROM order_items WHERE order_id='$order_id'");
    // Delete order
    mysqli_query($con, "DELETE FROM orders WHERE id='$order_id'");
    header("Location: admin.php");
}

// Get all orders for the table
$orders = mysqli_query($con, "SELECT * FROM orders ORDER BY order_time DESC") or die(mysqli_error($con));

// Calculate statistics
$stats_query = mysqli_query($con, "SELECT 
    COUNT(*) as total_orders,
    SUM(CASE WHEN order_status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
    SUM(CASE WHEN order_status = 'preparing' THEN 1 ELSE 0 END) as preparing_orders,
    SUM(CASE WHEN order_status = 'completed' THEN 1 ELSE 0 END) as completed_orders,
    SUM(CASE WHEN order_status = 'canceled' THEN 1 ELSE 0 END) as canceled_orders,
    SUM(CASE WHEN order_status = 'completed' THEN total_price ELSE 0 END) as total_revenue,
    SUM(CASE WHEN order_status = 'completed' AND payment_status = 'Paid' THEN 1 ELSE 0 END) as paid_orders,
    SUM(CASE WHEN order_status = 'completed' AND payment_status = 'Unpaid' THEN 1 ELSE 0 END) as unpaid_orders
FROM orders") or die(mysqli_error($con));

$stats = mysqli_fetch_assoc($stats_query);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EatBites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-red: #8B0000;
            --yellow: #FFD700;
            --white: #FFFFFF;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            background-color: var(--dark-red);
            height: 70px;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: var(--white) !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            background-color: var(--yellow);
            color: var(--dark-red) !important;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        /* Footer */
        .footer {
            background-color: var(--dark-red);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        /* Overview Cards */
        .overview-card {
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .overview-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .overview-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .overview-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .card-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .card-pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .card-preparing { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .card-completed { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
        .card-canceled { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
        .card-revenue { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); color: white; }
        .card-paid { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .card-unpaid { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333; }

        .page-header {
            background: linear-gradient(135deg, var(--dark-red) 0%, #dc143c 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        [data-bs-theme="dark"] .table-container {
            background: #212529;
        }

        [data-bs-theme="dark"] .overview-card {
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
        }

        /* Circular Theme Toggle Button */
        #toggleTheme {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            padding: 0;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
        }

        #toggleTheme:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* View Details Button Styling */
        .btn-view-details {
            background-color: white;
            color: black;
            border: 2px solid #dee2e6;
        }

        .btn-view-details:hover {
            background-color: #f8f9fa;
            color: black;
            border-color: #adb5bd;
        }

        [data-bs-theme="dark"] .btn-view-details {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        [data-bs-theme="dark"] .btn-view-details:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: white;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="admin.php">
            <img src="img/EatBites.png" alt="EatBites Logo" width="40" class="me-2">
            EatBites Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="admin.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_staff.php">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item ms-3">
                    <button class="btn btn-warning" id="toggleTheme">👁️</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="mb-0">🛎️ Admin Dashboard</h1>
        <p class="mb-0 mt-2">Welcome back Admin! Manage orders and monitor restaurant performance</p>
    </div>

    <!-- OVERVIEW SUMMARY SECTION -->
    <h3 class="mb-3">Overview Summary</h3>
    <div class="row">
        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="overview-card card-total">
                <h3><?php echo $stats['total_orders']; ?></h3>
                <p>Total Orders</p>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-3">
            <div class="overview-card card-pending">
                <h3><?php echo $stats['pending_orders']; ?></h3>
                <p>Pending Orders</p>
            </div>
        </div>

        <!-- Preparing Orders -->
        <div class="col-md-3">
            <div class="overview-card card-preparing">
                <h3><?php echo $stats['preparing_orders']; ?></h3>
                <p>Preparing Orders</p>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-md-3">
            <div class="overview-card card-completed">
                <h3><?php echo $stats['completed_orders']; ?></h3>
                <p>Completed Orders</p>
            </div>
        </div>

        <!-- Canceled Orders -->
        <div class="col-md-3">
            <div class="overview-card card-canceled">
                <h3><?php echo $stats['canceled_orders']; ?></h3>
                <p>Canceled Orders</p>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="overview-card card-revenue">
                <h3>RM <?php echo number_format($stats['total_revenue'], 2); ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <!-- Paid Orders -->
        <div class="col-md-3">
            <div class="overview-card card-paid">
                <h3><?php echo $stats['paid_orders']; ?></h3>
                <p>Paid Orders</p>
            </div>
        </div>

        <!-- Unpaid Orders -->
        <div class="col-md-3">
            <div class="overview-card card-unpaid">
                <h3><?php echo $stats['unpaid_orders']; ?></h3>
                <p>Unpaid Orders</p>
            </div>
        </div>
    </div>

    <!-- ORDERS TABLE -->
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h3 class="mb-0">Orders</h3>
        <a href="export_orders_pdf.php" class="btn btn-danger" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf me-2" viewBox="0 0 16 16">
                <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
            </svg>
            Export to PDF
        </a>
    </div>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Table No</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Order Time</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                // Reset the result pointer
                mysqli_data_seek($orders, 0);
                while ($order = mysqli_fetch_assoc($orders)) { 
                ?>
                    <tr>
                        <td><strong class="text-primary">#<?php echo $order['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><span class="badge bg-dark"><?php echo htmlspecialchars($order['table_no']); ?></span></td>
                        <td><strong>RM <?php echo number_format($order['total_price'], 2); ?></strong></td>
                        <td><small><?php echo date('d M Y, h:i A', strtotime($order['order_time'])); ?></small></td>
                        <td>
                            <span class="badge rounded-pill 
                                <?php
                                    if ($order['order_status'] == 'pending') echo 'bg-warning text-dark';
                                    elseif ($order['order_status'] == 'preparing') echo 'bg-info text-dark';
                                    elseif ($order['order_status'] == 'completed') echo 'bg-success';
                                    else echo 'bg-danger';
                                ?>
                            ">
                                <?php echo ucfirst($order['order_status']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill <?php echo $order['payment_status'] == 'Paid' ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $order['payment_status']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="admin_order_view.php?id=<?php echo $order['id']; ?>" 
                                   class="btn btn-sm btn-view-details">
                                    <small>View Details</small>
                                </a>
                                <a href="admin.php?delete_order=<?php echo $order['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this order?')">
                                    <small>Delete</small>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2026 EatBites. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle light/dark color modes
    const toggleBtn = document.getElementById('toggleTheme');
    
    // Load saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
    
    toggleBtn.addEventListener('click', () => {
        const html = document.documentElement;
        const current = html.getAttribute('data-bs-theme');
        const newTheme = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
</script>
</body>
</html>
