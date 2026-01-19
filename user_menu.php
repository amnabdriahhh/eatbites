<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "eatbites") 
    or die(mysqli_connect_error());

// ADD TO CART LOGIC
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['menu_id'];
    $name = $_POST['menu_name'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $qty
        ];
    } else {
        $_SESSION['cart'][$id]['quantity'] += $qty;
    }
}

$category = $_GET['category'] ?? 'all';
$sql = ($category == 'all')
    ? "SELECT * FROM menu WHERE status='available'"
    : "SELECT * FROM menu WHERE category='$category' AND status='available'";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html data-bs-theme="light">
<head>
    <title>User Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="user_menu.css">
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
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">
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


<!-- BANNER CAROUSEL -->
<div class="container carousel-wrapper">
    <div id="menuCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/banner1.png" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item">
                <img src="img/banner2.png" class="d-block w-100" alt="">
            </div>
        </div>
    </div>
</div>


<!-- CATEGORY FILTER -->
<div class="text-center mt-4 mb-4">
    <a href="?category=all" class="btn category-btn">All</a>
    <a href="?category=western" class="btn category-btn">Western</a>
    <a href="?category=local" class="btn category-btn">Local</a>
    <a href="?category=desserts" class="btn category-btn">Desserts</a>
    <a href="?category=sides" class="btn category-btn">Sides</a>
    <a href="?category=drinks" class="btn category-btn">Drinks</a>
</div>

<div class="container">
    <div class="row">
    <?php while ($menu = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="menu/<?php echo $menu['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $menu['name']; ?></h5>
                    <p><?php echo $menu['description']; ?></p>
                    <p class="fw-bold">RM <?php echo number_format($menu['price'], 2); ?></p>

<form method="post">
    <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
    <input type="hidden" name="menu_name" value="<?php echo $menu['name']; ?>">
    <input type="hidden" name="price" value="<?php echo $menu['price']; ?>">

    <div class="qty-inline">
        <button type="button" class="qty-btn" onclick="this.nextElementSibling.stepDown()">−</button>
        <input type="number" name="quantity" value="1" min="1" class="form-control qty-input">
        <button type="button" class="qty-btn" onclick="this.previousElementSibling.stepUp()">+</button>
    </div>

    <button type="submit" name="add_to_cart" class="btn btn-main w-100">Add to Cart</button>
</form>

                </div>
            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle light/dark color modes
    const toggleBtn = document.getElementById('toggleTheme');
    toggleBtn.addEventListener('click', () => {
        const html = document.documentElement;
        const current = html.getAttribute('data-bs-theme');
        html.setAttribute('data-bs-theme', current === 'light' ? 'dark' : 'light');
    });
</script>
</body>
</html>
