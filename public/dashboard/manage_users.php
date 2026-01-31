<?php
require_once '../../classes/Auth.php';
require_once '../../classes/User.php';
require_once '../../classes/Database.php';

Auth::requireRole('admin');

$userObj = new User(Database::getConnection());

if (isset($_POST['update_role'])) {
    $userObj->updateRole($_POST['user_id'], $_POST['role']);
    header("Location: manage_users.php");
    exit;
}


if (isset($_POST['delete_user'])) {
    $userObj->delete($_POST['user_id']);
    header("Location: manage_users.php");
    exit;
}

$users = $userObj->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin</title>
    <!-- <link rel="stylesheet" href="../css/main.css"> -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/manage_users.css">
    <link rel="stylesheet" href="../css/base.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="admin.php">Dashboard</a>
        <a href="manage_users.php" class="active">Manage Users</a>
        <a href="messages.php">Messages</a>
    </div>

    <div id="main">
        <header>
            <h1>User Management</h1>
            <nav><a href="../pages/logout.php">Logout</a></nav>
        </header>

        <main>
            <section>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <form method="post" style="display:inline-flex; gap: 5px;">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <select name="role">
                                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                        <button type="submit" name="update_role" class="admin-btn">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" onsubmit="return confirm('Are you sure?');">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="delete_user" class="admin-btn delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>