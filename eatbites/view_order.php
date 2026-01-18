<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

$order_id = $_GET['id'];

$order = mysqli_fetch_assoc(
    mysqli_query($con, "SELECT * FROM orders WHERE id='$order_id'")
);

$items = mysqli_query($con,
    "SELECT * FROM order_items WHERE order_id='$order_id'"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3 class="mb-3">📦 Order #<?php echo $order_id; ?></h3>

    <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
    <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
    <p><strong>Table:</strong> <?php echo $order['table_no']; ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst($order['order_status']); ?></p>
    <p><strong>Time:</strong> <?php echo $order['order_time']; ?></p>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Menu</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($item = mysqli_fetch_assoc($items)) { ?>
            <tr>
                <td><?php echo $item['menu_name']; ?></td>
                <td><?php echo number_format($item['price'],2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['subtotal'],2); ?></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <h5>Total: RM <?php echo number_format($order['total_price'],2); ?></h5>

    <a href="admin.php" class="btn btn-secondary mt-3">⬅ Back</a>

</div>

</body>
</html>
