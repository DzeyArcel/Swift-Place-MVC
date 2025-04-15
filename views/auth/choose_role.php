<!-- views/auth/choose_role.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choose Your Role</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/choosestyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Company Logo" class="logo-img">
        </div>
    </header>

    <main>
        <h2 class="title">Join as a client or freelancer</h2>

        <form action="/Swift-Place/routes/auth_route.php?action=chooseRole" method="post" id="roleForm">
            <div class="options">
                <label class="option">
                    <input type="radio" name="user_type" value="client">
                    <div class="card">
                        <i class="fa-solid fa-user-tie"></i>
                        <p><strong>Client:</strong> Hire top talent.</p>
                    </div>
                </label>

                <label class="option">
                    <input type="radio" name="user_type" value="freelancer">
                    <div class="card">
                        <i class="fa-solid fa-laptop-code"></i>
                        <p><strong>Freelancer:</strong> Find work and grow your career.</p>
                    </div>
                </label>
            </div>

            <button type="submit" class="create-account" id="joinBtn" disabled>Join Now</button>
        </form>

        <p class="login-text">Already have an account? <a href="/Swift-Place/views/auth/login.php">Log In as Client</a> / 
        <a href="/Swift-Place/views/auth/freelancer_login.php">Log In as Freelancer</a></p>
        <p class="login-text"><a href="/Swift-Place/index.php">Go back Home</a></p>
    </main>

    <script src="/Swift-Place/public/js/choosescript.js"></script>
</body>
</html>
