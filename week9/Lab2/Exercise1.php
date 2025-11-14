
<?php
// --- EXERCISE 1: Define roles and permissions --

$roles = [
    'admin' => ['view_user', 'create_user', 'edit_user', 'delete_user'],
    'user' => ['view_user', 'edit_own_profile'],
    'guest' => ['view_user']
];

// $user_roles array was requested, but a $users array (below) is more useful
$users = [
    101 => ['username' => 'main_admin', 'role' => 'admin'],
    102 => ['username' => 'user_A', 'role' => 'user'],
    103 => ['username' => 'visitor', 'role' => 'guest']
];

echo "<pre>" . print_r($roles, true) . "</pre>";
echo "<pre>" . print_r($users, true) . "</pre>";
?>

