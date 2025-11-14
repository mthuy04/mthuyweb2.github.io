<?php
session_start();

// --- Data from Exercise 1 (Required) ---
$roles = [
    'admin' => ['view_user', 'create_user', 'edit_user', 'delete_user'],
    'user' => ['view_user', 'edit_own_profile'],
    'guest' => ['view_user']
];
// --- End of Data ---

// --- Function from Exercise 3 (Required) ---
function checkAccess($required_permission) {
    global $roles;
    $user_role = $_SESSION['user_role'] ?? 'guest';
    $guest_permissions = $roles['guest'] ?? [];
    $current_permissions = $roles[$user_role] ?? $guest_permissions;
    return in_array($required_permission, $current_permissions);
}
// --- End of Function ---

// --- Demo: Set a role in the session ---
// Get role from URL query (e.g., Exercise7.php?role=admin)
// This makes it easy to test
if (isset($_GET['role'])) {
    $_SESSION['user_role'] = $_GET['role'];
}
$current_role = $_SESSION['user_role'] ?? 'guest';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise 7: Dynamic Menu</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        nav { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
        nav ul { list-style: none; padding: 0; margin: 0; }
        nav li { display: inline-block; margin-right: 15px; }
        nav a { text-decoration: none; color: #333; }
        .demo-links { margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Exercise 7: Dynamic Menu</h1>
    
    <p>Your current role is: <b><?php echo htmlspecialchars($current_role); ?></b></p>
    
    <hr>

    <h3>Dynamic Menu:</h3>
    <nav>
        <ul>
            <?php if (checkAccess('view_user')): ?>
                <li><a href="#view">View Users</a></li>
            <?php endif; ?>

            <?php if (checkAccess('edit_own_profile')): ?>
                <li><a href="#profile">Edit My Profile</a></li>
            <?php endif; ?>

            <?php if (checkAccess('edit_user')): ?>
                <li><a href="#edit">Edit Users (Admin)</a></li>
            <?php endif; ?>

            <?php if (checkAccess('create_user')): ?>
                <li><a href="#create">Create User (Admin)</a></li>
            <?php endif; ?>

            <?php if (checkAccess('delete_user')): ?>
                <li><a href="#delete" style="color: red;">Delete User (Admin)</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="demo-links">
        <b>Test Links (to change role):</b>
        <ul>
            <li><a href="Exercise7.php?role=admin">View as Admin</a></li>
            <li><a href="Exercise7.php?role=user">View as User</a></li>
            <li><a href="Exercise7.php?role=guest">View as Guest</a></li>
        </ul>
    </div>

</body>
</html>