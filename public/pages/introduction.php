<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/introduction.css">
    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/components/footer.css">
    <title>Introduction</title>
</head>

<body>
    <main id="main">
       <?php include "../components/navbar.php"; ?>

        <div id="content-introduction">
            <div class="hero-card">
                <h1>Start learning<br>today with us</h1>
                <p>We are here to help you out with your studies!</p>
                <a href="login.php" class="hero-btn">Start studying for free</a>
            </div>
        </div>  

        <div class="slider-container">
            <h2>Expand on your knowledge</h2>
            <div class="slider">
                <img src="../assets/tree.png" alt="Scenic tree representing growth in knowledge" class="slide active">
                <img src="../assets/river.png" alt="Flowing river symbolizing continuous learning" class="slide">
                <img src="../assets/lake.png" alt="Tranquil lake for deep reflection and study" class="slide">
                <img src="../assets/waterfall.png" alt="Powerful waterfall depicting knowledge breakthroughs" class="slide">
            </div>
        </div>

        <div class="plans-preview-section">
            <h2>Choose the right plan for your goals</h2>
    
            <div class="preview-cards-container">
                <div class="preview-card">
                    <h3>Free</h3>
                    <ul>
                        <li>Basic AI responses</li>
                        <li>Short conversations</li>
                        <li>Standard speed</li>
                    </ul>
                </div>

                <div class="preview-card featured-preview">
                    <span class="mini-badge">POPULAR</span>
                    <h3>Plus</h3>
                    <ul>
                        <li>Advanced AI reasoning</li>
                        <li>Faster responses</li>
                        <li>Memory & context</li>
                    </ul>
                </div>

                <div class="preview-card">
                    <h3>Pro</h3>
                    <ul>
                        <li>Unlimited messages</li>
                        <li>Maximum speed</li>
                        <li>Priority support</li>
                    </ul>
                </div>
            </div>

            <div class="pricing-redirect">
                <a href="pricing.html" class="hero-btn pricing-btn">View All Plans & Pricing</a>
            </div>
        </div>

    </main>
   
    <?php include "../components/footer.php"; ?>

    <script src="../js/main.js"></script>
    <script src="../js/slider.js"></script>
</body>
</html>