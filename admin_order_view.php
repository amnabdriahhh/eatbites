<?php
session_start();

// Only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites") or die(mysqli_connect_error());

$order_id = $_GET['id'];

// Handle payment status update
if (isset($_POST['update_payment'])) {
    $new_payment_status = $_POST['payment_status'];
    mysqli_query($con, "UPDATE orders SET payment_status='$new_payment_status' WHERE id='$order_id'") or die(mysqli_error($con));
    header("Location: admin_order_view.php?id=$order_id");
    exit;
}

// GET ORDER INFO
$order_query = mysqli_query($con, "SELECT * FROM orders WHERE id='$order_id'") or die(mysqli_error($con));
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    echo "Order not found.";
    exit;
}

// GET ORDER ITEMS
$items_result = mysqli_query($con, "SELECT * FROM order_items WHERE order_id='$order_id'") or die(mysqli_error($con));

// STORE ITEMS IN ARRAY & CALCULATE TOTAL
$items_array = [];
$total = 0;

while ($item = mysqli_fetch_assoc($items_result)) {
    $items_array[] = $item;
    if ($item['item_status'] != 'canceled') {
        $total += $item['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?php echo $order_id; ?> - Admin - EatBites</title>
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

        .page-header {
            background: linear-gradient(135deg, var(--dark-red) 0%, #dc143c 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        [data-bs-theme="dark"] .content-card {
            background: #212529;
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

        .order-meta {
            font-size: 1.1rem;
            line-height: 1.8;
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
                    <a class="nav-link" href="admin.php">Dashboard</a>
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

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">🛎️ Order #<?php echo $order_id; ?></h1>
            <p class="mb-0 mt-2">Table: <span class="badge bg-warning text-dark px-3 py-2 fs-6"><?php echo $order['table_no']; ?></span></p>
        </div>
        <div>
            <a href="export_receipt_pdf.php?id=<?php echo $order_id; ?>" class="btn btn-light btn-lg me-2" target="_blank">
                🖨️ Print Receipt
            </a>
            <a href="admin.php" class="btn btn-outline-light btn-lg">⬅ Back</a>
        </div>
    </div>

    <div class="row">
        <!-- Customer Info -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <h4 class="mb-3">👤 Customer Information</h4>
                <div class="order-meta">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                    <p><strong>Order Time:</strong> <?php echo date('d M Y, h:i A', strtotime($order['order_time'])); ?></p>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <h4 class="mb-3">💳 Payment & Status</h4>
                <div class="order-meta">
                    <p><strong>Order Status:</strong> 
                        <span class="badge rounded-pill <?php
                            if ($order['order_status'] == 'pending') echo 'bg-warning text-dark';
                            elseif ($order['order_status'] == 'preparing') echo 'bg-primary';
                            elseif ($order['order_status'] == 'completed') echo 'bg-success';
                            else echo 'bg-danger';
                        ?>">
                            <?php echo ucfirst($order['order_status']); ?>
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong> 
                        <span class="badge rounded-pill <?php echo ($order['payment_status'] == 'Paid') ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $order['payment_status']; ?>
                        </span>
                    </p>
                    <div class="mt-3">
                        <form method="POST" class="d-inline">
                            <?php if ($order['payment_status'] == 'Unpaid') { ?>
                                <input type="hidden" name="payment_status" value="Paid">
                                <button type="submit" name="update_payment" class="btn btn-success">✅ Mark as Paid</button>
                            <?php } else { ?>
                                <input type="hidden" name="payment_status" value="Unpaid">
                                <button type="submit" name="update_payment" class="btn btn-outline-danger">❌ Mark as Unpaid</button>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ORDER ITEMS TABLE -->
    <h3 class="mb-3 mt-4">🛒 Order Items</h3>
    <div class="content-card p-0">
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Menu Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Item Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items_array as $item) { ?>
                    <tr>
                        <td class="text-start ps-4"><strong><?php echo htmlspecialchars($item['menu_name']); ?></strong></td>
                        <td>RM <?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><strong>RM <?php echo number_format($item['subtotal'], 2); ?></strong></td>
                        <td>
                            <span class="badge <?php
                                if ($item['item_status'] == 'pending') echo 'bg-warning text-dark';
                                elseif ($item['item_status'] == 'completed') echo 'bg-success';
                                else echo 'bg-danger';
                            ?>">
                                <?php echo ucfirst($item['item_status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot class="table-light">
                    <tr class="fs-5">
                        <th colspan="3" class="text-end pe-4">Total Amount:</th>
                        <th colspan="2" class="text-primary">RM <?php echo number_format($total, 2); ?></th>
                    </tr>
                </tfoot>
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
