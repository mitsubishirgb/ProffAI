<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $firstName = $_POST['first-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    if(empty($firstName) || empty($lastName) ||  empty($email) || 
             empty($password) || empty($confirmPassword)) { 
        $error = "All fields are required.";
    } else { 
        $success = "Signup successful!";
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
    <title>Sign up</title>
    
    <style>
        .login-link a { 
           text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div id="form-box">
        <h2>Create an account</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
            
        <form id="signup-form" action="" method="" novalidate>
            <div class="fullname">
                <div class="field">
                    <input id="first-name" type="text" placeholder="Name">
                    <span id="first-name-error" class="error"></span>
                </div>
                <div class="field">
                    <input id="last-name" type="text" placeholder="Lastname">
                    <span id="last-name-error" class="error"></span>
                </div>
            </div>

            <div class="field">
                <input id="email" type="email" placeholder="Email" required>
                <span id="email-error" class="error"></span>
            </div>
            
            <div class="field">
                <input id="password" type="password" placeholder="Password">
                <span id="password-error" class="error"></span>
            </div>
            
            <div class="field">
                <input id="confirm-password" type="password" placeholder="Confirm Password">
                <span id="confirm-password-error" class="error"></span>
            </div>
                  
            <div class="login-link">
                Already have an account? <a href="login.php">Log in</a>
            </div> 

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.7.0/validator.min.js"></script>
    <script src="../js/validate.js"></script>
</body>
</html>