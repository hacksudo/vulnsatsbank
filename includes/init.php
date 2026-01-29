<?php
// This file contains ONLY PHP. No HTML output allowed.
// Safe to include BEFORE redirects or header() calls.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database connection
include __DIR__ . "/db.php";
