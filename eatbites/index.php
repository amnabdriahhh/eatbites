<html>

<header>
<title>Log In</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</header>

<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

 <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-center mb-4">Login Account</h3>

                    <form name="login" method="post" action="login_process.php">
                        <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email"
                                name="email" placeholder="Fill in your email required">
                                </div>
                        <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password"
                                name="password" placeholder="Fill in your password required">
                                </div>

                                <!--submit button-->

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                                <p class="text-center">
                                    Not Registered? <a href="registration.php">Register Here</a>

                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>


</body>
</html>