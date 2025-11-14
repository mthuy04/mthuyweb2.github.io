<?php
session_save_path('i:/custom/');
session_start();

$_SESSION["userid"] = 10020;

echo "Session variable 'userid' has been set with the value 10020.";
?>
