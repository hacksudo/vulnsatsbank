<?php
// edit_profile.php
include("includes/init.php"); 
include("includes/header.php");

// --------------------------------------------
// 1) Get logged-in user ID
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
// 2) IDOR: attacker can override uid in URL
// --------------------------------------------
$uid = intval($_GET['uid'] ?? $logged_uid);

// --------------------------------------------
// 3) Fetch profile (NO access control)
// --------------------------------------------
$sql = "SELECT id, username, email, phone FROM users WHERE id = $uid LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) === 0) {
    die("<div class='p-6 text-red-600'>User not found (ID $uid).</div>");
}

$user = mysqli_fetch_assoc($res);

// --------------------------------------------
// 4) Update profile (NO CSRF, NO validation)
// --------------------------------------------
if (isset($_POST['update'])) {

    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL Injection + IDOR intentionally kept vulnerable
    $update = "UPDATE users SET email='$email', phone='$phone' WHERE id=$uid";
    mysqli_query($conn, $update);

    echo "<div class='p-4 bg-green-200 text-green-800'>Profile updated!</div>";

    // Reload data
    $res = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($res);
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Profile - 63Sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-100 min-h-screen">

<div class="max-w-xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h1 class="text-xl font-semibold mb-4">Edit Profile </h1>

    <p class="text-sm mb-4 text-gray-500 dark:text-gray-300">
      Editing profile for: <strong>User ID <?php echo $uid; ?></strong>
    </p>

    <form method="POST" class="space-y-4">

      <div>
        <label class="block text-sm mb-1">Username</label>
        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled
               class="w-full p-2 rounded bg-gray-200 dark:bg-gray-700">
      </div>

      <div>
        <label class="block text-sm mb-1">Email</label>
        <input name="email"
               value="<?php echo htmlspecialchars($user['email']); ?>"
               class="w-full p-2 rounded bg-gray-100 dark:bg-gray-700 border">
      </div>

      <div>
        <label class="block text-sm mb-1">Phone</label>
        <input name="phone"
               value="<?php echo htmlspecialchars($user['phone']); ?>"
               class="w-full p-2 rounded bg-gray-100 dark:bg-gray-700 border">
      </div>

      <button name="update"
              class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
        Save Changes
      </button>

    </form>

  </div>
</div>

</body>
</html>
