<?php
// logout.php
session_start();
session_unset();
session_destroy();

// clear cookie
setcookie("UID", "", time() - 3600, "/");

header("Location: index.php");
exit;
