<html>
<head>
    <title>Staff Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
     rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
     crossorigin="anonymous">
    <link rel="stylesheet" href="registration.css">
</head>

  <body>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!--form start here-->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-center mb-4">Register Account</h3>

                            <!--registration form-->
                            <form action="registration_process.php" method="POST">
                                <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name"
                                name="name" placeholder="Fill in your full name required">
                                </div>

                                <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone"
                                name="phone" placeholder="Fill in your phone required">
                                </div>

                                <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                name="email" placeholder="Fill in your email required">
                                </div>

                                <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address"
                                name="address" placeholder="Fill in your address required">
                                </div>

                                <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password"
                                name="password" placeholder="Fill in your password required">
                                </div>

                                <div class="mb-3">
                                <label for="status" class="form-label">Role</label>
                               <select class="form-select" id="status" name="status" required>
                                <option value="" selected disabled>Choose role</option>
                               <option value="admin">Admin</option>
                                <option value="kitchen">Kitchen</option>
                               </select>
                                </div>


                                <!--submit button-->

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>

                                <p class="text-center">
                                    Already Registered? <a href="index.php">Login Here</a>

                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>




</body>
</html>