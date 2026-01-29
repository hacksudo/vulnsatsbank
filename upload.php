<?php
// upload.php
// Path: /upload.php
session_start();
include("includes/db.php");
include("includes/header.php");

$message = "";

$upload_dir = __DIR__ . "/uploads/";
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0755, true);
}

// Handle upload
if (isset($_POST['upload'])) {
    if (!isset($_FILES['file'])) {
        $message = "No file uploaded.";
    } else {
        $file = $_FILES['file'];
        $original = $file['name'];
        $tmp = $file['tmp_name'];

        // Intentionally weak checks: only check extension by parsing the filename's last 4 chars
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));

        // Only allow jpg/png by extension check (easily bypassable)
        if (!in_array($ext, ['jpg','jpeg','png'])) {
            $message = "Only JPG/PNG allowed.";
        } else {
            // Build destination filename (keeps original name)
            $dest = $upload_dir . basename($original);

            // Move uploaded file (no content checks)
            if (move_uploaded_file($tmp, $dest)) {
                // Set permissive permissions (vulnerable)
                @chmod($dest, 0755);
                $message = "File uploaded.";
            } else {
                $message = "Upload failed.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Upload Document - 63sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/theme.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-lg font-semibold">Upload Document</h1>
    <?php if ($message): ?>
      <div class="mt-3 p-2 rounded bg-gray-100 dark:bg-gray-700 text-sm"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
      <div>
        <label class="block text-sm">Select file (JPG, PNG)</label>
        <input type="file" name="file" accept=".jpg,.jpeg,.png" class="mt-1" />
      </div>

      <div class="flex justify-end">
        <button type="submit" name="upload" class="px-4 py-2 bg-green-600 text-white rounded">Upload</button>
      </div>
    </form>

    <div class="mt-4">
      <h2 class="text-sm font-medium">Uploaded Files</h2>
      <div class="mt-2 text-sm">
        <?php
        $files = glob($upload_dir . "*");
        if ($files) {
            echo "<ul>";
            foreach ($files as $f) {
                $name = basename($f);
                echo "<li><a class='underline' href='uploads/" . rawurlencode($name) . "' target='_blank'>" . htmlspecialchars($name) . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='text-sm text-gray-500'>No files uploaded.</div>";
        }
        ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
