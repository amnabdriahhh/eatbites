<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "eatbites")
    or die(mysqli_connect_error());

// If cart empty, redirect
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: user_menu.php");
    exit;
}

// HANDLE ORDER SUBMISSION
if (isset($_POST['place_order'])) {

    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $table_no = $_POST['table_no'];

    // Calculate total price
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // INSERT INTO ORDERS
    $insertOrder = "INSERT INTO orders 
        (customer_name, phone, table_no, total_price)
        VALUES 
        ('$customer_name', '$phone', '$table_no', '$total')";

    mysqli_query($con, $insertOrder) or die(mysqli_error($con));

    // Get order ID
    $order_id = mysqli_insert_id($con);

    // INSERT ORDER ITEMS
    foreach ($_SESSION['cart'] as $menu_id => $item) {

        $menu_name = $item['name'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $subtotal = $price * $quantity;

        $insertItems = "INSERT INTO order_items
            (order_id, menu_id, menu_name, price, quantity, subtotal)
            VALUES
            ('$order_id', '$menu_id', '$menu_name', '$price', '$quantity', '$subtotal')";

        mysqli_query($con, $insertItems) or die(mysqli_error($con));
    }

    // Clear cart
    unset($_SESSION['cart']);

    // Redirect
    header("Location: order_success.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">🧾 Checkout</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="customer_name" 
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" 
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Table Number</label>
                            <input type="text" name="table_no" 
                                   class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" 
                                    name="place_order" 
                                    class="btn btn-success">
                                Place Order
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
