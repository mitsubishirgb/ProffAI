<?php
require_once '../../classes/Auth.php';
require_once '../../classes/ContactMessage.php';
require_once '../../classes/Database.php';

Auth::requireRole('admin');

$msgObj = new ContactMessage(Database::getConnection());

if (isset($_POST['delete_message'])) {
    $msgObj->delete($_POST['message_id']);
    header("Location: messages.php");
    exit;
}

$messages = $msgObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages | Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/messages.css">
    <link rel="stylesheet" href="../css/base.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="admin.php">Dashboard</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="messages.php" class="active">Messages</a>
        <a href="../">Home</a>
    </div>

    <div id="main">
        <header>
            <h1>Messages</h1>
            <nav><a href="../pages/logout.php">Logout</a></nav>
        </header>

        <main>
            <section class="table-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="id">ID</th>
                            <th class="name">Name</th>
                            <th class="email">Email</th>
                            <th class="message">Message</th>
                            <th class="date">Date</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td class="id"><?= $msg['id'] ?></td>
                                <td class="name"><?= htmlspecialchars($msg['name']) ?></td>
                                <td class="email"><?= htmlspecialchars($msg['email']) ?></td>
                                <td class="message">
                                    <button class="view-msg-btn" data-message="<?= htmlspecialchars($msg['message']) ?>">
                                        View
                                    </button>
                                </td>
                                <td class="date"><?= date("Y-m-d H:i", strtotime($msg['created_at'])) ?></td>
                                <td class="actions">
                                    <form method="post" onsubmit="return confirm('Delete this message?');">
                                        <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                                        <button type="submit" name="delete_message" class="admin-btn delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="message-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-text"></p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.view-msg-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const message = this.dataset.message;
                const modal = document.getElementById('message-modal');
                document.getElementById('modal-text').textContent = message;
                modal.style.display = 'block';
            });
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('message-modal').style.display = 'none';
        });

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('message-modal');
            if (e.target === modal) modal.style.display = 'none';
        });
    </script>
</body>
</html>
