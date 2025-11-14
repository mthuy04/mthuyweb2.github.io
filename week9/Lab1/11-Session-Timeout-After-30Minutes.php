<?php
session_save_path('i:/custom/');
session_start();

// Set the session timeout duration in seconds
$sessionTimeout = 1800; // 30 minutes

// Check if the session has already been started and calculate the time since the last activity
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $lastActivity = $_SESSION['LAST_ACTIVITY'];
    $currentTime = time();
    $timeSinceLastActivity = $currentTime - $lastActivity;

    // Check if the session has exceeded the timeout duration
    if ($timeSinceLastActivity > $sessionTimeout) {
        // Session expired, destroy the session
        session_unset();
        session_destroy();
        echo "Session expired. Please log in again.";
    } else {
        // Update the last activity time
        $_SESSION['LAST_ACTIVITY'] = $currentTime;
        echo "Session active.";
    }
} else {
    // Set the last activity time for the session
    $_SESSION['LAST_ACTIVITY'] = time();
    echo "Session started.";
}
?>
