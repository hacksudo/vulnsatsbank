<?php
// dashboard.php
session_start();
include("includes/db.php");
include("includes/header.php");

$user = $_SESSION['user'] ?? null;
$user_id = 0;

// Fetch user ID (intentionally weak session validation for lab)
if ($user) {
    $u = mysqli_real_escape_string($conn, $user);
    $res = mysqli_query($conn, "SELECT id FROM users WHERE username='$u' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $user_id = intval($row['id']);
    }
}

// Fetch balance from accounts table
$bal = 0;
$bres = mysqli_query($conn, "SELECT balance FROM accounts WHERE user_id = $user_id");
if ($bres && mysqli_num_rows($bres) > 0) {
    $brow = mysqli_fetch_assoc($bres);
    $bal = $brow['balance'];
}

?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8">
  <title>Dashboard - 63Sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">

<div class="max-w-4xl mx-auto p-6">

  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h1 class="text-xl font-semibold">Welcome, <?php echo htmlspecialchars($user); ?></h1>

    <div class="mt-4">
      <p class="text-lg font-medium">Account Balance:</p>
      <p class="text-2xl font-bold mt-1">₹ <?php echo htmlspecialchars($bal); ?></p>
    </div>

    <!-- MAIN BANK FEATURES -->
    <div class="grid grid-cols-2 gap-4 mt-6">

      <a href="transfer.php" class="block bg-blue-600 text-white p-3 rounded text-center">
        Make Transfer
      </a>

      <a href="statement.php" class="block bg-green-600 text-white p-3 rounded text-center">
        View Statement
      </a>

      <a href="upload.php" class="block bg-purple-600 text-white p-3 rounded text-center">
        Upload File
      </a>

      <a href="blog.php" class="block bg-yellow-500 text-white p-3 rounded text-center">
        Blog
      </a>

      <!-- ⭐ NEW BUTTON: View Profile -->
      <a href="view_profile.php" class="block bg-indigo-600 text-white p-3 rounded text-center">
        View Profile
      </a>

    </div>

    <!-- ACCOUNT SETTINGS (FOR CSRF LAB) -->
    <div class="mt-10">
      <h2 class="text-lg font-semibold mb-3">Account Settings</h2>

      <div class="grid grid-cols-2 gap-4">

        <a href="settings/change_email.php" class="block bg-indigo-600 text-white p-3 rounded text-center">
          Change Email
        </a>

        <a href="settings/change_password.php" class="block bg-red-600 text-white p-3 rounded text-center">
          Change Password
        </a>

      </div>
    </div>

  </div>
</div>

</body>
</html>
