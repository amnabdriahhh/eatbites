<?php
session_start();

// If cart is empty, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// HANDLE ACTIONS
if (isset($_POST['action'])) {
    $id = $_POST['menu_id'];

    // INCREASE QUANTITY
    if ($_POST['action'] == 'increase') {
        $_SESSION['cart'][$id]['quantity']++;
    }

    // DECREASE QUANTITY
    if ($_POST['action'] == 'decrease') {
        $_SESSION['cart'][$id]['quantity']--;
        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // REMOVE ITEM
    if ($_POST['action'] == 'remove') {
        unset($_SESSION['cart'][$id]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">🛒 Your Cart</h2>

    <?php if (empty($_SESSION['cart'])) { ?>
        <div class="alert alert-warning text-center">
            Your cart is empty.
        </div>
        <div class="text-center">
            <a href="user_menu.php" class="btn btn-primary">Back to Menu</a>
        </div>
    <?php exit; } ?>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Menu</th>
                <th>Price (RM)</th>
                <th>Quantity</th>
                <th>Subtotal (RM)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $total = 0;

        foreach ($_SESSION['cart'] as $id => $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>

            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>

                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="menu_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button class="btn btn-sm btn-secondary">−</button>
                    </form>

                    <strong class="mx-2"><?php echo $item['quantity']; ?></strong>

                    <form method="post" style="display:inline;">
                        <input type="hidden" name="menu_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="increase">
                        <button class="btn btn-sm btn-secondary">+</button>
                    </form>
                </td>

                <td><?php echo number_format($subtotal, 2); ?></td>

                <td>
                    <form method="post">
                        <input type="hidden" name="menu_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="remove">
                        <button class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>

        <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th colspan="2">RM <?php echo number_format($total, 2); ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-between">
        <a href="user_menu.php" class="btn btn-secondary">⬅ Back to Menu</a>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>

</div>

</body>
</html>
