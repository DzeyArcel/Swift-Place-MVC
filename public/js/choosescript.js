document.addEventListener("DOMContentLoaded", function () {
    const userTypeRadios = document.querySelectorAll('input[name="user_type"]'); // FIXED here
    const createAccountButton = document.querySelector('.create-account');

    let selectedRole = "";

    userTypeRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            selectedRole = this.value;

            // Enable and update button
            createAccountButton.removeAttribute("disabled");
            createAccountButton.classList.add("active");

            createAccountButton.textContent = selectedRole === "client"
                ? "Join as a Client"
                : "Apply as a Freelancer";
        });
    });

    createAccountButton.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent form submission

        if (selectedRole === "client") {
            window.location.href = "/Swift-Place/views/auth/client_signup.php";
        } else if (selectedRole === "freelancer") {
            window.location.href = "/Swift-Place/views/auth/freelancer_signup.php";
        }
    });
});
