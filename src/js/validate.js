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

   
    
});