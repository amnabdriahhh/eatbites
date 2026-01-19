<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['action'])) {
    $id = $_POST['menu_id'];

    if ($_POST['action'] === 'increase') {
        $_SESSION['cart'][$id]['quantity']++;
    }

    if ($_POST['action'] === 'decrease') {
        $_SESSION['cart'][$id]['quantity']--;
        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    if ($_POST['action'] === 'remove') {
        unset($_SESSION['cart'][$id]);
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>EatBites | Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="homepage.php">
      <img src="img/EatBites.png" alt="EatBites Logo" width="40" class="me-2">
      EatBites
    </a>

    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navMenu"
      aria-controls="navMenu"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user_menu.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="cart.php">
            Cart (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)
          </a>
        </li>
        <li class="nav-item ms-3">
          <button class="btn" id="toggleTheme">👁️</button>
        </li>
      </ul>
    </div>
  </div>
</nav>



<div class="container cart-container">

    <h2 class="text-center mb-4">Your Cart</h2>

    <?php if (empty($_SESSION['cart'])) { ?>
        <div class="alert alert-warning text-center">
            Your cart is empty.
        </div>
        <div class="text-center">
            <a href="user_menu.php" class="btn btn-main">Back to Menu</a>
        </div>
    <?php } else { ?>

    <div class="table-wrapper">
        <table class="table text-center align-middle">
            <thead>
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
                    <td><?= $item['name']; ?></td>
                    <td><?= number_format($item['price'], 2); ?></td>

                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="menu_id" value="<?= $id; ?>">
                            <input type="hidden" name="action" value="decrease">
                            <button class="qty-btn">−</button>
                        </form>

                        <span class="mx-2 fw-bold"><?= $item['quantity']; ?></span>

                        <form method="post" class="d-inline">
                            <input type="hidden" name="menu_id" value="<?= $id; ?>">
                            <input type="hidden" name="action" value="increase">
                            <button class="qty-btn">+</button>
                        </form>
                    </td>

                    <td><?= number_format($subtotal, 2); ?></td>

                    <td>
                        <form method="post">
                            <input type="hidden" name="menu_id" value="<?= $id; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button class="btn btn-danger btn-sm rounded-pill">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th colspan="2">RM <?= number_format($total, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="user_menu.php" class="btn btn-main">⬅ Back to Menu</a>
        <a href="checkout.php" class="btn btn-main">Proceed to Checkout</a>
    </div>

    <?php } ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="mb-0">© 2026 EatBites. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('toggleTheme').onclick = function () {
    const html = document.documentElement;
    html.setAttribute(
        'data-bs-theme',
        html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark'
    );
};
</script>

</body>
</html>
