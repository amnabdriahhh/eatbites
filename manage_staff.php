<?php
session_start();

// Only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites") or die(mysqli_connect_error());

// Handle role update
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];
    
    mysqli_query($con, "UPDATE users SET status='$new_status' WHERE id='$user_id'");
    header("Location: manage_staff.php");
    exit;
}

// Handle delete staff
if (isset($_GET['delete_staff'])) {
    $user_id = $_GET['delete_staff'];
    
    // Prevent deleting yourself - check by email since session doesn't store user_id
    $current_user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $user_to_delete = mysqli_query($con, "SELECT email FROM users WHERE id='$user_id'");
    $user_data = mysqli_fetch_assoc($user_to_delete);
    
    if ($user_data && $user_data['email'] != $current_user_email) {
        mysqli_query($con, "DELETE FROM users WHERE id='$user_id'");
    }
    header("Location: manage_staff.php");
    exit;
}

// Get all staff members (only admin and kitchen)
$staff = mysqli_query($con, "SELECT * FROM users WHERE status IN ('admin', 'kitchen') ORDER BY id ASC") or die(mysqli_error($con));

// Count staff by role
$stats_query = mysqli_query($con, "SELECT 
    COUNT(*) as total_staff,
    SUM(CASE WHEN status = 'admin' THEN 1 ELSE 0 END) as admin_count,
    SUM(CASE WHEN status = 'kitchen' THEN 1 ELSE 0 END) as kitchen_count
FROM users WHERE status IN ('admin', 'kitchen')") or die(mysqli_error($con));

$stats = mysqli_fetch_assoc($stats_query);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - EatBites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-red: #8B0000;
            --yellow: #FFD700;
            --white: #FFFFFF;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            background-color: var(--dark-red);
            height: 70px;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: var(--white) !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            background-color: var(--yellow);
            color: var(--dark-red) !important;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        /* Footer */
        .footer {
            background-color: var(--dark-red);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        /* Overview Cards */
        .overview-card {
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .overview-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .overview-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .overview-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .card-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .card-admin { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .card-kitchen { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }

        .page-header {
            background: linear-gradient(135deg, var(--dark-red) 0%, #dc143c 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        [data-bs-theme="dark"] .table-container {
            background: #212529;
        }

        [data-bs-theme="dark"] .overview-card {
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
        }

        /* Circular Theme Toggle Button */
        #toggleTheme {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            padding: 0;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
        }

        #toggleTheme:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Role select styling */
        .role-select {
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .role-select:focus {
            border-color: var(--dark-red);
            outline: none;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="admin.php">
            <img src="img/EatBites.png" alt="EatBites Logo" width="40" class="me-2">
            EatBites Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_staff.php">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item ms-3">
                    <button class="btn btn-warning" id="toggleTheme">👁️</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="mb-0">👥 Staff Management</h1>
        <p class="mb-0 mt-2">Manage staff members and their roles</p>
    </div>

    <!-- OVERVIEW SUMMARY SECTION -->
    <div class="row text-center">
        <!-- Total Staff -->
        <div class="col-md-4">
            <div class="overview-card card-total">
                <h3><?php echo $stats['total_staff']; ?></h3>
                <p>Total Staff</p>
            </div>
        </div>

        <!-- Admin Count -->
        <div class="col-md-4">
            <div class="overview-card card-admin">
                <h3><?php echo $stats['admin_count']; ?></h3>
                <p>Administrators</p>
            </div>
        </div>
        <!-- Kitchen Staff Count -->
        <div class="col-md-4">
            <div class="overview-card card-kitchen">
                <h3><?php echo $stats['kitchen_count']; ?></h3>
                <p>Kitchen Staff</p>
            </div>
        </div>
    </div>

    <!-- STAFF TABLE -->
    <h3 class="mb-3 mt-4">All Staff Members</h3>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                mysqli_data_seek($staff, 0);
                while ($member = mysqli_fetch_assoc($staff)) { 
                ?>
                    <tr>
                        <td><strong class="text-primary">#<?php echo $member['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($member['name']); ?></td>
                        <td><?php echo htmlspecialchars($member['email']); ?></td>
                        <td><?php echo htmlspecialchars($member['phone']); ?></td>
                        <td><small><?php echo htmlspecialchars($member['address']); ?></small></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="user_id" value="<?php echo $member['id']; ?>">
                                <select name="new_status" class="role-select" onchange="this.form.submit()">
                                    <option value="admin" <?php echo $member['status'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="kitchen" <?php echo $member['status'] == 'kitchen' ? 'selected' : ''; ?>>Kitchen</option>
                                </select>
                                <input type="hidden" name="update_role" value="1">
                            </form>
                        </td>
                        <td>
                            <?php 
                            // Check if this is the current logged-in user by email
                            $is_current_user = (isset($_SESSION['email']) && $member['email'] == $_SESSION['email']);
                            if (!$is_current_user) { 
                            ?>
                                <a href="manage_staff.php?delete_staff=<?php echo $member['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this staff member?')">
                                    <small>Delete</small>
                                </a>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Current User</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
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
    
    // Load saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
    
    toggleBtn.addEventListener('click', () => {
        const html = document.documentElement;
        const current = html.getAttribute('data-bs-theme');
        const newTheme = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
</script>
</body>
</html>
<?php
mysqli_close($con);
?>
