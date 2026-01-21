<?php
session_start(); // MUST be first line

$con = mysqli_connect("localhost", "root", "", "eatbites") 
or die(mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $passwordRaw = $_POST["password"];

    // Get user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo "Wrong email or password!";
        exit;
    }

    $user = mysqli_fetch_assoc($result);

    // Verify password
    if (!password_verify($passwordRaw, $user['password_hash'])) {
        echo "Wrong email or password!";
        exit;
    }

    // Login success
    $_SESSION["email"] = $user["email"];
    $_SESSION["status"] = $user["status"];

    // Redirect by role
    if ($user["status"] === "admin") {
        header("Location: admin.php");
        exit;
    } 
    elseif ($user["status"] === "kitchen") {
        header("Location: kitchen.php");
        exit;
    } 
    else {
        echo "Invalid user role.";
        exit;
    }
}
?>
