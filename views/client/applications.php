<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applications Received</title>
    <link rel="stylesheet" href="public/css/client_applications.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Swift Place" class="logo-img">
    </div>
    <input type="text" placeholder="Search for services..." class="search-bar">
    <nav class="nav-links">
        <a href="index.php?controller=client&action=Clientdashboard">Dashboard</a>
        <a href="index.php?controller=client&action=viewApplications" class="active">Applications</a>
        <a href="index.php?controller=job&action=myJobs">Your Jobs</a>
        <a href="index.php?controller=client&action=profile">Profile</a>
        <a href="index.php?controller=client&action=logout" class="logout">Logout</a>
    </nav>
</header>

<main class="container">
    <div class="container">
        <h2 class="section-title">Applications for Your Jobs</h2>

        <div class="content-wrapper">
            <!-- Pending Applications -->
            <div class="applications-list">
            <h3>Pending Applications</h3>
<?php if (count($pendingApplications) > 0): ?>
    <div class="card-grid">
    <?php foreach ($pendingApplications as $app): ?>
        <div class="app-card">
            <h3><?= htmlspecialchars($app['freelancer_name']) ?> applied to 
                <span class="job-title">"<?= htmlspecialchars($app['job_title']) ?>"</span>
            </h3>

            <p><strong>Status:</strong> <?= ucfirst($app['status']) ?></p>

            <p><strong>Cover Letter:</strong></p>
            <p><?= nl2br(htmlspecialchars($app['cover_letter'])) ?></p>

            <p><strong>Experience:</strong> <?= nl2br(htmlspecialchars($app['experience_summary'])) ?></p>
            <p><strong>Skills:</strong> <?= nl2br(htmlspecialchars($app['skills_used'])) ?></p>
            <p><strong>Clarifications:</strong> <?= nl2br(htmlspecialchars($app['questions_clarifications'])) ?></p>
            <p><strong>Availability:</strong> <?= htmlspecialchars($app['availability']) ?> hrs/week</p>

            <p><strong>Attachment:</strong> 
                <?php if (!empty($app['attachment'])): ?>
                    <a href="public/uploads/<?= htmlspecialchars($app['attachment']) ?>" class="view-btn" target="_blank">View Attachment</a>
                <?php else: ?>
                    None
                <?php endif; ?>
            </p>

            <a href="index.php?controller=freelancer&action=viewProfile&freelancer_id=<?= $app['freelancer_id'] ?>" 
               data-id="<?= $app['freelancer_id'] ?>" 
               class="view-profile-btn">
               View Profile
            </a>

            <div class="action-buttons">
                <a href="index.php?controller=application&action=acceptApplication&application_id=<?= $app['id'] ?>" 
                   class="accept-btn" 
                   onclick="return confirm('Are you sure you want to accept this application? This will reject all others.')">Accept</a>

                <form action="index.php?controller=application&action=rejectApplication" method="post" style="display:inline;">
                    <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                    <button type="submit" class="reject-btn">Reject</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="no-applications">No pending applications.</p>
<?php endif; ?>

            </div>

            <!-- Accepted Applications -->
            <div class="accepted-applications-list">
                <h3>Accepted Applications</h3>
                <?php if (count($acceptedApplications) > 0): ?>
                    <div class="card-grid">
                    <?php foreach ($acceptedApplications as $app): ?>
                        <div class="app-card accepted">
                            <h3><?= htmlspecialchars($app['freelancer_name']) ?> was accepted for 
                                <span class="job-title">"<?= htmlspecialchars($app['job_title']) ?>"</span>
                            </h3>

                            <p><strong>Status:</strong> Accepted</p>

                            <a href="index.php?controller=freelancer&action=viewProfile&freelancer_id=<?= $app['freelancer_id'] ?>" 
                               data-id="<?= $app['freelancer_id'] ?>" 
                               class="view-profile-btn">
                               View Profile
                            </a>
   

   <a href="index.php?controller=jobtracking&action=jobTracking&job_id=<?= $app['job_id'] ?>" class="track-btn">Go to Job Tracking</a>


                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-applications">No accepted applications yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="freelancerProfileModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div id="modal-body">
                <!-- AJAX-loaded profile goes here -->
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const profileButtons = document.querySelectorAll(".view-profile-btn");
    const modal = document.getElementById("freelancerProfileModal");
    const closeBtn = document.querySelector(".close-btn");

    profileButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault(); // stop link from redirecting
            const freelancerId = button.getAttribute("data-id");

            fetch(`index.php?controller=freelancer&action=viewProfile&freelancer_id=${freelancerId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("modal-body").innerHTML = data;
                    modal.classList.remove("hidden");
                    modal.classList.add("active");
                })
                .catch(error => console.error("Error loading profile:", error));
        });
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("active");
        }
    });
});
</script>

</html>
