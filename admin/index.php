<?php
session_start();
include("../includes/db.php");

$msg = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // intentionally vulnerable SQL for admin lab
    $sql = "SELECT * FROM admins 
            WHERE username='$username' 
            AND password='$password' 
            LIMIT 1";

    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['admin_user'] = $row['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $msg = "Invalid admin credentials.";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Admin Login</title>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
<div class="max-w-md mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded p-6">
    <h2 class="text-xl font-bold">Admin Login</h2>

    <?php if ($msg): ?>
      <div class="mt-2 bg-red-200 text-red-700 p-2 rounded"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4 space-y-4">
      <input name="username" placeholder="Admin Username"
        class="w-full border px-3 py-2 rounded bg-gray-50 dark:bg-gray-700" />
      <input name="password" placeholder="Password" type="password"
        class="w-full border px-3 py-2 rounded bg-gray-50 dark:bg-gray-700" />
      <button name="login"
        class="px-4 py-2 bg-blue-600 text-white rounded w-full">Login</button>
    </form>
  </div>
</div>
</body>
</html>
