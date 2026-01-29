<?php
// blog.php
// Path: /blog.php
session_start();
include("includes/db.php");
include("includes/header.php");

$message = "";

// Create a new blog post (no sanitization; stored XSS possible)
if (isset($_POST['create'])) {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $sql = "INSERT INTO blogs (title, content, created_at) VALUES ('$title', '$content', NOW())";
    if (mysqli_query($conn, $sql)) {
        $message = "Post published.";
    } else {
        $message = "Unable to publish.";
    }
}

// Fetch posts (simple)
$res = mysqli_query($conn, "SELECT id,title,created_at FROM blogs ORDER BY id DESC LIMIT 20");
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>News - 63 sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-4xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="flex justify-between items-center">
      <h1 class="text-lg font-semibold">News & Updates</h1>
      <div class="text-sm text-gray-500">Latest posts</div>
    </div>

    <?php if ($message): ?>
      <div class="mt-3 p-2 rounded bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-200"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="mt-4">
      <?php
      if ($res && mysqli_num_rows($res) > 0) {
          while ($b = mysqli_fetch_assoc($res)) {
              echo "<article class='p-3 border-b'><a class='font-medium' href='blog_view.php?id=" . intval($b['id']) . "'>" . htmlspecialchars($b['title']) . "</a><div class='text-xs text-gray-500 mt-1'>" . htmlspecialchars($b['created_at']) . "</div></article>";
          }
      } else {
          echo "<div class='text-sm text-gray-500'>No posts available.</div>";
      }
      ?>
    </div>

    <div class="mt-6">
      <h2 class="text-sm font-medium">Publish a post</h2>
      <form method="POST" class="mt-2 space-y-2">
        <input name="title" placeholder="Title" class="w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700" />
        <textarea name="content" rows="6" placeholder="Content" class="w-full rounded border px-3 py-2 bg-gray-50 dark:bg-gray-700"></textarea>
        <div class="flex justify-end">
          <button type="submit" name="create" class="px-4 py-2 bg-blue-600 text-white rounded">Publish</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
