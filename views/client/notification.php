<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Notifications</title>
    <link rel="stylesheet" href="public/css/clientnotif.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo-container">
                <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
            </div>
            <nav>
   <a href="index.php?controller=client&action=Clientdashboard"><i class="fas fa-home"></i> Dashboard</a></li>
   <a href="index.php?controller=job&action=myJobs">Your Posted Jobs</a>
   <a href="index.php?controller=client&action=profile">Profile</a>
    <a href="index.php?controller=client&action=notifications">
        Notifications
        <?php if (!empty($unread_notifications) && $unread_notifications > 0): ?>
            <span class="notification-count"><?= $unread_notifications ?></span>
        <?php endif; ?>
    </a>
    <a href="index.php?controller=client&action=logout">Logout</a>
</nav>

        </div>
    </header>
    <section class="notifications">
    <h2>All Notifications</h2>
    <?php if (!empty($notifications)): ?>
        <ul>
            <?php foreach ($notifications as $row): ?>
                <li class="notification-item <?= $row['is_read'] == 0 ? 'unread' : ''; ?>">
                    <div class="notification-content">
                        <a href="index.php?controller=client&action=notifications&notification_id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['message']) ?>
                        </a>
                        <span class="timestamp"><?= htmlspecialchars($row['created_at']) ?></span>
                    </div>
                    <!-- Fixed the incorrect variable name here -->
                    <a href="index.php?controller=client&action=notifications&delete_id=<?= $row['id'] ?>" 
                       class="delete-notification" 
                       onclick="return confirm('Delete this notification?')">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No notifications yet.</p>
    <?php endif; ?>
</section>


</body>
</html>
