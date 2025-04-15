<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/freelanceservicedit.css"> <!-- External CSS file -->
</head>
<body>
<header>
        <div class="navbar">
            <div class="logo-container">
                <img src="../photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
            </div>
            <nav>
                <a href="freelancer_dashboard.php">Dashboard</a>
                <a href="my_services.php">Your Posted Services</a>
                <a href="../php/freelance_profile.php">Profile</a>
                <a href="../php/logout.php">Logout</a>
            </nav>
        </div>
</header>
    
<section class="edit-service">
    <h2>Edit Service</h2>
    <form action="edit_service.php?id=<?= $service_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="service_title">Service Title</label>
        <input type="text" name="service_title" id="service_title" value="<?= htmlspecialchars($row['service_title']); ?>" required>

        <label for="category">Category</label>
        <select name="category" id="category" required>
            <option value="Web Development" <?= $row['category'] == 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
            <option value="Graphic Design" <?= $row['category'] == 'Graphic Design' ? 'selected' : ''; ?>>Graphic Design</option>
            <option value="Digital Marketing" <?= $row['category'] == 'Digital Marketing' ? 'selected' : ''; ?>>Digital Marketing</option>
            <option value="Content Writing" <?= $row['category'] == 'Content Writing' ? 'selected' : ''; ?>>Content Writing</option>
            <!-- Add more options as per your categories -->
        </select>

        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($row['description']); ?></textarea>

        <label for="skills">Skills</label>
        <input type="text" name="skills" id="skills" value="<?= htmlspecialchars($row['skills']); ?>" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="<?= htmlspecialchars($row['price']); ?>" required>

        <label for="delivery_time">Delivery Time (days)</label>
        <input type="number" name="delivery_time" id="delivery_time" value="<?= htmlspecialchars($row['delivery_time']); ?>" required>

        <label for="expertise">Expertise Level</label>
        <select name="expertise" id="expertise" required>
            <option value="Beginner" <?= $row['expertise'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
            <option value="Intermediate" <?= $row['expertise'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
            <option value="Expert" <?= $row['expertise'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
        </select>

        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" value="<?= htmlspecialchars($row['tags']); ?>" required>

        <label for="media_path">Image URL (Optional)</label>
        <input type="text" name="media_path" id="media_path" value="<?= htmlspecialchars($row['media_path']); ?>">

        <button type="submit">Update Service</button>
    </form>
</section>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
