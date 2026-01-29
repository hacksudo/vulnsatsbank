<?php
session_start();
include("../includes/db.php");  // correct path

if (!isset($_SESSION['user'])) {
    die("Not logged in");
}

$user  = $_SESSION['user'];
$email = $_POST['email'];

// CSRF vulnerable update
$sql = "UPDATE users SET email='$email' WHERE username='$user'";
mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
  <title>Email Updated</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white shadow p-6 rounded">

  <h2 class="text-xl font-semibold mb-4">Email Updated</h2>

  <p>Your new email is: <b><?php echo htmlspecialchars($email); ?></b></p>

  <a href="../dashboard.php" class="block mt-4 w-full text-center bg-blue-600 text-white p-2 rounded">
    Back to Dashboard
  </a>

</div>
</body>
</html>
