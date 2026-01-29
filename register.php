<?php
// Start session BEFORE any output
include("includes/header.php");
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - 63Sats Bank</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Theme script -->
  <script defer src="js/theme.js"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">

<div class="max-w-md mx-auto mt-16 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">

    <h2 class="text-3xl font-semibold text-center mb-6">Create Your Account</h2>

    <form action="register_action.php" method="POST" class="space-y-4">

        <div>
            <label class="block mb-1 font-medium">Username</label>
            <input type="text" name="username" required
                class="w-full p-3 border rounded dark:bg-gray-700 dark:border-gray-600 focus:ring focus:ring-blue-400">
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" required
                class="w-full p-3 border rounded dark:bg-gray-700 dark:border-gray-600 focus:ring focus:ring-blue-400">
        </div>

        <div>
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password" required
                class="w-full p-3 border rounded dark:bg-gray-700 dark:border-gray-600 focus:ring focus:ring-blue-400">
        </div>

        <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-lg font-medium transition">
            Register
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-300 mt-4">
        Already have an account?
        <a href="login.php" class="text-blue-600 dark:text-blue-400 underline">Login here</a>
    </p>

</div>

</body>
</html>
