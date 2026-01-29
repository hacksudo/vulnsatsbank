<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: ../login.php"); exit; }
?>
<!doctype html>
<html>
<head>
  <title>Change Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white shadow p-6 rounded">

  <h2 class="text-xl font-semibold mb-4">Update Password</h2>

  <form action="process_password.php" method="POST">
      <label class="font-medium">New Password</label>
      <input name="password" class="w-full border p-2 rounded mt-1" placeholder="Enter new password">

      <button class="w-full bg-red-600 text-white p-2 rounded mt-4">
        Change Password
      </button>
  </form>

</div>
</body>
</html>
