<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Swift-Place/public/css/freelancedash.css">
    <!-- Make sure Font Awesome is included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php
// Fetch accepted application for the logged-in freelancer
$application = null;
if (isset($_SESSION['freelancer_id'])) {
    require_once 'models/Application.php'; // Make sure this path is correct based on your structure
    $application = Application::getAcceptedApplicationByFreelancerId($_SESSION['freelancer_id']);
}
?>





<header>
    <div class="navbar">
        <!-- Logo -->
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
           
        </div>



        <!-- Navigation Links -->
        <nav class="nav-links">
            <a href="index.php?controller=freelancer&action=myServices"><i class="fas fa-briefcase"></i> Services</a>

            <?php if (isset($application['id'])): ?>
                <a href="index.php?controller=freelancer&action=viewJobTracking&application_id=<?= $application['id'] ?>">
                    <i class="fas fa-tasks"></i> Job Tracking
                </a>
            <?php else: ?>
                <span class="disabled-link"><i class="fas fa-tasks"></i> Job Tracking</span>
            <?php endif; ?>

            <a href="index.php?controller=freelancer&action=profile"><i class="fas fa-user"></i> Profile</a>
            <a href="index.php?controller=freelancer&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>

            <!-- Notifications -->
            <a href="javascript:void(0)" onclick="openNotificationModal()" class="notification-icon">
                <i class="fas fa-bell"></i>
                <?php if (isset($unread_notifications) && $unread_notifications > 0): ?>
                    <span class="notification-count"><?php echo $unread_notifications; ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
