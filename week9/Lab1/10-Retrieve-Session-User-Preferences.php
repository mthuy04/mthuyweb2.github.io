<?php
session_save_path('i:/custom/');
session_start();

if (isset($_SESSION["preferences"]))
{
    $userPreferences = $_SESSION["preferences"];

    echo "User Preferences:</br>";
    foreach ($userPreferences as $key => $value) {
        echo $key . ": " . $value . "</br>";
    }
 }
else
{
    echo "No user preferences found.";
}

?>
