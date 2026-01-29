<?php
// login.php
session_start();
include("includes/db.php");

$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Intentionally vulnerable query (no prepared statements)
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);

        // Session fixation: not regenerating session id
        $_SESSION['user'] = $row['username'];

        // Insecure cookie (no HttpOnly/Secure flags intentionally)
        setcookie("UID", $row['id'], time()+3600, "/");

        header("Location: dashboard.php");
        exit;
    } else {
        // Generic message (keeps UI realistic)
        $message = "Invalid username or password.";
    }
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login - 63sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<?php include("includes/header.php"); ?>

<main class="max-w-md mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold">Sign in to your account</h2>
    <?php if ($message): ?>
      <div class="mt-4 p-3 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-200 rounded">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="mt-4 space-y-4">
      <div>
        <label class="block text-sm">Username</label>
        <input name="username" required class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
      </div>
      <div>
        <label class="block text-sm">Password</label>
        <input name="password" type="password" required class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
      </div>

      <div class="flex items-center justify-between">
        <div class="text-sm">
          <a href="register.php" class="underline">Create an account</a>
        </div>
        <button type="submit" name="login" class="px-4 py-2 bg-blue-600 text-white rounded">Sign in</button>
      </div>
    </form>
  </div>
</main>

</body>
</html>

