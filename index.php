<?php
// 🔥 Start session BEFORE output
include("includes/header.php");

// 🔥 Hidden LFI backdoor (intentionally vulnerable)
if (isset($_GET['page'])) {
    include($_GET['page']);  // NO sanitization → LFI
}
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>63Sats Bank</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Theme Toggle -->
  <script defer src="js/theme.js"></script>

  <style>
    /* Soft glowing hover effect */
    .glow:hover {
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }
  </style>

</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">

<!-- 🔵 HEADER BANNER -->
<div class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white py-10 shadow-lg">
  <div class="max-w-6xl mx-auto px-6">
    <h1 class="text-4xl font-extrabold tracking-wide">Welcome to 63Sats Bank</h1>
    <p class="mt-2 text-lg opacity-90">Fast, secure, and trusted banking—now with a modern interface.</p>
  </div>
</div>

<main class="max-w-6xl mx-auto p-6">

  <!-- 🔥 MAIN CARDS -->
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-10">

    <a href="dashboard.php"
       class="glow block bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-xl transition">
      <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-300">Dashboard</h3>
      <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">View your account overview</p>
    </a>

    <a href="transfer.php"
       class="glow block bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-xl transition">
      <h3 class="text-xl font-semibold text-purple-600 dark:text-purple-300">Transfer Money</h3>
      <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Send funds to any account</p>
    </a>

    <a href="blog.php"
       class="glow block bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-xl transition">
      <h3 class="text-xl font-semibold text-pink-600 dark:text-pink-300">News & Updates</h3>
      <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Latest announcements</p>
    </a>

    <a href="chatbot.php"
       class="glow block bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-xl transition">
      <h3 class="text-xl font-semibold text-green-600 dark:text-green-300">Support Chat</h3>
      <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Chat with our support team</p>
    </a>

  </section>


  <!-- 🔵 SECONDARY SECTION -->
  <section class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Quick Links (LFI hidden in About link) -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
      <h2 class="text-xl font-semibold text-indigo-500 dark:text-indigo-300">Quick Links</h2>
      <ul class="mt-4 space-y-3 text-sm">

        <li><a class="text-blue-600 dark:text-blue-300 hover:underline" href="login.php">Login</a></li>

        <li><a class="text-blue-600 dark:text-blue-300 hover:underline" href="register.php">Register</a></li>

        <li><a class="text-blue-600 dark:text-blue-300 hover:underline" href="contact.php">Contact</a></li>

        <!-- ⭐ Hidden LFI: looks normal, triggers include() -->
        <li>
          <a class="text-blue-600 dark:text-blue-300 hover:underline"
             href="index.php?page=about.php">About</a>
        </li>

      </ul>
    </div>

    <!-- Recent Articles -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
      <h2 class="text-xl font-semibold text-purple-500 dark:text-purple-300">Recent Articles</h2>

      <div class="mt-4 space-y-4">

        <article class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border dark:border-gray-600 hover:shadow transition">
          <a href="blog_view.php?id=1" class="font-semibold text-indigo-600 dark:text-indigo-300">
            Service updates
          </a>
          <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Monthly maintenance schedule.</p>
        </article>

        <article class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border dark:border-gray-600 hover:shadow transition">
          <a href="blog_view.php?id=2" class="font-semibold text-indigo-600 dark:text-indigo-300">
            Security notices
          </a>
          <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Important announcements.</p>
        </article>

      </div>
    </div>

  </section>

</main>

<footer class="py-6 text-center text-sm text-gray-600 dark:text-gray-400">
  &copy; <?php echo date('Y'); ?> 63Sats Bank. All rights reserved.
</footer>

</body>
</html>
