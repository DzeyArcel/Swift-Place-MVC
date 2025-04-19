<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Profile</title>
    <link rel="stylesheet" href="public/css/freelanceprofile.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<header class="topbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
            <li><a href="index.php?controller=freelancer&action=dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=freelancer&action=profile"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="index.php?controller=freelancer&action=editProfile"><i class="fas fa-edit"></i> Edit Profile</a></li>
            <li><a href="index.php?controller=auth&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<!-- Profile Content -->
<div class="profile-content">
    <h1>Freelancer Profile</h1>
    
    <?php
$picture = !empty($profile['profile_picture']) ? 'public/uploads/' . $profile['profile_picture'] : 'public/uploads/no-profile-picture-icon-35.png';
?>
<div class="profile-pic">
    <img src="<?= htmlspecialchars($picture) ?>" alt="Profile Picture">
</div>


    <h2><?= htmlspecialchars($basicInfo['first_name'] . ' ' . $basicInfo['last_name']) ?></h2>
    <p><?= htmlspecialchars($basicInfo['email']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($basicInfo['job_category']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone'] ?? 'Not set') ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($profile['address'] ?? 'Not set') ?></p>
    <p><strong>Skills:</strong> <?= htmlspecialchars($profile['skills'] ?? 'Not set') ?></p>
    <p><strong>Experience:</strong> <?= htmlspecialchars($profile['experience'] ?? 'Not set') ?></p>
    <p><strong>Bio:</strong> <?= htmlspecialchars($profile['bio'] ?? 'Not set') ?></p>
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