</header>




  
    <!-- Notification Modal -->
    <div id="notification-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeNotificationModal()">&times;</span>
        <h3>Notifications</h3>
        <?php if (!empty($notifications)) { ?>
            <ul>
                <?php foreach ($notifications as $row) { ?>
                    <li class="notification-item <?= $row['is_read'] == 0 ? 'unread' : ''; ?>">
                        <a href="index.php?controller=freelancer&action=notifications&notification_id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['message']); ?>
                        </a>
                        <span class="timestamp"><?= htmlspecialchars($row['created_at']); ?></span>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No notifications yet.</p>
        <?php } ?>
    </div>
</div>



    <script>
        // Function to open the notification modal
        function openNotificationModal() {
            document.getElementById('notification-modal').style.display = 'block';
        }

        // Function to close the notification modal
        function closeNotificationModal() {
            document.getElementById('notification-modal').style.display = 'none';
        }

        // Close modal if user clicks outside of the modal content
        window.onclick = function(event) {
            if (event.target == document.getElementById('notification-modal')) {
                closeNotificationModal();
            }
        }
    </script>
    


    <section class="hero">
        <div class="hero-content">
            <h1>Welcome, <?php echo htmlspecialchars($freelancer_name); ?>!</h1>
            <p>Find the best freelance projects and start working today.</p>
  
            <a href="index.php?controller=service&action=postForm" class="post-service-link">Post Services</a>


        </div>
    </section>



    <section class="job-listings">
    <h2>Available Jobs</h2>
    <div class="job-cards">
        <?php 
        $hasOpenJobs = false;
        foreach ($jobs as $job): 
            if ($job['status'] !== 'open') continue;
            $hasOpenJobs = true;
            $postedAgo = Job::formatTimeSincePost($job['posted_at']);
            $clientProfilePic = !empty($job['client_profile_picture'])
                ? 'public/uploads/' . htmlspecialchars($job['client_profile_picture'])
                : 'public/uploads/default_profile.png';
        ?>
        
        <div class="job-post">
            <div class="job-header">
                <img src="<?= $clientProfilePic ?>" alt="Client Profile" class="client-profile-pic">
                <div class="job-info">
                    <h3><?= htmlspecialchars($job['job_title']) ?></h3>
                    <p class="posted-time"><em>Posted: <?= $postedAgo ?></em></p>
                    <p><strong>Posted by:</strong> <?= htmlspecialchars($job['poster_name']) ?></p>
                </div>
            </div>
            
            <p class="desc"><?= htmlspecialchars($job['job_description']) ?></p>
            <p><strong>Skills:</strong> <?= htmlspecialchars($job['required_skill']) ?></p>
            <p><strong>Budget:</strong> $<?= htmlspecialchars($job['budget']) ?></p>
            <p><strong>Deadline:</strong> <?= htmlspecialchars($job['deadline']) ?></p>
            <p><strong>Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
            <p><strong>Experience:</strong> <?= htmlspecialchars($job['experience_level']) ?></p>

            <form action="index.php?controller=freelancerApplication&action=showApplicationForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                <button class="apply-btn" type="submit">Apply</button>
            </form>
        </div>
        <?php endforeach; ?>

        <?php if (!$hasOpenJobs): ?>
            <p>No available jobs at the moment.</p>
        <?php endif; ?>
    </div>
</section>




<section class="service-listings">
    <h2>Explore Freelance Services</h2>
    <div class="service-cards">
        <?php if (count($services) > 0): ?>
            <?php foreach ($services as $service): ?>
                <?php
                    // Determine Profile Picture Path
                    $profilePic = !empty($service['profile_picture'])
                        ? 'public/uploads/' . htmlspecialchars($service['profile_picture'])
                        : 'public/uploads/default_profile.png';

                    // Determine Service Image Path
                    $serviceImage = !empty($service['media_path'])
        ? htmlspecialchars($service['media_path'])
        : 'public/uploads/default_service.png';  // <-- Default service image here

                    // Freelancer Name
                    $freelancerName = htmlspecialchars(($service['first_name'] ?? '') . ' ' . ($service['last_name'] ?? ''));
                ?>
                <div class="service-card">
                    <!-- Service Image Section -->
                    <div class="service-img-container">
                        <?php if ($serviceImage): ?>
                            <img src="<?= $serviceImage ?>" alt="Service Image" class="service-img">
                        <?php else: ?>
                            <div class="placeholder-img">No Image</div>
                        <?php endif; ?>
                    </div>

                    <!-- Freelancer Profile Section -->
                    <div class="profile-section">
                        <!-- Profile Picture -->
                        <div class="profile-pic">
                            <img src="<?= htmlspecialchars($profilePic) ?>" alt="Profile Picture">
                        </div>

                        <!-- Freelancer Name -->
                        <h4 class="freelancer-name"><?= $freelancerName ?></h4>
                    </div>

                    <!-- Service Information -->
                    <div class="service-info">
                        <p class="title"><?= htmlspecialchars($service['service_title']) ?></p>
                        <p class="desc"><?= htmlspecialchars($service['description']) ?></p>
                        <p class="category">Category: <?= htmlspecialchars($service['category']) ?></p>
                        <p class="skills">Skills: <?= htmlspecialchars($service['skills']) ?></p>
                        <p class="expertise">Expertise: <?= htmlspecialchars($service['expertise']) ?></p>
                        <p class="posted-time"><strong>Posted:</strong> <?= Service::formatTimeSincePosted($service['created_at']) ?></p>
                        <p class="tags">Tags: <?= htmlspecialchars($service['tags']) ?></p>
                        <p class="price">Price: $<?= number_format($service['price'], 2) ?></p>

                        <!-- Rating -->
                        <p class="rating">
                            <?php if (isset($service['rating']) && $service['rating'] !== null): ?>
                                Rating:
                                <?= str_repeat("★", floor($service['rating'])) ?>
                                <?= str_repeat("☆", 5 - floor($service['rating'])) ?>
                                (<?= number_format($service['rating'], 1) ?>)
                            <?php else: ?>
                                No ratings yet
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No services posted yet.</p>
        <?php endif; ?>
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
            <p>&copy; 2024 SwiftPlace - Privacy - Terms - Sitemap</p>
        </div>
    </footer>
</body>
</html>
