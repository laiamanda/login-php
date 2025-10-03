<?php 
    // Init Session
    session_start();
    // Set Session to empty array
    $_SESSION = [];
    session_destroy();
    // Redirect user back to the login.php page
    header("Location: login.php");
    exit;
?>