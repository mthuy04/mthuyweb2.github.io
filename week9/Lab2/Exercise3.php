
<?php
$current_role = $_GET['role'] ?? 'guest';
$_SESSION['user_role'] = $current_role;

function checkAccess($required_permission) {
    global $roles;

    // Get role from SESSION, default to 'guest' if not set
    $user_role = $_SESSION['user_role'] ?? 'guest';

    // Get guest permissions (as a fallback in case the role is invalid)
    $guest_permissions = $roles['guest'] ?? [];

    // Get the current role's permissions, or guest permissions if role is invalid
    $current_permissions = $roles[$user_role] ?? $guest_permissions;

    return in_array($required_permission, $current_permissions);
}

echo "<p>Currently viewing as: <b>" . htmlspecialchars($current_role) . "</b></p>";
echo '<p><b>Change role (demo):</b> ';
echo '<a href="?role=admin">View as Admin</a> | ';
echo '<a href="?role=user">View as User</a> | ';
echo '<a href="?role=guest">View as Guest</a></p>';
?>