<?php
session_start();

// SECURITY: Only kitchen can access
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'kitchen') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

// UPDATE ORDER STATUS
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    mysqli_query($con,
        "UPDATE orders SET order_status='$status' WHERE id='$order_id'"
    ) or die(mysqli_error($con));
}

// GET ALL ORDERS
$result = mysqli_query($con,
    "SELECT * FROM orders ORDER BY order_time DESC"
) or die(mysqli_error($con));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitchen Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🍳 Kitchen Orders</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Table No</th>
                <th>Time</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($order = mysqli_fetch_assoc($result)) { ?>

            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['table_no']; ?></td>
                <td><?php echo $order['order_time']; ?></td>
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

                <td>
                    <form method="post" class="d-flex gap-1 justify-content-center">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

                        <button name="update_status" value="1"
                                class="btn btn-sm btn-warning"
                                formaction=""
                                onclick="this.form.status.value='pending'">
                            Pending
                        </button>

                        <button name="update_status" value="1"
                                class="btn btn-sm btn-primary"
                                onclick="this.form.status.value='preparing'">
                            Preparing
                        </button>

                        <button name="update_status" value="1"
                                class="btn btn-sm btn-success"
                                onclick="this.form.status.value='completed'">
                            Completed
                        </button>

                        <button name="update_status" value="1"
                                class="btn btn-sm btn-danger"
                                onclick="this.form.status.value='canceled'">
                            Canceled
                        </button>

                        <input type="hidden" name="status">
                    </form>
                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>
