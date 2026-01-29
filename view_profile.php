<?php
include("includes/init.php");
include("includes/header.php");

// --------------------------------------------
// GET LOGGED-IN USER ID
// --------------------------------------------
$logged_user = $_SESSION['user'] ?? null;
$logged_uid = 0;

if ($logged_user) {
    $u = mysqli_real_escape_string($conn, $logged_user);
    $r = mysqli_query($conn, "SELECT id FROM users WHERE username='$u' LIMIT 1");
    if ($r && mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_assoc($r);
        $logged_uid = intval($row['id']);
    }
}

// --------------------------------------------
// IDOR: attacker can override uid
// --------------------------------------------
$uid = intval($_GET['uid'] ?? $logged_uid);

// --------------------------------------------
// FETCH PROFILE (NO ACCESS CONTROL)
// --------------------------------------------
$sql = "SELECT id, username, email, phone, created_at FROM users WHERE id = $uid LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) === 0) {
    die("<div class='p-6 text-red-500 text-lg'>User not found (ID $uid)</div>");
}

$user = mysqli_fetch_assoc($res);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>View Profile - 63Sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">

<div class="max-w-xl mx-auto p-6 mt-6">
  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h1 class="text-2xl font-semibold mb-4">Profile Details</h1>

    <p class="text-sm text-gray-500 dark:text-gray-300 mb-4">
      Viewing profile for <strong>User ID: <?php echo $uid; ?></strong>
    </p>

    <div class="space-y-3">

      <div>
        <label class="text-sm text-gray-500">Username</label>
        <p class="text-lg"><?php echo htmlspecialchars($user['username']); ?></p>
      </div>

      <div>
        <label class="text-sm text-gray-500">Email</label>
        <p class="text-lg"><?php echo htmlspecialchars($user['email']); ?></p>
      </div>

      <div>
        <label class="text-sm text-gray-500">Phone</label>
        <p class="text-lg"><?php echo htmlspecialchars($user['phone']); ?></p>
      </div>

      <div>
        <label class="text-sm text-gray-500">Created At</label>
        <p class="text-lg"><?php echo htmlspecialchars($user['created_at']); ?></p>
      </div>

    </div>

    <div class="mt-6">
      <a href="edit_profile.php?uid=<?php echo $uid; ?>"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Edit This Profile
      </a>
    </div>

  </div>
</div>

</body>
</html>
