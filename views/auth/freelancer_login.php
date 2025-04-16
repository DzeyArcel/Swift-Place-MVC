
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Login - SwiftPlace</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/loginstyle.css">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="SwiftPlace Logo" class="logo-img">
        </div>
        <p class="message">Enter your email and password to access your freelancer account.</p>

        <form method="POST" action="/Swift-Place/index.php?controller=freelancer&action=login">



            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Log In</button>
        </form>
        
        <div class="signup-section">
            <p class="signup-text">Don't have a SwiftPlace freelancer account?</p>
            <a href="register.html" class="btn signup">Sign Up</a>
        </div>
    </div>
</body>
</html>
