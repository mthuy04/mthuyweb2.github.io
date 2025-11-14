<?php
function getUserPermissions($user_id) {
    // Database connection details (Change to match your setup)
    $db_host = "localhost";
    $db_user = "user"; // <-- Change this
    $db_pass = "pass"; // <-- Change this
    $db_name = "db";   // <-- Change this

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        // Cannot connect
        error_log("Database connection error: " . mysqli_connect_error());
        return []; // Return empty array
    }

    // The SQL from Exercise 4, but using '?' as a placeholder
    $sql = "SELECT p.permission_name
            FROM users u
            JOIN roles r ON u.role_id = r.role_id
            JOIN role_permissions rp ON r.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.permission_id
            WHERE u.user_id = ?"; // <-- Use placeholder

    $permissions = [];
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // "i" means we are binding an Integer variable
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $permissions[] = $row['permission_name'];
        }
        
        mysqli_stmt_close($stmt);
    } else {
        error_log("SQL statement preparation error: " . mysqli_error($conn));
    }

    mysqli_close($conn);
    return $permissions;
}

// --- Example Usage ---
echo "<p>This function will not run unless you update the DB credentials and have a valid database.</p>";

// $user_id_demo = 101;
// $perms = getUserPermissions($user_id_demo);

// echo "<p>Permissions for User ID $user_id_demo:</p>";
// echo "<pre>" . print_r($perms, true) . "</pre>";

?>