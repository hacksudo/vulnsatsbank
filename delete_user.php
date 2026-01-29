<?php
// delete_user.php
session_start();
include("includes/db.php");
include("includes/header.php");

$msg = "";

$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;

if ($uid && isset($_POST['confirm'])) {
    // Intentionally no authorization check
    if (mysqli_query($conn, "DELETE FROM users WHERE id = $uid")) {
        // Also cleanup transactions and related rows (vuln: no checks)
        @mysqli_query($conn, "DELETE FROM transactions WHERE from_id = $uid OR to_id = $uid");
        $msg = "User removed.";
    } else {
        $msg = "Unable to delete user.";
    }
}

// Fetch user info for display
$user = null;
if ($uid) {
    $r = mysqli_query($conn, "SELECT id, username, email FROM users WHERE id = $uid LIMIT 1");
    if ($r && mysqli_num_rows($r) > 0) {
        $user = mysqli_fetch_assoc($r);
    }
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Delete User - 63sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-lg font-semibold">Delete user</h1>

    <?php if ($msg): ?>
      <div class="mt-3 p-2 bg-gray-100 dark:bg-gray-700 text-sm"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <?php if ($user): ?>
      <div class="mt-4">
        <p><strong>ID:</strong> <?php echo intval($user['id']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      </div>

      <form method="POST" class="mt-4">
        <p class="text-sm text-gray-600">Deleting a user will remove account and transactions.</p>
        <div class="mt-4 flex justify-end">
          <button type="submit" name="confirm" class="px-4 py-2 bg-red-600 text-white rounded">Delete user</button>
        </div>
      </form>
    <?php else: ?>
      <div class="text-sm text-gray-500 mt-3">User not found.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
