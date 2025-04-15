<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Signup</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Swift-Place/public/css/freelancestyle.css">
</head>
<body>
    <div class="signup-container">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Company Logo" class="logo-img">
            
        </div>
        
        <h2>Sign up as a Freelancer  <i class="fa-solid fa-laptop-code"></i></h2>

        <form action="/Swift-Place/index.php?controller=freelancer&action=signup" method="POST">




            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="job_category" required>
                <option value="">Select Job Category</option>
                <option value="Web Development">Web Development</option>
                <option value="Graphic Design">Graphic Design</option>
                <option value="Content Writing">Content Writing</option>
                <option value="Video Editing">Video Editing</option>
                <option value="Digital Marketing">Digital Marketing</option>
                <option value="Programming">IT Industry</option>
                <option value="Business">Business</option>
                <option value="Music">Audio & Music</option>
            </select>

            <select name="experience" required>
                <option value="">Select Experience Level</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Expert">Expert</option>
            </select>

            <input type="text" name="skills" placeholder="Skills (comma-separated)" required>
            <input type="url" name="portfolio_link" placeholder="Portfolio Link (Optional)">

            <button type="submit">Create Account</button>
        </form>
        
        <p class="login-text">Already have an account? <a href="../html/freelancer_login.html">Log In</a></p>
        <p class="apply-text">Apply as Client? <a href="register.html">Apply Here</a></p>
    </div>
    
</body>
</html>
