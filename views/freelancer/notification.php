<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Notifications</title>
    <link rel="stylesheet" href="/public/css/freelancernotif.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo-container">
                <img src="/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
            </div>
            <nav>
                <a href="/index.php?controller=freelancer&action=dashboard">Dashboard</a>
                <a href="/index.php?controller=freelancer&action=myServices">Your Posted Services</a>
                <a href="/index.php?controller=freelancer&action=profile">Profile</a>
                <a href="/index.php?controller=freelancer&action=logout">Logout</a>
            </nav>
        </div>
    </header>

    <section class="notifications">
        <h2>All Notifications</h2>
        <?php if (!empty($notifications)) { ?>
            <ul>
                <?php foreach ($notifications as $notif) { ?>
                    <li class="notification-item <?= $notif['is_read'] == 0 ? 'unread' : '' ?>">
                        <div class="notification-content">
                            <a href="/index.php?controller=freelancer&action=markNotification&notification_id=<?= $notif['id'] ?>">
                                <?= htmlspecialchars($notif['message']) ?>
                            </a>
                            <span class="timestamp"><?= htmlspecialchars($notif['created_at']) ?></span>
                        </div>
                        <a href="/index.php?controller=freelancer&action=deleteNotification&notification_id=<?= $notif['id'] ?>" 
                           class="delete-notification"
                           onclick="return confirm('Are you sure you want to delete this notification?')">Delete</a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No notifications yet.</p>
        <?php } ?>
    </section>
</body>
</html>
