<?php
session_start(); // Start the session

// Clear the session variable for the logged-in user (if set)
unset($_SESSION["user_id"]);

// Destroy the session to remove all session data
session_destroy();

// Redirect the user to the login page (login.php)
header("Location: ../login.php");
exit();
?>