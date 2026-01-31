<?php
require_once '../classes/Auth.php';
require_once '../classes/Conversation.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header("Location: pages/introduction.php");
    exit;
}

$conversationModel = new Conversation();
$user_id = $_SESSION['user_id'];

$chat_id = isset($_GET['chat_id']) ? (int) $_GET['chat_id'] : null;

$messages = [];

if ($chat_id) {
    $conversation = $conversationModel->getByIdAndUser($chat_id, $user_id);
    if ($conversation) {
        $messages = $conversationModel->getMessages($chat_id);
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/components/navbar.css">
    <link rel="stylesheet" href="css/components/side-panel.css">
    <link rel="stylesheet" href="css/base.css">
    <title>ProffAI</title>
</head>
<body>
    <div class="app-layout">
        
        <?php include "components/side-panel.php"; ?>

        <main id="main">
            <?php include "components/navbar.php"; ?>
            
            <div id="content">
                <div id="chat-session">
                    <?php if (empty($messages)): ?>
                        <div class="chat-message professor">
                            <img src="assets/icons/cheerful-elderly-man-with-glasses.png" alt="ProffAI Avatar">
                            <div class="chat-bubble">
                                Përshëndetje! Unë jam ProffAI. Si mund t'ju ndihmoj sot?
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($messages as $msg): ?>
                            <div class="chat-message <?= htmlspecialchars($msg['role']) ?>">
                                <?php if ($msg['role'] === 'professor'): ?>
                                    <img src="assets/icons/cheerful-elderly-man-with-glasses.png" alt="ProffAI Avatar">
                                <?php endif; ?>
                                <div class="chat-bubble">
                                    <?= nl2br(htmlspecialchars($msg['content'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div id="prompt-bar-container">
                    <div id="prompt-bar">
                        <input type="text" id="user-input" placeholder="Pyet çfarëdo..." autocomplete="off">
                        <button id="send-button" aria-label="Dërgo mesazhin">
                            <img src="assets/icons/arrow-narrow-up.svg" alt="Dërgo">
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        window.currentChatId = <?= $chat_id ? $chat_id : 'null' ?>;
    </script>
    <script src="js/main.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/chat-list.js"></script>
</body>
</html>