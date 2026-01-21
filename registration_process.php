<?php
session_start();

// Connect to database
$con = mysqli_connect("localhost", "root", "", "eatbites");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize input
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $address  = mysqli_real_escape_string($con, $_POST['address']);
    $password = $_POST['password'];
    $status   = $_POST['status'] ?? 'kitchen'; // default to 'kitchen' if not set

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($password) || empty($status)) {
        die("All fields are required. Please go back and fill in all fields.");
    }

    // Check if email already exists
    $check_email = mysqli_query($con, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        die("This email is already registered. Please use a different email.");
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (name, phone, email, address, password_hash, status)
            VALUES ('$name', '$phone', '$email', '$address', '$password_hash', '$status')";

    if (mysqli_query($con, $sql)) {
        // Registration successful — redirect to login
        header("Location: index.php");
        exit;
    } else {
        die("Error: " . mysqli_error($con));
    }
} else {
    // If accessed directly without POST
    header("Location: registration.php");
    exit;
}

// Close connection
mysqli_close($con);
?>
