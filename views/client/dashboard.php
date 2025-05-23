<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: /Swift-Place/views/auth/login.php");
    exit();

    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Swift-Place/public/css/clientdash.css">
</head>
<body>

<header>
    <div class="navbar">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
        </div>

       
        <nav class="nav-links">
        <a href="index.php?controller=client&action=Clientdashboard">Dashboard</a>
        <a href="index.php?controller=client&action=viewApplications">Applications</a>
        <a href="index.php?controller=job&action=myJobs" class="active">Your Jobs</a>
        <a href="index.php?controller=client&action=profile">Profile</a>
        <!-- Add this Job Tracking link -->
   
        <a href="index.php?controller=client&action=logout" class="logout">Logout</a>




            <!-- Notification Icon -->
            <div class="notification-icon" id="notification-icon">
                <a href="javascript:void(0);" onclick="openNotificationModal()">
                    <i class="fa fa-bell"></i>
                    <?php if (!empty($unread_notifications) && $unread_notifications > 0): ?>
                        <span class="notification-count"><?= $unread_notifications ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </div>
</header>


<!-- Notification Modal -->
<div id="notification-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeNotificationModal()">&times;</span>
        <h3>Notifications</h3>

        <?php if (!empty($notifications) && is_array($notifications)): ?>
            <ul class="notification-list">
                <?php foreach ($notifications as $notif): ?>
                    <li class="notification-item <?= $notif['is_read'] == 0 ? 'unread' : '' ?>">
                        <a href="index.php?controller=client&action=notifications&notification_id=<?= htmlspecialchars($notif['id']) ?>">
                            <?= htmlspecialchars($notif['message']) ?>
                        </a>
                        <span class="timestamp"><?= htmlspecialchars($notif['created_at']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No notifications yet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function openNotificationModal() {
        document.getElementById('notification-modal').style.display = 'block';
    }

    function closeNotificationModal() {
        document.getElementById('notification-modal').style.display = 'none';
    }

    // Optional: Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('notification-modal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
    <h1>Welcome, <?php echo htmlspecialchars($client_name); ?>!</h1>


        <h1>Meet Top Freelancers</h1>
        <p>Hire professionals to get your work done efficiently.</p>
        <a href="index.php?controller=job&action=postJob" class="post-job-link">Post Jobs</a>

    </div>
</section>

<!-- Services Section -->
<section class="recommendations">
    <h2>Freelancer's Services</h2>
    <div class="service-cards">
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <?php
                    $imagePath = !empty($service['media_path'])
                        ? htmlspecialchars($service['media_path'])
                        : 'public/photos/default_service.png';

                    $profilePic = !empty($service['profile_picture'])
                        ? 'public/uploads/' . htmlspecialchars($service['profile_picture'])
                        : 'public/uploads/default_profile.png';

                    $postedTime = Service::formatTimeSincePosted($service['created_at']);
                    $freelancerName = htmlspecialchars(($service['first_name'] ?? '') . ' ' . ($service['last_name'] ?? ''));
                    $avgRating = Service::getAverageRating($service['id']);
                ?>
                <div class="card">
                    <img class="service-img" src="<?= $imagePath ?>" alt="Service Image">
                    <div class="card-content">
                        <div class="freelancer-info">
                            <img src="<?= $profilePic ?>" class="profile-img" alt="Freelancer Photo">
                            <h4><?= $freelancerName ?></h4>
                        </div>

                        <h3><?= htmlspecialchars($service['service_title']) ?></h3>
                        <p><strong>Category:</strong> <?= htmlspecialchars($service['category']) ?></p>
                        <p><strong>Expertise:</strong> <?= htmlspecialchars($service['expertise']) ?></p>
                        <p><strong>Price:</strong> $<?= number_format($service['price'], 2) ?></p>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                        <p><strong>Rating:</strong> <?= $avgRating ? number_format($avgRating, 1) . ' ⭐' : 'No ratings yet' ?></p>
                        <p><strong>Posted:</strong> <?= $postedTime ?></p>

                        <!-- Rating Form -->
                        <form action="index.php?controller=client&action=rateService" method="post">
                            <input type="hidden" name="service_id" value="<?= htmlspecialchars($service['id']) ?>">
                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="rating" id="star<?= $i . '_' . $service['id'] ?>" value="<?= $i ?>" required>
                                    <label for="star<?= $i . '_' . $service['id'] ?>">★</label>
                                <?php endfor; ?>
                            </div>
                            <button type="submit">Submit Rating</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No services available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


<!-- Optional JS to disable button after submission -->
<script>
document.querySelectorAll(".rating-form").forEach(form => {
    form.addEventListener("submit", () => {
        form.querySelector("button[type=submit]").disabled = true;
    });
});
</script>






<!-- Job List Section -->
<section class="job-section">
    <h2>Explore Jobs</h2>
    <div class="job-grid">
        <?php while ($job = $jobs->fetch_assoc()): ?>
            <?php if ($job['status'] !== 'open') continue; // Skip non-open jobs ?>

            <?php
                $clientProfilePic = !empty($job['client_profile_picture'])
                    ? 'public/uploads/' . htmlspecialchars($job['client_profile_picture'])
                    : 'public/uploads/default_profile.png';
            ?>
            <div class="job-card">
                <div class="job-header">
                    <img src="<?= $clientProfilePic ?>" alt="Client Profile" class="client-profile-pic">
                    <div class="job-info">
                        <h3><?= htmlspecialchars($job['job_title']) ?></h3>
                        <p class="posted-time"><em>Posted: <?= Job::formatTimeSincePost($job['posted_at']) ?></em></p>
                    </div>
                </div>
                <p><strong>Poster/Client:</strong> <?= htmlspecialchars($job['poster_name']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($job['category']) ?></p>
                <p><strong>Salary:</strong> $<?= number_format($job['budget'], 2) ?></p>
                <p><strong>Deadline:</strong> <?= htmlspecialchars($job['deadline']) ?></p>
                <p><strong>Skills:</strong> <?= htmlspecialchars($job['required_skill']) ?></p>
                <p><strong>Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars($job['experience_level']) ?></p>
                <p class="desc"><?= nl2br(htmlspecialchars($job['job_description'])) ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>




<!-- Footer -->
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

<!-- JS for Notifications Modal -->
<script>
    function openNotificationModal() {
        document.getElementById('notification-modal').style.display = 'block';
    }

    function closeNotificationModal() {
        document.getElementById('notification-modal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === document.getElementById('notification-modal')) {
            closeNotificationModal();
        }
    }
</script>

</body>
</html> 