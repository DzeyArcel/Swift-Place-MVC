<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Swift-Place/public/css/freelancedash.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo-container">
                <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
            </div>
            <input type="text" placeholder="Search for services...">
            <nav>
            <a href="index.php?controller=freelancer&action=myServices">Your Posted Services</a>

            <li><a href="index.php?controller=freelancer&action=profile"><i class="fas fa-user"></i> Profile</a></li>


                <li><a href="index.php?controller=client&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

                <!-- Notification icon with modal -->
                <div class="notification-icon" id="notification-icon">
                    <a href="javascript:void(0)" onclick="openNotificationModal()">
                        <i class="fa fa-bell"></i>
                        <?php if ($unread_notifications > 0) { ?>
                            <span class="notification-count"><?php echo $unread_notifications; ?></span>
                        <?php } ?>
                    </a>
                </div>
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
                    <li class="notification-item <?php echo $row['is_read'] == 0 ? 'unread' : ''; ?>">
                        <a href="index.php?controller=freelancer&action=notifications&notification_id=<?= $row['id'] ?>">
                            <?php echo htmlspecialchars($row['message']); ?>
                        </a>
                        <span class="timestamp"><?php echo htmlspecialchars($row['created_at']); ?></span>
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
        <?php foreach ($jobs as $job): 
            $postedAgo = Job::formatTimeSincePost($job['posted_at']);
        ?>
            <div class="job-post">
                <h3><?= htmlspecialchars($job['job_title']) ?></h3>
                <p class="desc"><?= htmlspecialchars($job['job_description']) ?></p>
                <p><strong>Skills:</strong> <?= htmlspecialchars($job['required_skill']) ?></p>
                <p><strong>Budget:</strong> $<?= htmlspecialchars($job['budget']) ?></p>
                <p><strong>Deadline:</strong> <?= htmlspecialchars($job['deadline']) ?></p>
                <p><strong>Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars($job['experience_level']) ?></p>
                <p><strong>Posted by:</strong> <?= htmlspecialchars($job['poster_name']) ?></p>
                <p class="posted-time"><em>Posted: <?= $postedAgo ?></em></p>

                <form action="index.php?controller=freelancerApplication&action=showApplicationForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                    <button class="apply-btn" type="submit">Apply</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>




<section class="service-listings">
    <h2>Explore Freelance Services</h2>
    <div class="service-cards">
        <?php if (count($services) > 0): ?>
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <?php if (!empty($service['media_path'])): ?>
                        <img src="<?= htmlspecialchars($service['media_path']) ?>" alt="Service Image" class="service-img">
                    <?php else: ?>
                        <div class="placeholder-img">No Image</div>
                    <?php endif; ?>

                    <div class="service-info">
                        <h4><?= htmlspecialchars(($service['first_name'] ?? '') . ' ' . ($service['last_name'] ?? '')) ?></h4>

                        <p class="title"><?= htmlspecialchars($service['service_title']) ?></p>
                        <p class="desc"><?= htmlspecialchars($service['description']) ?></p>
                        <p class="category">Category: <?= htmlspecialchars($service['category']) ?></p>
                        <p class="skills">Skills: <?= htmlspecialchars($service['skills']) ?></p>
                        <p class="expertise">Expertise: <?= htmlspecialchars($service['expertise']) ?></p>
                        <p class="posted-time"><strong>Posted:</strong> <?= Service::formatTimeSincePosted($service['created_at']) ?></p>
                        <p class="tags">Tags: <?= htmlspecialchars($service['tags']) ?></p>
                        <p class="price">Price: $<?= number_format($service['price'], 2) ?></p>
                        <p class="rating">
                            <?= isset($service['rating']) ? "Rating: ★ " . number_format($service['rating'], 1) : "No ratings yet" ?>
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
