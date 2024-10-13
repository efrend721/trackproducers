<?php
session_start();

// Set the inactivity timeout to 1 hour (3600 seconds)
$inactive = 10; // 1 hour

// Check if the session timeout is set
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    // If session life exceeds the allowed inactivity time
    if ($session_life > $inactive - 5) {  // 5 seconds before timeout
        header("Location: ../includes/logout.inc.php"); // Redirect to logout page
        exit();
    }
}

// Update the session timeout
$_SESSION['timeout'] = time();
?>
