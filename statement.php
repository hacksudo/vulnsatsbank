<?php
// statement.php
session_start();
include("includes/db.php");
include("includes/header.php");

$message = "";

// Determine current user (still vulnerable)
$user = $_SESSION['user'] ?? null;
$user_id = 0;

if ($user) {
    $u = mysqli_real_escape_string($conn, $user);
    $res = mysqli_query($conn, "SELECT id FROM users WHERE username='$u' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $user_id = intval($row['id']);
    }
}

// Fetch balance
$bal_res = mysqli_query($conn, "SELECT balance FROM accounts WHERE user_id = $user_id");
$bal = ($bal_res && mysqli_num_rows($bal_res)) ? mysqli_fetch_assoc($bal_res)['balance'] : 0;

// IDOR parameter (vulnerable)
$target_id = intval($_GET['uid'] ?? $user_id);

?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8">
  <title>Statement - 63Sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-100 min-h-screen">

<div class="max-w-4xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h1 class="text-xl font-semibold">Account Statement</h1>

    <p class="mt-2 text-sm">Showing statement for User ID: <?php echo $target_id; ?> (Bank Statement)</p>

    <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-700 rounded">
      <p class="text-lg font-medium">Current Balance:</p>
      <p class="text-2xl font-bold mt-1">
        ₹ 
        <?php
        $b = mysqli_query($conn, "SELECT balance FROM accounts WHERE user_id = $target_id");
        if ($b && mysqli_num_rows($b)) {
            echo mysqli_fetch_assoc($b)['balance'];
        } else {
            echo "0.00";
        }
        ?>
      </p>
    </div>

    <h2 class="text-lg font-semibold mt-6">Recent Transactions</h2>

    <?php
    $trs = mysqli_query($conn,
        "SELECT * FROM transactions 
         WHERE from_id = $target_id OR to_id = $target_id
         ORDER BY id DESC"
    );

    if ($trs && mysqli_num_rows($trs) > 0) {
        echo "<table class='w-full mt-4 text-sm'>";
        echo "<tr class='bg-gray-200 dark:bg-gray-700'>
                <th class='p-2'>ID</th>
                <th class='p-2'>From</th>
                <th class='p-2'>To</th>
                <th class='p-2'>Amount</th>
                <th class='p-2'>Date</th>
              </tr>";

        while ($t = mysqli_fetch_assoc($trs)) {
            echo "<tr class='border-b dark:border-gray-600'>
                    <td class='p-2'>{$t['id']}</td>
                    <td class='p-2'>{$t['from_id']}</td>
                    <td class='p-2'>{$t['to_id']}</td>
                    <td class='p-2'>₹ {$t['amount']}</td>
                    <td class='p-2'>{$t['created_at']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='mt-4 text-sm text-gray-400'>No transactions found.</p>";
    }
    ?>

  </div>
</div>

</body>
</html>
