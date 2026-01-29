<?php
// llm_simulator.php
// Simple simulator: echoes back a safe canned response, but also supports a special trigger for lab demonstration.
// Usage: llm_simulator.php?prompt=...

$prompt = $_GET['prompt'] ?? '';

$prompt_l = strtolower($prompt);

// Defensive default response:
$response = "echo 'Hello from support. How can I help you today?'";

// For lab demonstration only: a special phrase causes the model to "respond" with a shell command.
// We *do not* suggest using these phrases in public. This is for the vulnerable lab only.
if (strpos($prompt_l, 'diagnose server') !== false) {
    // Example: the model returns a diagnostic command — in the vulnerable flow this would be executed.
    $response = "ls -la /var/www/html";
} elseif (strpos($prompt_l, 'show logs') !== false) {
    $response = "tail -n 20 /var/log/apache2/access.log";
} elseif (strpos($prompt_l, 'whoami') !== false) {
    $response = "whoami";
}

header('Content-Type: text/plain; charset=utf-8');
echo $response;
