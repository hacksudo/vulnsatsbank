<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    die("Not logged in");
}

$user = $_SESSION['user'];
$pass = $_POST['password'];

$sql = "UPDATE users SET password='$pass' WHERE username='$user'";
mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <title>Password Updated</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white shadow p-6 rounded">

  <h2 class="text-xl font-semibold mb-4">Password Updated</h2>

  <p>Your password has been successfully changed.</p>

  <a href="../dashboard.php" class="block mt-4 w-full text-center bg-red-600 text-white p-2 rounded">
    Back to Dashboard
  </a>

</div>
</body>
</html>
