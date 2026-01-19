<!DOCTYPE html>
<html data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Order Success | EatBites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css"> <!-- Link to your theme CSS -->
</head>
<body>

<div class="container mt-5 text-center">

    <!-- Logo -->
    <div class="mb-4">
        <img src="img/EatBitess.jpg" alt="EatBites Logo" width="100">
    </div>

    <!-- Success Message -->
    <h2 class="text-warning">✅ Order Placed Successfully!</h2>
    <p>Your order has been sent to the kitchen.</p>

    <!-- Back Button -->
 <a href="user_menu.php" class="btn btn-main mt-3">Back to Menu</a>


</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Light/Dark Mode Toggle -->
<script>
    // Optional: you can add a button if needed for toggle
    const html = document.documentElement;

    // Example: toggle by clicking anywhere on page
    html.addEventListener('dblclick', () => {
        html.setAttribute(
            'data-bs-theme',
            html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark'
        );
    });
</script>

</body>
</html>
