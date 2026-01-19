<?php
session_start();

// Only kitchen
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'kitchen') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

$order_id = $_GET['id'] ?? 0;

// HANDLE ITEM ACTIONS
if (isset($_POST['action'])) {
    $item_id = $_POST['item_id'];
    $action = $_POST['action'];

    $item = mysqli_fetch_assoc(mysqli_query($con, "SELECT quantity, price FROM order_items WHERE id='$item_id'"));

    if ($action == 'remove') {
        mysqli_query($con, "UPDATE order_items SET item_status='canceled' WHERE id='$item_id'");
    } elseif ($action == 'complete') {
        mysqli_query($con, "UPDATE order_items SET item_status='completed' WHERE id='$item_id'");
    } elseif ($action == 'increase') {
        $new_qty = $item['quantity'] + 1;
        $new_subtotal = $new_qty * $item['price'];
        mysqli_query($con, "UPDATE order_items SET quantity='$new_qty', subtotal='$new_subtotal' WHERE id='$item_id'");
    } elseif ($action == 'decrease' && $item['quantity'] > 1) {
        $new_qty = $item['quantity'] - 1;
        $new_subtotal = $new_qty * $item['price'];
        mysqli_query($con, "UPDATE order_items SET quantity='$new_qty', subtotal='$new_subtotal' WHERE id='$item_id'");
    }
}

// AUTO-UPDATE ORDER STATUS
$items_status_check = mysqli_query($con, "SELECT item_status FROM order_items WHERE order_id='$order_id'");
$pending = $completed = $canceled = 0;
while($row = mysqli_fetch_assoc($items_status_check)) {
    if ($row['item_status'] == 'pending') $pending++;
    elseif ($row['item_status'] == 'completed') $completed++;
    elseif ($row['item_status'] == 'canceled') $canceled++;
}

if ($pending > 0) $new_status = 'preparing';
elseif ($completed > 0 && $pending == 0) $new_status = 'completed';
elseif ($canceled > 0 && $completed == 0 && $pending == 0) $new_status = 'canceled';
else $new_status = 'pending';

mysqli_query($con, "UPDATE orders SET order_status='$new_status' WHERE id='$order_id'");

// GET ORDER INFO
$order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM orders WHERE id='$order_id'"));

// GET ORDER ITEMS
$items = mysqli_query($con, "SELECT * FROM order_items WHERE order_id='$order_id'");
?>

<!DOCTYPE html>
<html data-bs-theme="light">
<head>
    <title>Kitchen - Order #<?= $order_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="kitchen.css">
</head>
<body class="kitchen-body">

<div class="container my-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>🍳 Order #<?= $order_id ?> - Table <?= $order['table_no'] ?></h3>
        <div class="d-flex gap-2">
            <button class="btn" id="toggleTheme">👁️</button>
            <a href="kitchen.php" class="btn btn-secondary fw-bold">⬅ Back to Orders</a>
        </div>
    </div>

    <!-- CUSTOMER INFO -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p class="mb-1"><strong>Customer:</strong> <?= $order['customer_name'] ?></p>
            <p class="mb-1"><strong>Phone:</strong> <?= $order['phone'] ?></p>
            <p class="mb-0"><strong>Order Status:</strong> 
                <span class="badge 
                    <?= $order['order_status']=='pending'?'bg-warning':
                        ($order['order_status']=='preparing'?'bg-primary':
                        ($order['order_status']=='completed'?'bg-success':'bg-danger')) ?>">
                    <?= ucfirst($order['order_status']) ?>
                </span>
            </p>
        </div>
    </div>

    <!-- ORDER ITEMS -->
    <div class="row g-3">
        <?php while($item = mysqli_fetch_assoc($items)) { ?>
            <div class="col-md-6">
                <div class="card shadow-sm kitchen-card h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-2"><?= $item['menu_name'] ?></h5>
                        <p class="mb-1"><strong>Price:</strong> RM <?= number_format($item['price'],2) ?></p>
                        <p class="mb-1"><strong>Quantity:</strong> 
                            <?php if($item['item_status']=='pending') { ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button class="btn btn-sm btn-secondary">-</button>
                                </form>
                                <?= $item['quantity'] ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </form>
                            <?php } else { echo $item['quantity']; } ?>
                        </p>
                        <p class="mb-2"><strong>Subtotal:</strong> RM <?= number_format($item['subtotal'],2) ?></p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            <span class="badge 
                                <?= $item['item_status']=='pending'?'bg-warning':
                                    ($item['item_status']=='completed'?'bg-success':'bg-danger') ?>">
                                <?= ucfirst($item['item_status']) ?>
                            </span>
                        </p>

                        <!-- ACTION BUTTONS -->
                        <?php if($item['item_status']=='pending') { ?>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="complete">
                                    <button class="btn btn-sm btn-success">✅</button>
                                </form>

                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <button class="btn btn-sm btn-danger">❌</button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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
