<?php 
include_once '../../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth();
    if ($auth->isLoggedIn()) {
        header("Location: ../index.php");
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $success = "Login successful!";
    }

    // Attempt to log in
    if ($auth->login($email, $password)) {
        header("Location: ../index.php"); // Redirect to home page
        exit;
    } else {
        $error = "Invalid login credentials!";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Log in</title>
    
    <style>
        .signup-link a { 
            text-decoration: none;
            color: white;
        }
        </style>

</head>
<body>
    <div class="page-center">
        <div id="form-box">  
            <h2>Log in to your account</h2>  

            <form id="login-form" action="login.php" method="post" novalidate>

                <div class="field">
                    <input id="email" name="email" type="email" placeholder="Email" required>
                    <span id="email-error" class="error"></span>
                </div>

                <div class="field">
                    <input id="password" name="password" type="password" placeholder="Password" required>
                    <span id="password-error" class="error"></span>
                </div>

                <div class="signup-link">
                    Don't have an account? <a href="signup.php">Create an account</a>
                </div>

                <?php if (!empty($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.7.0/validator.min.js"></script>
    <script src="../js/validate.js"></script>
</body>
</html>