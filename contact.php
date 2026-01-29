<?php
// contact.php
// Path: /contact.php
session_start();
include("includes/db.php");
include("includes/header.php");

$message = "";
if (isset($_POST['send'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $ip = $_POST['ip'] ?? ''; // user-supplied host / ip used in ping

    // Intentionally vulnerable to OS command injection
    // On submit the app runs ping which can be abused when crafted input is supplied
    $cmd = "ping -c 3 " . $ip;
    $output = [];
    @exec($cmd, $output);

    $message = "Message sent. Ping result: <pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contact - 63sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-lg font-semibold">Contact Support</h1>

    <?php if ($message): ?>
      <div class="mt-3 p-3 rounded bg-gray-50 dark:bg-gray-700 text-sm"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4 space-y-4">
      <div>
        <label class="block text-sm">Your name</label>
        <input name="name" class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
      </div>

      <div>
        <label class="block text-sm">Email</label>
        <input name="email" type="email" class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
      </div>

      <div>
        <label class="block text-sm">Host/IP (for diagnostics)</label>
        <input name="ip" placeholder="example.com or 8.8.8.8" class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
        <div class="text-xs text-gray-500 mt-1">We may run a network check to assist.</div>
      </div>

      <div class="flex justify-end">
        <button type="submit" name="send" class="px-4 py-2 bg-blue-600 text-white rounded">Send</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
