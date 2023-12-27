<?php
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to logout confirmation page or login page
header('url= functions.php');
exit;
?>
