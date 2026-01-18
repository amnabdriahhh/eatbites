<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "eatbites") 
    or die(mysqli_connect_error());

// ADD TO CART LOGIC
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['menu_id'];
    $name = $_POST['menu_name'];
    $price = $_POST['price'];

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    } else {
        $_SESSION['cart'][$id]['quantity']++;
    }
}

// FILTER LOGIC
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

if ($category == 'all') {
    $sql = "SELECT * FROM menu WHERE status='available'";
} else {
    $sql = "SELECT * FROM menu 
            WHERE category='$category' AND status='available'";
}

$result = mysqli_query($con, $sql) or die(mysqli_error($con));
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <!-- CART BUTTON -->
    <div class="text-end mb-3">
        <a href="cart.php" class="btn btn-warning">
            🛒 View Cart
        </a>
    </div>

    <h2 class="text-center mb-4">Food & Beverage Menu</h2>

    <!-- CATEGORY FILTER -->
    <div class="text-center mb-4">
        <a href="user_menu.php?category=all" class="btn btn-secondary">All</a>
        <a href="user_menu.php?category=western" class="btn btn-outline-primary">Western</a>
        <a href="user_menu.php?category=local" class="btn btn-outline-primary">Local</a>
        <a href="user_menu.php?category=desserts" class="btn btn-outline-primary">Desserts</a>
        <a href="user_menu.php?category=sides" class="btn btn-outline-primary">Sides</a>
        <a href="user_menu.php?category=drinks" class="btn btn-outline-primary">Drinks</a>
    </div>

    <!-- MENU LIST -->
    <div class="row">

    <?php while ($menu = mysqli_fetch_assoc($result)) { ?>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">

                <img src="images/<?php echo $menu['image']; ?>" 
                     class="card-img-top"
                     style="height:200px; object-fit:cover;">

                <div class="card-body">
                    <h5 class="card-title"><?php echo $menu['name']; ?></h5>
                    <p class="card-text"><?php echo $menu['description']; ?></p>
                    <p><strong>RM <?php echo number_format($menu['price'], 2); ?></strong></p>

                    <form method="post">
                        <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                        <input type="hidden" name="menu_name" value="<?php echo $menu['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $menu['price']; ?>">

                        <button type="submit" name="add_to_cart" class="btn btn-success w-100">
                            Add to Cart
                        </button>
                    </form>
                </div>

            </div>
        </div>

    <?php } ?>

    </div>
</div>

</body>
</html>
