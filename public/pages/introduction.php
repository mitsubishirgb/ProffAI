<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/introduction.css">
    <title>Introduction</title>
    <style>
        body {
            display: flex;
        }
        
    </style>
</head>

<body>
    <main id="main">
       <?php include "../components/navbar.php"; ?>

        <<div id="content-introduction">
            <div class="hero-card">
                <h1>Start learning<br>today with us</h1>
                <p>We are here to help you out with your studies!</p>
                <a href="login.php" class="hero-btn">Start studying for free</a> 
            </div>
        </div>  

        
        <div class="slider-container">
            <h2>Expand on your knowledge</h2>
                <div class="slider">
            <img src="../assets/tree.png" alt="Slide 1" class="slide active">
            <img src="../assets/river.png" alt="Slide 2" class="slide">
            <img src="../assets/lake.png" alt="Slide 3" class="slide">
            <img src="../assets/waterfall.png" alt="Slide 4" class="slide">
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
    
    <script src="../js/main.js"></script>

</body>
</html>