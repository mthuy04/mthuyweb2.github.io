<?php
$roles = [
    'admin' => ['view_user', 'create_user', 'edit_user', 'delete_user'],
    'user' => ['view_user', 'edit_own_profile'],
    'guest' => ['view_user']
];
// A list of ALL possible permissions
$all_permissions = ['view_user', 'create_user', 'edit_user', 'delete_user', 'edit_own_profile', 'post_comment'];

// --- Form Processing Logic ---
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real app, you would require admin permission here
    // requirePermission('manage_roles');

    $role_to_edit = $_POST['role_name'] ?? '';
    $selected_permissions = $_POST['permissions'] ?? [];

    if ($role_to_edit && isset($roles[$role_to_edit])) {
        // Update the $roles array (simulation)
        $roles[$role_to_edit] = $selected_permissions;
        $message = "<b style='color: green;'>Successfully updated permissions for '$role_to_edit'.</b>";
    } else {
        $message = "<b style='color: red;'>Error: Role '$role_to_edit' not found.</b>";
    }
}

// Get the role to edit from the URL, default to 'user'
$role_key = $_GET['edit_role'] ?? 'user';
$role_permissions = $roles[$role_key] ?? [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise 9: Role Management</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        form { border: 1px solid #ddd; padding: 20px; }
        .permission-list { columns: 2; }
    </style>
</head>
<body>

    <p>This is a simulation. It edits the <code>$roles</code> array in memory.</p>

    <!-- Links to select which role to edit -->
    <p>
        <b>Select Role to Edit:</b>
        <a href="Exercise9.php?edit_role=admin">Admin</a> |
        <a href="Exercise9.php?edit_role=user">User</a> |
        <a href="Exercise9.php?edit_role=guest">Guest</a>
    </p>

    <hr>
    
    <!-- 1. The Interface (HTML Form) -->
    <form action="Exercise9.php?edit_role=<?php echo htmlspecialchars($role_key); ?>" method="POST">
        <h2>Manage Role: <?php echo htmlspecialchars($role_key); ?></h2>
        
        <!-- This hidden field sends the name of the role we are editing -->
        <input type="hidden" name="role_name" value="<?php echo htmlspecialchars($role_key); ?>">
        
        <h3>Assign permissions to this role:</h3>
        
        <div class="permission-list">
            <?php foreach ($all_permissions as $perm): ?>
                <div>
                    <input 
                        type="checkbox" 
                        name="permissions[]" 
                        value="<?php echo $perm; ?>"
                        id="perm_<?php echo $perm; ?>"
                        <?php
                        // Check the box if the role already has this permission
                        if (in_array($perm, $role_permissions)) {
                            echo ' checked';
                        }
                        ?>
                    >
                    <label for="perm_<?php echo $perm; ?>"><?php echo $perm; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        
        <br>
        <button type="submit">Save Changes</button>
    </form>
    
    <!-- 2. The Backend Processing (Feedback) -->
    <?php if ($message): ?>
        <hr>
        <h3>Processing Result:</h3>
        <p><?php echo $message; ?></p>
        <h4>New <code>$roles</code> array (simulated):</h4>
        <pre><?php print_r($roles); ?></pre>
    <?php endif; ?>

</body>
</html>