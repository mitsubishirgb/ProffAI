<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
    <style>
        body {
            display: flex;
        }
        
    </style>
</head>
<body>

<?php include "components/side-panel.php"; ?>

    <main id="main">
       <?php include "components/navbar.php"; ?>
        <div id="content">
            <div id="prompt-bar">
                <input type="text" placeholder="Ask anything">
                <button id="send-button">
                    <img src="assets/icons/arrow-narrow-up.svg" alt="Send"> 
                </button>
            </div>

            <a></a>
        </div>
    </main>
    
    <script src="js/main.js"></script>

</body>
</html>