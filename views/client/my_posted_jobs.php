<!-- views/client/my_posted_jobs.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Posted Jobs</title>
    <link rel="stylesheet" href="public/css/clientjobpost.css">
</head>
<body>
<header>
    <div class="navbar">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
        <input type="text" placeholder="Search for services...">
        <nav>
        <li><a href="index.php?controller=client&action=Clientdashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <a href="/views/client/client_view_application.php">Application</a>
            <a href="index.php?controller=job&action=myJobs">Your Posted Jobs</a>
            <a href="index.php?controller=client&action=profile">Profile</a>
            <li><a href="index.php?controller=client&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>


            <div class="notification-icon" id="notification-icon">
                <a href="javascript:void(0)" onclick="openNotificationModal()">
                    <i class="fa fa-bell"></i>
                    <?php if ($unread_notifications > 0): ?>
                        <span class="notification-count"><?= $unread_notifications ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </div>
</header>

    <h2>My Posted Jobs</h2>

    <?php if ($jobs->num_rows > 0): ?>
        <div class="jobs-list">
            <?php while ($row = $jobs->fetch_assoc()): ?>
                <div class="job-card">
                    <h3><?= htmlspecialchars($row['job_title']) ?></h3>
                    <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
                    <p><strong>Budget:</strong> $<?= htmlspecialchars($row['budget']) ?></p>
                    <p><strong>Deadline:</strong> <?= htmlspecialchars($row['deadline']) ?></p>
                    <p><strong>Type:</strong> <?= htmlspecialchars($row['job_type']) ?></p>
                    <p><strong>Experience Level:</strong> <?= htmlspecialchars($row['experience_level']) ?></p>
                    <p><?= nl2br(htmlspecialchars($row['job_description'])) ?></p>

                    <a href="index.php?controller=job&action=deleteJob&id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    <a class="edit-btn" href="index.php?controller=job&action=editJob&id=<?php echo $row['id']; ?>">Edit</a>


                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>You haven't posted any jobs yet.</p>
    <?php endif; ?>
</body>
</html>
