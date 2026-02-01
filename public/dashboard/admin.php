<?php
require_once '../../classes/Auth.php';
require_once '../../classes/User.php';
require_once '../../classes/Database.php';

Auth::requireRole('admin');

$userObj = new User(Database::getConnection());
$users = $userObj->findAll();
$totalUsers = count($users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="../css/main.css"> -->
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="admin.php" class="active">Dashboard</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="messages.php">Messages</a>
    </div>

    <div id="main">
        <header>
            <h1>Welcome, Admin!</h1>
            <nav><a href="../pages/logout.php">Logout</a></nav>
        </header>

        <main>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?= $totalUsers ?></p>
                </div>
                <div class="card">
                    <h3>System Status</h3>
                    <p>Active</p>
                </div>
                <div class="card">
                    <h3>Pending Reports</h3>
                    <p>0</p>
                </div>
            </div>

            <section>
                <h3>Recent Activity</h3>
                <p>No recent logs to display.</p>
            </section>
        </main>
    </div>
</body>
</html>

