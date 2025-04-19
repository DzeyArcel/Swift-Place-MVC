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
    <h2 class="section-title">Applications for Your Jobs</h2>

    <?php if (count($applications) > 0): ?>
        <div class="card-grid">
            <?php foreach ($applications as $app): ?>
                <div class="app-card">
                    <h3><?= htmlspecialchars($app['freelancer_name']) ?> applied to 
                        <span class="job-title">"<?= htmlspecialchars($app['job_title']) ?>"</span>
                    </h3>

                    <p><strong>Cover Letter:</strong></p>
                    <p class="cover-letter"><?= nl2br(htmlspecialchars($app['cover_letter'])) ?></p>

                    <p><strong>Experience Summary:</strong></p>
                    <p class="exp"><?= nl2br(htmlspecialchars($app['experience_summary'])) ?></p>

                    <p><strong>Skills Used:</strong></p>
                    <p class="skills"><?= nl2br(htmlspecialchars($app['skills_used'])) ?></p>

                    <?php if (!empty($app['attachment'])): ?>
                        <a href="public/uploads/<?= htmlspecialchars($app['attachment']) ?>" class="view-btn" target="_blank">View Attachment</a>
                    <?php else: ?>
                        <span class="no-attachment">No attachment</span>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <form action="index.php?controller=client&action=acceptApplication" method="post" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <button type="submit" class="accept-btn">Accept</button>
                        </form>
                        <form action="index.php?controller=client&action=rejectApplication" method="post" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-applications">No applications received yet.</p>
    <?php endif; ?>
</main>

</body>
</html>
