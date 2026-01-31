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
    <link rel="stylesheet" href="../css/about-us.css">
    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/components/footer.css">
    <title>About-Us</title>
</head>

<body>

    <?php include "../components/navbar.php"; ?>

    <section class="about-section">
        <div class="about-container">
            <div class="text-block">
                <h1>About Us</h1>
                <p>Our website is designed to help out students with their problems
                     and help them out with their assignments while they learn.
                </p>

                 

            </div>

            <div id="section-img1">
            <img src="../assets/studying.png" alt="Our Website">
                 </div>
        </div>
    </section>

    <section class="mission-section">
    <div class="mission-container">
        <div id="section-img2">
            <img src="../assets/learning.png" alt="Our Mission">
        </div>

        <div class="mission-text">
            <h2>Our Mission: Helping Students Learn</h2>
            <p>
                We believe not only in growing bigger, but in growing better.
                Aligning students success with ours creates long-lasting impact 
                and powerful results for everyone involved.
            </p>
        </div>
    </div>
    </section>

    <?php include "../components/footer.php"; ?>

    <script src="../js/main.js"></script>

</body>
</html>