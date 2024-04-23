<?php
// Start the session
session_start();

// Destroy the session to log out
session_destroy();

// Redirect to index.php or login page
header('Location: index.php');
exit;
?>
