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
                <a href="index.php?controller=client&action=dashboard">Dashboard</a>
                <a href="index.php?controller=client&action=postJob">Post Job</a>
                <a href="index.php?controller=client&action=profile">Profile</a>
                <a href="index.php?controller=client&action=logout">Logout</a>
            </nav>
        </div>
    </header>

    <section class="notifications">
        <h2>All Notifications</h2>
        <?php if ($notifications->num_rows > 0): ?>
            <ul>
                <?php while ($row = $notifications->fetch_assoc()): ?>
                    <li class="notification-item <?= $row['is_read'] == 0 ? 'unread' : ''; ?>">
                        <div class="notification-content">
                            <a href="index.php?controller=client&action=notifications&notification_id=<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['message']) ?>
                            </a>
                            <span class="timestamp"><?= htmlspecialchars($row['created_at']) ?></span>
                        </div>
                        <a href="index.php?controller=client&action=notifications&delete_id=<?= $row['id'] ?>" class="delete-notification" onclick="return confirm('Delete this notification?')">Delete</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No notifications yet.</p>
        <?php endif; ?>
    </section>
</body>
</html>
