<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posted Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Swift-Place/public/css/freelancerservicepost.css"> <!-- Your custom styles -->
</head>
<body>
   <header class="topbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
            <li><a href="javascript:history.back()">&#8617;</a></li>
            <li><a href="index.php?controller=freelancer&action=profile"><i class="fas fa-edit"></i>Profile</a></li>
            <li><a href="index.php?controller=auth&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

    <section class="my-services">
    <h2>My Posted Services</h2>

    <?php if (!empty($services) && count($services) > 0): ?>
        <div class="services-list">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <!-- Check for media (image) path -->
                    <?php if (!empty($service['media_path']) && file_exists($service['media_path'])): ?>
                        <img src="<?= htmlspecialchars($service['media_path']); ?>" alt="Service Image" class="service-img">
                    <?php else: ?>
                        <div class="placeholder-img">No Image</div>
                    <?php endif; ?>

                    <div class="service-info">
                        <h4><?= htmlspecialchars($service['freelancer_name']); ?></h4>
                        <p class="title"><?= htmlspecialchars($service['service_title']); ?></p>
                        <p class="desc"><?= nl2br(htmlspecialchars($service['description'])); ?></p>
                        <p class="category"><strong>Category:</strong> <?= htmlspecialchars($service['category']); ?></p>
                        <p class="expertise"><strong>Expertise:</strong> <?= htmlspecialchars($service['skills']); ?></p>
                        <p class="price"><strong>Price:</strong> $<?= number_format($service['price'], 2); ?></p>
                        <p class="rating"><strong>Rating:</strong> ★ <?= number_format($service['rating'], 1); ?></p>
                        <a href="index.php?controller=service&action=editService&id=<?= $service['id']; ?>" class="edit-link">Edit</a>

                        |
                        <a href="index.php?controller=service&action=deleteService&id=<?= $service['id'] ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>You haven't posted any services yet.</p>
    <?php endif; ?>
</section>

</body>
</html>


