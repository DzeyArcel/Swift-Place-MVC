<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftPlace Client Login</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/loginstyle.css">
</head>  
<body>
    <div class="container">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="SwiftPlace Logo" class="logo-img">
        </div>
        <p class="message">Enter your email and password to access your client account.</p>

        <!-- 🔁 Updated form action to point to client route -->
        <form method="post" action="/Swift-Place/index.php?controller=client&action=login">


    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" class="btn">Log In</button>
</form>

        <div class="signup-section">
            <p class="signup-text">Don't have a SwiftPlace account?</p>
            <a href="/Swift-Place/views/auth/choose_role.php" class="btn signup">Sign Up</a>
        </div>
    </div>
</body>
</html>
