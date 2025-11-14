<?php
$cookieName = "username";

// Set the cookie expiration time to the past to delete the cookie
setcookie($cookieName, "", time() - 3600);

echo "Cookie named 'username' has been deleted.";
?>
