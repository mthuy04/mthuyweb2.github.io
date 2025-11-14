<?php
session_save_path('i:/custom/');
session_start();

// Array of user preferences
$userPreferences = array(
    "theme" => "light",
    "language" => "Spanish",
    "notifications" => true
);

$_SESSION["preferences"] = $userPreferences;

echo "User preferences have been stored in the session variable 'preferences'.";

?>
