<?php
$phone = $profile['phone'] ?? '';
$address = $profile['address'] ?? '';
$skills = $profile['skills'] ?? '';
$experience = $profile['experience'] ?? '';
$bio = $profile['bio'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="public/css/freelanceedit.css">
</head>
<body>

<header class="topbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
            
            <li><a href="javascript:history.back()">&#8617;</a></li>
            <li><a href="index.php?controller=auth&action=logout" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="Edit">
    <div class="profile-content">
    <?php
$picture = !empty($profile['profile_picture']) 
    ? 'public/uploads/' . $profile['profile_picture'] 
    : 'public/uploads/default_profile.png';
?>

<div class="profile-pic" style="display: flex; justify-content: center; align-items: center; height: 200px;">
    <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden;">
        <img src="<?= htmlspecialchars($picture) ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
</div>


        <h1>Edit Profile</h1>

        <form method="POST" enctype="multipart/form-data">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

            <label>Address:</label>
            <input type="text" name="address" value="<?= htmlspecialchars($address) ?>" required>

            <label>Skills:</label>
            <input type="text" name="skills" value="<?= htmlspecialchars($skills) ?>" required>

            <label>Experience:</label>
            <textarea name="experience" required><?= htmlspecialchars($experience) ?></textarea>

            <label>Bio:</label>
            <textarea name="bio" required><?= htmlspecialchars($bio) ?></textarea>

            <label>Change Profile Picture:</label>
            <input type="file" name="profile_picture" accept="image/*">

            <button type="submit" name="save">Save Profile</button>

            <?php if (!empty(array_filter($profile))) : ?>
                <button type="submit" name="delete" class="delete-btn">Delete Profile</button>
            <?php endif; ?>
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
