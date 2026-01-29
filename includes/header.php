<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 shadow-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

    <!-- LEFT LOGO -->
    <div class="flex items-center gap-4">
      <a href="index.php" class="flex items-center gap-3 group">
        <img src="assets/logo.png" alt="63Sats Bank" class="w-9 h-9 rounded-lg shadow group-hover:scale-110 transition">
        <span class="font-bold text-lg text-gray-900 dark:text-gray-100 tracking-wide">
          63Sats Bank
        </span>
      </a>
    </div>

    <!-- DESKTOP NAV -->
    <nav class="hidden md:flex gap-6 text-sm font-medium items-center">

      <a href="dashboard.php"
         class="nav-link <?php echo $current_page=='dashboard.php'?'active':''; ?>">
        📊 Dashboard
      </a>

      <a href="statement.php"
         class="nav-link <?php echo $current_page=='statement.php'?'active':''; ?>">
        📑 Statements
      </a>

      <a href="blog.php"
         class="nav-link <?php echo $current_page=='blog.php'?'active':''; ?>">
        📰 News
      </a>

      <a href="contact.php"
         class="nav-link <?php echo $current_page=='contact.php'?'active':''; ?>">
        📬 Contact
      </a>

      <a href="chatbot.php"
         class="nav-link <?php echo $current_page=='chatbot.php'?'active':''; ?>">
        🤖 Chat Support
      </a>

    </nav>

    <!-- RIGHT CONTROLS -->
    <div class="flex items-center gap-4">

      <!-- THEME TOGGLE -->
      <button id="themeToggle"
              title="Toggle Dark/Light Mode"
              class="px-3 py-1.5 rounded-full bg-gray-200 dark:bg-gray-700 
                     text-gray-700 dark:text-gray-200 shadow hover:scale-110 
                     hover:bg-gray-300 dark:hover:bg-gray-600 transition">
        🌓
      </button>

      <!-- USER SESSION AREA -->
      <?php if (isset($_SESSION['user'])): ?>
        <span class="text-sm hidden sm:inline text-gray-700 dark:text-gray-300">
          👋 Hi, <?php echo htmlspecialchars($_SESSION['user']); ?>
        </span>
        <a href="logout.php"
           class="px-3 py-1.5 bg-red-500 text-white rounded shadow hover:bg-red-600 transition">
          Logout
        </a>

      <?php elseif (isset($_COOKIE['UID'])): ?>
        <span class="text-sm hidden sm:inline text-gray-700 dark:text-gray-300">
          👋 Hi, user#<?php echo intval($_COOKIE['UID']); ?>
        </span>
        <a href="logout.php"
           class="px-3 py-1.5 bg-red-500 text-white rounded shadow hover:bg-red-600 transition">
          Logout
        </a>

      <?php else: ?>
        <a href="login.php"
           class="px-4 py-1.5 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
          Login
        </a>
      <?php endif; ?>

      <!-- MOBILE MENU BUTTON -->
      <button id="mobileMenuBtn"
              class="md:hidden px-2 py-1 rounded text-xl text-gray-700 dark:text-gray-300">
        ☰
      </button>
    </div>
  </div>

  <!-- MOBILE NAV -->
  <div id="mobileMenu"
       class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-3 space-y-2">

    <a href="dashboard.php" class="mobile-link">📊 Dashboard</a>
    <a href="statement.php" class="mobile-link">📑 Statements</a>
    <a href="blog.php" class="mobile-link">📰 News</a>
    <a href="contact.php" class="mobile-link">📬 Contact</a>
    <a href="chatbot.php" class="mobile-link">🤖 Chat Support</a>

  </div>
</header>

<!-- STYLES -->
<style>
.nav-link {
    position: relative;
    padding-bottom: 4px;
    color: #4b5563;
}
.dark .nav-link {
    color: #d1d5db;
}
.nav-link:hover {
    color: #6366f1;
}
.nav-link::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0%;
    height: 2px;
    background: linear-gradient(to right, #6366f1, #ec4899);
    transition: width 0.25s ease;
}
.nav-link:hover::after {
    width: 100%;
}
.nav-link.active {
    color: #6366f1 !important;
}
.nav-link.active::after {
    width: 100%;
}

.mobile-link {
    display: block;
    padding: 8px 0;
    color: #4b5563;
}
.dark .mobile-link {
    color: #d1d5db;
}
.mobile-link:hover {
    color: #6366f1;
}
</style>

<script>
document.getElementById("mobileMenuBtn").onclick = () => {
    document.getElementById("mobileMenu").classList.toggle("hidden");
};
</script>
