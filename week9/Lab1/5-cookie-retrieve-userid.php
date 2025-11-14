<?php
session_save_path('i:/custom/');
session_start();
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    echo "Value of session variable 'userid': " . $userid;
} else {
    echo "Session variable 'userid' not found.";
}
?>
