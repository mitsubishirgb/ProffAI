<?php 
include_once '../../classes/Auth.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $auth = new Auth();
    if ($auth->isLoggedIn()) {
        header("Location: ../index.php");
        exit;
    }

    $firstName = $_POST['first-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        if ($auth->signup($firstName, $lastName, $email, $password)) {
            header("Location: ../index.php");
            exit;
        } else {
            $error = "User could not be created!";
        }
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

    <div class="page-center">
        
    <div id="form-box">
        <h2>Create an account</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
            
        <form id="signup-form" action="" method="post" novalidate>
            <div class="fullname">
                <div class="field">
                    <input id="first-name" name="first-name" type="text" placeholder="Name" value="<?= htmlspecialchars($_POST['first-name'] ?? '') ?>">
                    <span id="first-name-error" class="error"></span>
                </div>
                <div class="field">
                    <input id="last-name" name="last-name" type="text" placeholder="Lastname" value="<?= htmlspecialchars($_POST['last-name'] ?? '') ?>">
                    <span id="last-name-error" class="error"></span>
                </div>
            </div>

            <div class="field">
                <input id="email" name="email" type="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <span id="email-error" class="error"></span>
            </div>
            
            <div class="field">
                <input id="password" name="password" type="password" placeholder="Password">
                <span id="password-error" class="error"></span>
            </div>
            
            <div class="field">
                <input id="confirm-password" name="confirm-password" type="password" placeholder="Confirm Password">
                <span id="confirm-password-error" class="error"></span>
            </div>
                  
            <div class="login-link">
                Already have an account? <a href="login.php">Log in</a>
            </div> 

            <button type="submit">Sign Up</button>
        </form>
    </div>
</div>

    <script src="../js/validate.js"></script>
</body>
</html>