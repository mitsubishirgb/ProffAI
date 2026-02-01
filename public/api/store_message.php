<?php
require_once '../../classes/database.php';
require_once '../../classes/ContactMessage.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/contact.php");
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    header("Location: ../pages/contact.php");
    exit;
}

$msg = new ContactMessage(Database::getConnection());
$msg->create($name, $email, $message);

header("Location: ../pages/contact.php?success=1");
exit;
