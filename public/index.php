<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
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
                        <img src="assets/icons/cheerful-elderly-man-with-glasses.png" alt="AI">
                        <div class="chat-bubble">
                            Pershendetje, Une jame ProffAI.
                        </div>
                    </div>
                </div>

                <div id="prompt-bar-container">
                    <div id="prompt-bar">
                        <input type="text" id="user-input" placeholder="Ask anything"> 
                        <button id="send-button">
                            <img src="assets/icons/arrow-narrow-up.svg" alt="Send"> 
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>    
    <script src="js/main.js"></script>
</body>
</html>