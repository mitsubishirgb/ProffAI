<?php
require_once __DIR__ . '/../../classes/Conversation.php';

if ($auth->isLoggedIn()) {
    $conversationModel = new Conversation();
    $conversations = $conversationModel->getAllByUserId($_SESSION['user_id']);
} else {
    $conversations = [];
}
?>

<aside>
    <div id="side-panel">
        <div class="top-bar">
            <img src="assets/icons/logo.png" alt="ProffAI Logo">
            <button id="toggle-sidebar">
                <img src="assets/icons/collapse-left2.svg" alt="Collapse">
            </button>
        </div>

        <div class="panel-operations">
            <div class="item" id="new-chat-btn" onclick="startNewChat()" style="cursor: pointer;">
                <img src="assets/icons/edit.svg" alt="New">
                <span>New chat</span>
            </div>
            <div class="item">
                <img src="assets/icons/search.svg" alt="Search">
                <a href="#" onclick="return false;">Search chats</a>
            </div>
        </div>

        <h2>Chats</h2>
        <div class="chat-history" id="chat-list">
            <?php foreach ($conversations as $chat): ?>
                <div class="conversation <?= (isset($_GET['chat_id']) && $chat['id'] == $_GET['chat_id']) ? 'active' : '' ?>" 
                     data-id="<?= $chat['id'] ?>" 
                     onclick="loadConversation(<?= $chat['id'] ?>)">
                    <span><?= htmlspecialchars(!empty($chat['title']) ? $chat['title'] : 'Chat ' . $chat['id']) ?></span>
                    <button class="delete-btn" onclick="deleteConversation(event, <?= $chat['id'] ?>)">✕</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</aside>