<?php
$cookieName = "username";
$cookieValue = "Gulnara Serik";
$expirationTime = time() + 3600; // current time + 1 hour

setcookie($cookieName, $cookieValue, $expirationTime);

echo "Cookie named 'username' has been set with the value 'Gulnara Serik'.";
?>
