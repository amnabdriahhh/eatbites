<html>
<head>
<title>Log In</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card auth-card shadow-lg">

                <div class="auth-logo">
                    <img src="images/logo.png" alt="Logo">
                </div>

                <div class="card-body">
                    <h3 class="text-center mb-4">Login Account</h3>

                    <form method="post" action="login_process.php">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-auth">Login</button>
                        </div>

                        <p class="text-center mb-0">
                            Not Registered? <a href="registration.php">Register Here</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="auth-footer">
    <p class="mb-0">2026 EatBites. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
