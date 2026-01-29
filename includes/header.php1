<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-white dark:bg-gray-800 shadow">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <a href="index.php" class="flex items-center gap-3">
        <img src="https://via.placeholder.com/36x36?text=H" alt="Horizon" class="rounded">
        <span class="font-semibold">Horizon Bank</span>
      </a>
      <nav class="hidden md:flex gap-3 text-sm">
        <a href="dashboard.php" class="hover:underline">Dashboard</a>
        <a href="statement.php" class="hover:underline">Statements</a>
        <a href="blog.php" class="hover:underline">News</a>
        <a href="contact.php" class="hover:underline">Contact</a>
      </nav>
    </div>

    <div class="flex items-center gap-3">
      <button id="theme-toggle" class="px-3 py-1 border rounded text-sm">Toggle</button>

      <?php if (isset($_SESSION['user'])): ?>
        <span class="text-sm hidden sm:inline">Hi, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
        <a href="logout.php" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Logout</a>
      <?php elseif (isset($_COOKIE['UID'])): ?>
        <span class="text-sm hidden sm:inline">Hi, user#<?php echo intval($_COOKIE['UID']); ?></span>
        <a href="logout.php" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Logout</a>
      <?php else: ?>
        <a href="login.php" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Login</a>
      <?php endif; ?>
    </div>
  </div>
</header>
