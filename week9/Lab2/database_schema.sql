/* --- EXERCISE 4: Design simple database structure --- */

-- `roles` table: Stores the roles
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

-- `permissions` table: Stores available permissions
CREATE TABLE permissions (
    permission_id INT AUTO_INCREMENT PRIMARY KEY,
    permission_name VARCHAR(100) NOT NULL UNIQUE -- e.g., 'create_user', 'edit_own_profile'
);

-- `users` table: Stores user info and links to a role
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL, -- Always store hashed passwords!
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- `role_permissions` (Junction table): Links roles to permissions
-- A role can have many permissions
-- A permission can belong to many roles
CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id), -- Composite primary key
    FOREIGN KEY (role_id) REFERENCES roles(role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id)
);

/* --- SQL Query (from Ex 4) to retrieve all permissions for a specific user_id --- */
/* Assuming we want permissions for user_id = 123 */

SELECT p.permission_name
FROM users u
JOIN roles r ON u.role_id = r.role_id
JOIN role_permissions rp ON r.role_id = rp.role_id
JOIN permissions p ON rp.permission_id = p.permission_id
WHERE u.user_id = 123;