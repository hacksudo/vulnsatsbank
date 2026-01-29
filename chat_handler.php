<?php
// chat_handler.php
session_start();
include("includes/db.php");

// Ensure an agent is assigned
if (!isset($_SESSION['support_agent'])) {
    $agents = ['Vishal','Aparna','Amet','Sanjal'];
    $_SESSION['support_agent'] = $agents[array_rand($agents)];
}

$agent = $_SESSION['support_agent'];
$user = $_SESSION['user'] ?? 'guest';
$user_id = 0;
if ($user) {
    $r = mysqli_query($conn, "SELECT id FROM users WHERE username='".mysqli_real_escape_string($conn,$user)."' LIMIT 1");
    if ($r && mysqli_num_rows($r)) $user_id = intval(mysqli_fetch_assoc($r)['id']);
}

// Simple fetch for messages
if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $out = "";
    $res = mysqli_query($conn, "SELECT who, message, created_at FROM chat_logs ORDER BY id ASC LIMIT 200");
    while ($row = mysqli_fetch_assoc($res)) {
        $who = htmlspecialchars($row['who']);
        $msg = htmlspecialchars($row['message']);
        $time = htmlspecialchars($row['created_at']);
        $out .= "<div class='mb-2'><strong>{$who}</strong> <span class='text-xs text-gray-400'>[{$time}]</span><div class='mt-1'>{$msg}</div></div>";
    }
    echo $out;
    exit;
}

// Posting a new message from user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = $_POST['message'] ?? '';
    $msg_clean = trim($msg);
    if ($msg_clean === '') {
        http_response_code(400);
        echo "Empty message";
        exit;
    }

    // Log user message
    $who = mysqli_real_escape_string($conn, $user ?: 'guest');
    $m = mysqli_real_escape_string($conn, $msg_clean);
    mysqli_query($conn, "INSERT INTO chat_logs (who, message, created_at) VALUES ('$who', '$m', NOW())");

    // Build prompt for LLM (intentionally naive: user input embedded directly)
    $prompt = "You are support agent $agent. User message: " . $msg_clean;

    // Call the LLM simulator (local)
    // NOTE: llm_simulator.php returns a plain-text response. The vulnerable behavior below executes the LLM output on the server.
    $llm_response = trim(file_get_contents(__DIR__ . '/llm_simulator.php?prompt=' . urlencode($prompt)));

    // ====== INTENTIONAL VULNERABLE BEHAVIOR ======
    // The LLM response is executed on the server shell. This is a deliberate vulnerability for the lab.
    // DO NOT run this pattern outside a controlled environment.
    $exec_output = shell_exec($llm_response . ' 2>&1');

    // Save agent reply (LLM) and execution output to chat log
    $agent_msg = "Agent: " . $llm_response . "\n\n[Execution Output]\n" . ($exec_output ?: '(no output)');
    $agent_msg_esc = mysqli_real_escape_string($conn, $agent_msg);
    mysqli_query($conn, "INSERT INTO chat_logs (who, message, created_at) VALUES ('{$agent}', '{$agent_msg_esc}', NOW())");

    echo "OK";
    exit;
}
