<?php
// chatbot.php
session_start();
include("includes/db.php");
include("includes/header.php");

// Randomly assign a support agent on first visit
if (!isset($_SESSION['support_agent'])) {
    $agents = ['Vishal','Aparna','Amet','Sanjal'];
    $_SESSION['support_agent'] = $agents[array_rand($agents)];
}

$agent = $_SESSION['support_agent'];
?>
<!doctype html>
<html lang="en" class="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Support Chat - 63Sats Bank</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto p-6">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="flex items-center justify-between">
      <h1 class="text-lg font-semibold">Support Chat</h1>
      <div class="text-sm text-gray-500">Assigned: <strong><?php echo htmlspecialchars($agent); ?></strong></div>
    </div>

    <div id="chat-box" class="mt-4 h-64 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 rounded border">
      <!-- messages will be loaded here -->
    </div>

    <form id="chat-form" class="mt-4 flex gap-2">
      <input id="msg" name="message" autocomplete="off"
             class="flex-1 rounded border px-3 py-2 bg-white dark:bg-gray-700" placeholder="Ask support..." />
      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Send</button>
    </form>

    <div class="mt-4 text-xs text-gray-500">
      Note: This chat is part of an intentionally vulnerable lab for training. Do not expose to public networks.
    </div>
  </div>
</div>

<script>
async function loadMessages() {
  const r = await fetch('chat_handler.php?action=fetch');
  const html = await r.text();
  document.getElementById('chat-box').innerHTML = html;
  document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
}

document.getElementById('chat-form').addEventListener('submit', async function(e){
  e.preventDefault();
  const msg = document.getElementById('msg').value.trim();
  if (!msg) return;
  document.getElementById('msg').value = '';

  // send message
  await fetch('chat_handler.php', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: new URLSearchParams({message: msg})
  });

  await loadMessages();
});

// load messages every 2s
loadMessages();
setInterval(loadMessages, 2000);
</script>
</body>
</html>
