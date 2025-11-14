<?php
function requirePermission($permission) {
    if (!checkAccess($permission)) {
        // In a real app, you would use:
        // header("Location: unauthorized.php");
        // exit();

        // In this demo file, we just show a message and stop
        echo "<h3 style='color: red;'>ACCESS DENIED!</h3>";
        echo "<p>You do not have the '<b>" . htmlspecialchars($permission) . "</b>' permission to perform this action.</p>";
        echo "</body></html>";
        exit(); // Stop executing the rest of the page
    }
}

echo "<p>We will now try to require the 'delete_user' permission...</p>";

// Uncomment the line below to test.
// If you are viewing as 'user' or 'guest', the script will stop here.
// If you are 'admin', you will see the "Access granted" message.

// requirePermission('delete_user');

echo "<p style='color: green; font-weight: bold;'>... Access granted!</p>";
echo "<p>(If you are not an admin, uncomment the 'requirePermission' line in the code to see it work)</p>";

echo "</body></html>";
?>