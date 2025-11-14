
<?php
function hasPermission($user_id, $permission) {
    global $users, $roles; // Get global arrays

    // 1. Check if user_id exists
    if (!isset($users[$user_id])) {
        return false;
    }

    // 2. Get the user's role
    $user_role = $users[$user_id]['role'];

    // 3. Check if the role exists in the $roles array
    if (!isset($roles[$user_role])) {
        return false;
    }

    // 4. Check if the permission is in that role's permission array
    return in_array($permission, $roles[$user_role]);
}

$test_user_id = 102; // 'user_A' (role 'user')
$test_perm_1 = 'edit_own_profile';
$test_perm_2 = 'delete_user';

echo "<p>Does User ID $test_user_id have permission '$test_perm_1'? ... <b>" . (hasPermission($test_user_id, $test_perm_1) ? "YES" : "NO") . "</b></p>";
echo "<p>Does User ID $test_user_id have permission '$test_perm_2'? ... <b>" . (hasPermission($test_user_id, $test_perm_2) ? "YES" : "NO") . "</b></p>";

?>