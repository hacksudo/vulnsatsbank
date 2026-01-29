<?php
// edit.php
// Path: /edit.php
session_start();
include("includes/db.php");
include("includes/header.php");

// This page is intentionally accessible without strict auth for lab purposes.
// It accepts ?uid= to edit other users (IDOR).
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : (isset($_COOKIE['UID']) ? intval($_COOKIE['UID']) : 0);
$message = "";

// If form submitted, update profile (no input sanitization for HTML injection)
if (isset($_POST['save'])) {
    $new_name  = $_POST['username'] ?? '';
    $new_email = $_POST['email'] ?? '';

    // Vulnerable update allowing HTML content in email/username fields
    $sql = "UPDATE users SET username = '$new_name', email = '$new_email' WHERE id = $uid";
    if (mysqli_query($conn, $sql)) {
        $message = "Profile updated.";
    } else {
        $message = "Update failed.";
    }
}

// Fetch current data
$res = mysqli_query($conn, "SELECT id, username, email FROM users WHERE id = $uid LIMIT 1");
$user = null;
if ($res && mysqli_num_rows($res) > 0) {
    $user = mysqli_fetch_assoc($res);
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Edit Profile - 63sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-lg font-semibold">Edit Profile</h1>

    <?php if ($message): ?>
      <div class="mt-3 p-2 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-200 rounded"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($user): ?>
      <form method="POST" class="mt-4 space-y-4">
        <div>
          <label class="block text-sm">Username</label>
          <!-- Username printed escaped for form default, but update allows raw content -->
          <input name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
        </div>

        <div>
          <label class="block text-sm">Email</label>
          <!-- Email printed raw here to make stored HTML visible in other pages if injected -->
          <input name="email" value="<?php echo $user['email']; ?>" class="mt-1 w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
        </div>

        <div class="flex justify-end">
          <button type="submit" name="save" class="px-4 py-2 bg-yellow-500 text-white rounded">Save</button>
        </div>
      </form>
    <?php else: ?>
      <div class="text-sm text-gray-500">User not found.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
