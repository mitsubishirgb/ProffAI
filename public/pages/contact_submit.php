<?php
require_once '../../classes/Auth.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/contact.css">
    <title>Success</title>
</head>
<body>
    <div class="contact-section">
        <div class="contact-card">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <div class="contact-success">Mesazhi u dërgua me sukses!</div>
            <?php else: ?>
                <div class="contact-success" style="background:rgba(255,0,0,0.2);">Pati një problem.</div>
            <?php endif; ?>
            
            <a href="contact.php">
                <button id="contact-button" type="button">Kthehu te Forma</button>
            </a>
        </div>
    </div>
</body>
</html>