<?php
// admin/users.php
session_start();
include("../includes/db.php");

$msg = "";

// Delete user (still intentionally vulnerable for lab)
if (isset($_GET['delete'])) {
    $del = intval($_GET['delete']);

    // Delete user
    mysqli_query($conn, "DELETE FROM users WHERE id = $del");

    // Delete account linked to user
    mysqli_query($conn, "DELETE FROM accounts WHERE user_id = $del");

    $msg = "User deleted.";
}

// Fetch users + account balance
$sql = "
    SELECT 
        u.id,
        u.username,
        u.email,
        a.balance
    FROM users u
    LEFT JOIN accounts a ON u.id = a.user_id
    ORDER BY u.id ASC
";

$res = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Manage Users</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
<div class="max-w-5xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-lg font-semibold">Users</h1>

    <?php if ($msg): ?>
      <div class="mt-3 p-2 bg-gray-100 dark:bg-gray-700 text-sm">
        <?php echo htmlspecialchars($msg); ?>
      </div>
    <?php endif; ?>

    <table class="w-full mt-4 text-sm border">
      <thead class="bg-gray-200 dark:bg-gray-700">
        <tr>
          <th class="p-2">ID</th>
          <th class="p-2">Username</th>
          <th class="p-2">Email</th>
          <th class="p-2">Balance</th>
          <th class="p-2">Action</th>
        </tr>
      </thead>

      <tbody>
      <?php
      if ($res && mysqli_num_rows($res) > 0) {
          while ($u = mysqli_fetch_assoc($res)) {
              echo "<tr class='border-b dark:border-gray-700'>";
              echo "<td class='p-2'>" . intval($u['id']) . "</td>";
              echo "<td class='p-2'>" . htmlspecialchars($u['username']) . "</td>";
              echo "<td class='p-2'>" . htmlspecialchars($u['email']) . "</td>";
              echo "<td class='p-2'>₹ " . htmlspecialchars($u['balance']) . "</td>";
              echo "<td class='p-2'><a href='users.php?delete=" . intval($u['id']) . "' class='text-red-600'>Delete</a></td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='5' class='text-sm text-gray-500 p-2'>No users found.</td></tr>";
      }
      ?>
      </tbody>
    </table>

  </div>
</div>
</body>
</html>
