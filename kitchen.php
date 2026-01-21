<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'kitchen') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

$status_filter = $_GET['status'] ?? '';
$table_search  = $_GET['table'] ?? '';

// BUILD QUERY
$sql = "SELECT * FROM orders WHERE 1";

if ($status_filter != '') {
    $sql .= " AND order_status='$status_filter'";
}

if ($table_search != '') {
    $sql .= " AND table_no LIKE '%$table_search%'";
}

$sql .= " ORDER BY order_time DESC";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html data-bs-theme="light">
<head>
    <title>Kitchen Dashboard | EatBites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="kitchen.css">
</head>

<body class="kitchen-body">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="img/EatBites.png" width="40" class="me-2">
        EatBites Kitchen
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">
        <button class="btn" id="toggleTheme">👁️</button>
        <a href="logout.php" class="btn btn-warning fw-bold">Logout</a>
    </div>
  </div>
</nav>

<!-- HERO (NO WHITE GAP NOW) -->
<section class="kitchen-hero">
    <h1>🍳 Kitchen Dashboard</h1>
    <p>Prepare, manage & track orders efficiently</p>
</section>

<!-- CONTENT -->
<div class="container my-5">

    <!-- SEARCH & FILTER -->
    <form method="get" class="row g-3 justify-content-center mb-4">
        <div class="col-md-3">
            <input type="text"
                   name="table"
                   value="<?= htmlspecialchars($table_search) ?>"
                   class="form-control shadow-sm"
                   placeholder="Search Table No">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select shadow-sm">
                <option value="">All Status</option>
                <option value="pending" <?= $status_filter=='pending'?'selected':'' ?>>Pending</option>
                <option value="preparing" <?= $status_filter=='preparing'?'selected':'' ?>>Preparing</option>
                <option value="completed" <?= $status_filter=='completed'?'selected':'' ?>>Completed</option>
                <option value="canceled" <?= $status_filter=='canceled'?'selected':'' ?>>Canceled</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-danger w-100">Search</button>
        </div>

        <div class="col-md-2">
            <a href="kitchen.php" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- ORDER CARDS -->
    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($order = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card kitchen-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="fw-bold text-danger">
                                Order #<?= $order['id'] ?>
                            </h5>

                            <p class="mb-1"><strong>Table:</strong> <?= $order['table_no'] ?></p>
                            <p class="text-muted small"><?= $order['order_time'] ?></p>

                            <span class="badge status-badge
                                <?= $order['order_status']=='completed'?'bg-success':
                                    ($order['order_status']=='preparing'?'bg-primary':
                                    ($order['order_status']=='canceled'?'bg-danger':'bg-warning')) ?>">
                                <?= ucfirst($order['order_status']) ?>
                            </span>

                            <div class="mt-3">
                                <a href="kitchen_order_view.php?id=<?= $order['id'] ?>"
                                   class="btn btn-outline-danger btn-sm">
                                   View Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="text-center text-muted">
                <p>No matching orders found 🍽️</p>
            </div>
        <?php } ?>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2026 EatBites. All rights reserved.</p>
    </div>
</footer>

<script>
const html = document.documentElement;
const toggleBtn = document.getElementById('toggleTheme');

// Apply saved theme on load
const savedTheme = localStorage.getItem('eatbites-theme');
if (savedTheme) {
    html.setAttribute('data-bs-theme', savedTheme);
}

// Toggle theme and save preference
toggleBtn.addEventListener('click', () => {
    const current = html.getAttribute('data-bs-theme') || 'light';
    const newTheme = current === 'light' ? 'dark' : 'light';

    html.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('eatbites-theme', newTheme);
});
</script>


</body>
</html>
