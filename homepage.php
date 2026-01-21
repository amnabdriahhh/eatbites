<?php session_start(); ?>
<!DOCTYPE html>
<html data-bs-theme="light">
<head>
    <title>EatBites Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
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
          <a class="nav-link active" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user_menu.php">Menu</a>
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

<!-- HERO BANNER -->
<section id="home" class="hero-banner">
    <div>
        <a href="user_menu.php" class="btn btn-order mt-4">Order Now</a>
    </div>
</section>

<!-- BEST SELLERS -->
<section class="best-seller">
    <div class="container">
        <h2 class="text-center mb-5">Our Best Sellers</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="user_menu.php" style="text-decoration:none;">
                <div class="card card-best">
                    <img src="menu/nasilemak.jpg" class="card-img-top" alt="Nasi Lemak">
                    <div class="card-body text-center">
                        <h5 class="card-title">Nasi Lemak</h5>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="user_menu.php" style="text-decoration:none;">
                <div class="card card-best">
                    <img src="menu/chicken.jpg" class="card-img-top" alt="Chicken Chop">
                    <div class="card-body text-center">
                        <h5 class="card-title">Chicken Chop</h5>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="user_menu.php" style="text-decoration:none;">
                <div class="card card-best">
                    <img src="menu/tiramisu.jpg" class="card-img-top" alt="Tiramisu">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tiramisu</h5>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT US -->
<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">About Us</h2>
        <div class="about-box">
            <p><strong>Who We Are:</strong><br>
            EatBites is a modern café and restaurant serving a wide variety of Western and local favorites, desserts, sides, and beverages. From crispy fish and chips and hearty burgers to traditional nasi lemak, laksa, and sweet pavlova, we aim to satisfy every craving in a cozy and inviting atmosphere.</p>

            <p><strong>Our Story:</strong><br>
            Founded in 2019, EatBites started as a small neighborhood café with the goal of bringing quality, affordable meals to our community. Over the years, we have grown into a go-to spot for families, friends, and food lovers seeking delicious meals and refreshing drinks in a comfortable environment.</p>

            <p><strong>Our Mission & Values:</strong><br>
            We are committed to fresh ingredients, excellent customer service, and consistency in taste. Every dish is prepared with care, ensuring that our customers enjoy the best flavors, presentation, and experience every time.</p>

            <p><strong>Our Trademark:</strong><br>
            EatBites is known for our signature burgers, crispy fries, and rich desserts, which have become crowd favorites. Our blend of Western classics and local delights sets us apart, making every visit memorable.</p>

            <p><strong>Vision:</strong><br>
            To be a leading multi-cuisine café in the region, known for high-quality meals, friendly service, and a welcoming dining experience for all.</p>
        </div>
    </div>
</section>

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
