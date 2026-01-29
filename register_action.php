<?php
include("includes/header.php");
include("includes/db.php");

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if username already exists
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Username already exists! Try another.'); window.location='register.php';</script>";
    exit;
}

// Insert new user
$query = "INSERT INTO users (username, password, email) 
          VALUES ('$username', '$password', '$email')";

if (mysqli_query($conn, $query)) {

    // OPTIONAL: create an account automatically
    $user_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO accounts (user_id, balance) VALUES ($user_id, 1000.00)");

    echo "<script>alert('Registration successful! You can now login.'); window.location='login.php';</script>";
} else {
    echo "<script>alert('Error while registering.'); window.location='register.php';</script>";
}
?>
