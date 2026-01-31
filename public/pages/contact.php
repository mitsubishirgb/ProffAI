<?php
include_once '../../classes/Auth.php';
$auth = new Auth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/components/footer.css">

    <title>Contact</title>
</head>

<body>
    <?php include "../components/navbar.php"; ?>

    <main id="main">
        <section class="contact-section">
            <div class="contact-card">
                <h1>Contact Us</h1>
                <p>Have a question? Send us a message.</p>

                <form class="contact-form" method="POST" action="../api/store_message.php">
                    <input type="text" name="name" placeholder="Your name" required>
                    <input type="email" name="email" placeholder="Your email" required>
                    <textarea name="message" placeholder="Your message" required></textarea>

                    <button id="contact-button" type="submit">Send message</button>
                </form>

                <?php if (isset($_GET['success'])): ?>
                    <div class="contact-success">Message sent successfully</div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include "../components/footer.php"; ?>
</body>
</html>
