<?php

$name = ($_POST["name"] );
$phone = ($_POST["phone"] );
$email = ($_POST["email"] );
$address = ($_POST["address"] );
$passwordRaw = ($_POST['password']);
$status = $_POST['status'];

$con = mysqli_connect ("localhost", "root" , "", "eatbites") or die 
(mysqli_connect_errno ($con));

$passwordHash = password_hash($passwordRaw, PASSWORD_DEFAULT);

mysqli_query ($con , "insert into users (name, phone, email, address, password_hash, status)
values ('$name', '$phone', '$email','$address', '$passwordHash', '$status')") or die (mysqli_error($con));

echo "Your registration has been successful!";
header("location: index.php");
mysqli_close ($con);

?>