<?php
session_start();

// SECURITY: only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

// DELETE ORDER
if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];

    mysqli_query($con, "DELETE FROM orders WHERE id='$order_id'")
        or die(mysqli_error($con));

    header("Location: admin.php");
    exit;
}

// GET ALL ORDERS
$result = mysqli_query($con,
    "SELECT * FROM orders ORDER BY order_time DESC"
) or die(mysqli_error($con));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👑 Admin – Order Management</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Table</th>
                <th>Total (RM)</th>
                <th>Status</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($order = mysqli_fetch_assoc($result)) { ?>

            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['customer_name']; ?></td>
                <td><?php echo $order['phone']; ?></td>
                <td><?php echo $order['table_no']; ?></td>
                <td><?php echo number_format($order['total_price'], 2); ?></td>

                <td>
                    <span class="badge
                        <?php
                        if ($order['order_status'] == 'pending') echo 'bg-warning';
                        elseif ($order['order_status'] == 'preparing') echo 'bg-primary';
                        elseif ($order['order_status'] == 'completed') echo 'bg-success';
                        else echo 'bg-danger';
                        ?>">
                        <?php echo ucfirst($order['order_status']); ?>
                    </span>
                </td>

                <td><?php echo $order['order_time']; ?></td>

                <td>
                    <a href="view_order.php?id=<?php echo $order['id']; ?>"
                       class="btn btn-sm btn-info mb-1">
                        View
                    </a>

                    <a href="admin.php?delete=<?php echo $order['id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this order?');">
                        Delete
                    </a>
                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>
