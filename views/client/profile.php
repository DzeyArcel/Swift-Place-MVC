<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/clientprofile.css">
</head>
<body>

<header class="topbar">
    <div class="logo-container">
        <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
        <li><a href="index.php?controller=client&action=Clientdashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=client&action=profile"></i> Profile</a></li>
            <li><a href="index.php?controller=client&action=edit_profile"><i class="fas fa-edit"></i> Edit Profile</a></li>
            <li><a href="index.php?controller=client&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

        </ul>
    </nav>
</header>

<?php
// Extract data safely to avoid undefined variable warnings
$first_name = $user['first_name'] ?? '';
$last_name = $user['last_name'] ?? '';
$email = $user['email'] ?? '';
$bio = $profile['bio'] ?? '';
$contact = $profile['contact'] ?? '';
$address = $profile['address'] ?? '';
$profile_pic = $profile['profile_pic'] ?? 'default.jpg';
?>

<div class="client-profile-wrapper">
<h1>Client Profile</h1>
    <div class="profile-pic-container">
        
        <img src="public/uploads/<?php echo htmlspecialchars($profile_pic); ?>" 
             alt="Profile Picture" 
             class="profile-pic">
    </div>

    <h2 class="client-name"><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h2>
    <p class="client-email"><?php echo htmlspecialchars($email); ?></p>

    <div class="profile-info">
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($contact); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($bio)); ?></p>
    </div>
</div>



<footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Pricing</a>
                <a href="#">About Us</a>
                <a href="#">Features</a>
                <a href="#">Help Center</a>
                <a href="#">Contact Us</a>
                <a href="#">FAQ</a>
                <a href="#">Careers</a>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <p>&copy; 2024 Swift Place - Privacy - Terms - Sitemap</p>
        </div>
    </footer>

</body>
</html>
