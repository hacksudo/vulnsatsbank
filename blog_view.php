<?php
// blog_view.php
// Path: /blog_view.php
session_start();
include("includes/db.php");
include("includes/header.php");

// Intentionally vulnerable: id is used directly (SQLi)
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$sql = "SELECT id,title,content,created_at FROM blogs WHERE id = $id LIMIT 1";
$res = mysqli_query($conn, $sql);
$post = null;
if ($res && mysqli_num_rows($res) > 0) {
    $post = mysqli_fetch_assoc($res);
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $post ? htmlspecialchars($post['title']) : "Post"; ?> - Horizon Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <?php if ($post): ?>
      <h1 class="text-xl font-semibold"><?php echo htmlspecialchars($post['title']); ?></h1>
      <div class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($post['created_at']); ?></div>
      <div class="mt-4 text-sm leading-relaxed">
        <?php
        // Content printed raw to allow stored XSS in posts
        echo $post['content'];
        ?>
      </div>
    <?php else: ?>
      <div class="text-sm text-gray-500">Post not found.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
