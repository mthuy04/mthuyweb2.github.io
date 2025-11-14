
<?php
// Set the session save path
session_save_path('i:/custom/');

session_start();

// Regenerate the session ID
session_regenerate_id(true);

echo "Session ID has been regenerated.";

?>
