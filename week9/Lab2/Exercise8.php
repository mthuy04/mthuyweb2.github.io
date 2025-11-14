<?php

echo "<h1>Exercise 8: Role Hierarchy (Code)</h1>";
echo "<p>This file contains the SQL and PHP functions for implementing role inheritance.</p>";
echo "<p>It is not a runnable demo page, but a code reference.</p>";


// --- 1. Database Update (SQL) ---
/*
  Run this SQL in phpMyAdmin ONE TIME to add the parent_role_id column.
  
  ALTER TABLE roles
  ADD COLUMN parent_role_id INT NULL DEFAULT NULL,
  ADD FOREIGN KEY (parent_role_id) REFERENCES roles(role_id)
  ON DELETE SET NULL;
*/


// --- 2. PHP Functions ---

/**
 * Gets all permissions for a role_id, including inherited ones.
 *
 * @param int $role_id The ID of the role
 * @param mysqli $conn The database connection object
 * @param array $processed_roles (Internal use) to prevent infinite loops
 * @return array An array of permission_names
 */
function getAllPermissionsForRole($role_id, $conn, $processed_roles = []) {
    if (!$role_id || in_array($role_id, $processed_roles)) {
        // Stop if role is null or we are in an infinite loop
        return [];
    }
    
    // Add this role to the processed list
    $processed_roles[] = $role_id;

    $permissions = [];
    $parent_role_id = null;

    // 1. Get this role's DIRECT permissions AND its parent ID
    $sql = "SELECT p.permission_name, r.parent_role_id
            FROM roles r
            LEFT JOIN role_permissions rp ON r.role_id = rp.role_id
            LEFT JOIN permissions p ON rp.permission_id = p.permission_id
            WHERE r.role_id = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $role_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['permission_name']) {
            // Add direct permission
            $permissions[] = $row['permission_name'];
        }
        if ($parent_role_id === null) {
            // Store the parent ID (will be the same for all rows)
            $parent_role_id = $row['parent_role_id'];
        }
    }
    mysqli_stmt_close($stmt);

    // 2. If it has a parent, recursively call this function
    if ($parent_role_id !== null) {
        $parent_permissions = getAllPermissionsForRole($parent_role_id, $conn, $processed_roles);
        // Merge parent's permissions in
        $permissions = array_merge($permissions, $parent_permissions);
    }

    // Return the unique list of permissions
    return array_unique($permissions);
}

/**
 * Gets all permissions (including inherited) for a given user_id.
 * (This is the modified Exercise 5 function)
 *
 * @param int $user_id The user's ID
 * @param mysqli $conn The database connection object
 * @return array An array of all permissions
 */
function getUserPermissions_Hierarchical($user_id, $conn) {
    // 1. Get the user's role_id
    $sql = "SELECT role_id FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        return []; // User not found
    }
    $role_id = $row['role_id'];
    mysqli_stmt_close($stmt);

    // 2. Get all permissions (including inherited) for that role
    if ($role_id) {
        return getAllPermissionsForRole($role_id, $conn);
    } else {
        return []; // User has no role
    }
}

?>