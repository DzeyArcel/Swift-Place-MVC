<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Profile</title>
    <link rel="stylesheet" href="/Swift-Place/public/css/clientedit.css">
</head>
<body>
<header class="topbar">
    <div class="logo-container">
        <img src="../photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
          <li><a href="index.php?controller=client&action=dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=client&action=profile"></i> Profile</a></li>
            <li><a href="clientedit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a></li>
            <a href="index.php?controller=auth&action=logout">Logout</a>
        </ul>
    </nav>
</header>

<section class="profile-content">
    <div class="container">
        <h2>Edit Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Bio:</label>
            <textarea name="bio"><?php echo htmlspecialchars($bio ?? ''); ?></textarea>

            <label>Contact:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($contact ?? ''); ?>">

            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($address ?? ''); ?>">

            <label>Current Profile Picture:</label>
            <?php if (!empty($profile_pic)): ?>
                <div class="current-pic">
                    <img src="public/uploads/<?php echo htmlspecialchars($profile_pic); ?>" alt="Current Profile Picture" width="120">
                </div>
            <?php endif; ?>

            <label>Upload New Profile Picture:</label>
            <input type="file" name="profile_pic">

            <div class="button-group">
                <button type="submit" name="update" class="update-btn">Save Changes</button>
                <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete your profile?');">Delete Profile</button>
            </div>
        </form>
    </div>
</section>

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
