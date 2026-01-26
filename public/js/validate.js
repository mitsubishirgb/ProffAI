document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");
    const signupForm = document.getElementById("signup-form");

    const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let hasError = false;

            loginForm.querySelectorAll(".error").forEach(el => el.textContent = "");

            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;

            if (!email || !isValidEmail(email)) {
                document.getElementById("email-error").textContent = "Please enter a valid email address.";
                hasError = true;
            }

            if (password.length < 8) {
                document.getElementById("password-error").textContent = "Password must be at least 8 characters long.";
                hasError = true;
            }

            if (!hasError) {
                HTMLFormElement.prototype.submit.call(loginForm);
            }
        });
    }

    if (signupForm) {
        const isValidName = (str) => /^[A-Za-z]+$/.test(str.trim());

        signupForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let hasError = false;

            signupForm.querySelectorAll(".error").forEach(el => el.textContent = "");

            const firstName = document.getElementById("first-name").value.trim();
            const lastName  = document.getElementById("last-name").value.trim();
            const email     = document.getElementById("email").value.trim();
            const password  = document.getElementById("password").value;
            const confirm   = document.getElementById("confirm-password").value;

            if (!firstName || !isValidName(firstName)) {
                document.getElementById("first-name-error").textContent = "Please enter a valid first name (letters only).";
                hasError = true;
            }

            if (!lastName || !isValidName(lastName)) {
                document.getElementById("last-name-error").textContent = "Please enter a valid last name (letters only).";
                hasError = true;
            }

            if (!email || !isValidEmail(email)) {
                document.getElementById("email-error").textContent = "Please enter a valid email address.";
                hasError = true;
            }

            if (password.length < 8) {
                document.getElementById("password-error").textContent = "Password must be at least 8 characters long.";
                hasError = true;
            }

            if (!confirm) {
                document.getElementById("confirm-password-error").textContent = "Field should not be empty.";
                hasError = true;
            } else if (password !== confirm) {
                document.getElementById("confirm-password-error").textContent = "Passwords do not match.";
                hasError = true;
            }

            if (!hasError) {
                HTMLFormElement.prototype.submit.call(signupForm);
            }
        });
    }
});