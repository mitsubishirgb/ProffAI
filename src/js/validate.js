document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            
            // rifreskim
            loginForm.querySelectorAll(".error").forEach(el => el.textContent = ""); 

            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            let hasError = false;

            if (!email || !validator.isEmail(email)) {
                document.getElementById("email-error").textContent = 
                    "Please enter a valid email address.";
                hasError = true;
            }

            if (password.length < 8) {
                document.getElementById("password-error").textContent = 
                    "Password must be at least 8 characters long.";
                hasError = true;
            }

            if (!hasError) {
                alert("Login successful!");
            }
        });
    }

   if (signupForm) {
        const isValidName = (str) => /^[A-Za-z]+$/.test(str.trim());

        signupForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // rifreskim
            signupForm.querySelectorAll(".error").forEach(el => el.textContent = ""); 

            const firstName = document.getElementById("first-name").value.trim();
            const lastName  = document.getElementById("last-name").value.trim();
            const email     = document.getElementById("email").value.trim();
            const password  = document.getElementById("password").value;
            const confirm   = document.getElementById("confirm-password").value;

            let hasError = false;

            if (!firstName || !isValidName(firstName)) {
                document.getElementById("first-name-error").textContent =
                    "Please enter a valid first name (letters only).";
                hasError = true;
            }

            if (!lastName || !isValidName(lastName)) {
                document.getElementById("last-name-error").textContent =
                    "Please enter a valid last name (letters only).";
                hasError = true;
            }

            if (!email || !validator.isEmail(email)) {
                document.getElementById("email-error").textContent =
                    "Please enter a valid email address.";
                hasError = true;
            }

            if (password.length < 8) {
                document.getElementById("password-error").textContent =
                    "Password must be at least 8 characters long.";
                hasError = true;
            }

            if (password !== confirm) {
                document.getElementById("confirm-password-error").textContent =
                    "Passwords do not match.";
                hasError = true;
            } else if (confirm === "") {
                document.getElementById("confirm-password-error").textContent =
                    "Field should not be empty";
                hasError = true;
            }

            if (!hasError) {
                alert("Registered successfully!");
            }
        });
    }
    
});