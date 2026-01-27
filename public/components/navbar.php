
<nav class="navbar"> 
    <div class="logo">
        <a href="/index.php">ProffAI</a>  
    </div>
    <ul class="nav-links">
        <li><a href="../pages/pricing.html">Upgrade</a></li>
        <li><a href="../pages/about-us.php">About Us</a></li>
        <?php if (!$auth->isLoggedIn()): ?>
                <li><a href="../pages/login.php">Log In</a></li>
        <?php else: ?>
                <li><a href="../pages/logout.php">Log Out</a></li>
        <?php endif; ?>
    </ul>
</nav>
