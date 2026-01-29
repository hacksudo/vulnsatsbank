<?php
// admin/admin_dashboard.php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_user'])) {
    // Not redirecting to login to keep the lab realistic — you may have login page link
    // But we still show a link to login
}

?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
<div class="max-w-6xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold">Admin Dashboard</h1>
    <p class="text-sm text-gray-600 mt-1">Manage users and content.</p>

    <div class="mt-4 flex gap-3">
      <a href="users.php" class="px-3 py-2 bg-gray-700 text-white rounded">Users</a>
      <a href="../blog.php" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 rounded">View Blog</a>
      <a href="../dashboard.php" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 rounded">Site Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
