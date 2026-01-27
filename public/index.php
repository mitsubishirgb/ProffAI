<?php
include_once '../classes/Auth.php';

    $auth = new Auth();
    if (!$auth->isLoggedIn()) {
        header("Location: pages/login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/components/navbar.css">
    <link rel="stylesheet" href="css/base.css">
    <title>ProffAI</title>
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar">
            <?php include "components/side-panel.php"; ?>
        </aside>

        <main id="main">
            <?php include "components/navbar.php"; ?>

            <div id="content">
                <div id="chat-session">
                    <div class="chat-message ai">
                        <img src="assets/icons/cheerful-elderly-man-with-glasses.png" alt="ProffAI Avatar">
                        <div class="chat-bubble">
                            Përshëndetje! Unë jam ProffAI. Si mund t'ju ndihmoj sot?
                        </div>
                    </div>
                    </div>

                <div id="prompt-bar-container">
                    <div id="prompt-bar">
                        <input type="text" id="user-input" placeholder="Pyet çfarëdo...">
                        <button id="send-button" aria-label="Dërgo mesazhin">
                            <img src="assets/icons/arrow-narrow-up.svg" alt="Dërgo">
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/main.js"></script>
    <script src="js/chat.js"></script>
</body>
</html>