<!-- views/auth/client_signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/clientstyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="signup-container">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Company Logo" class="logo-img">
        </div>

        <h2>Sign up to hire talent <i class="fa-solid fa-user-tie"></i></h2>

        <form action="/Swift-Place/index.php?controller=client&action=register" method="POST">


            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>

        <p class="login-text">Already have an account? <a href="/Swift-Place/views/auth/login.php">Log In</a></p>
        <p class="apply-text">Apply as Freelancer? <a href="/Swift-Place/views/auth/register.php">Apply Here</a></p>
    </div>
</body>
</html>
