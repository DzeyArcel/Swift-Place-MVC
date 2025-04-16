<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/freelanceservicedit.css">
</head>
<body>

<header>
    <div class="navbar">
        <div class="logo-container">
            <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
        <nav>
            <a href="index.php?controller=freelancer&action=dashboard">Dashboard</a>
            <a href="index.php?controller=freelancer&action=myServices">Your Posted Services</a>
            <a href="index.php?controller=freelancer&action=profile">Profile</a>
            <a href="index.php?controller=freelancer&action=logout">Logout</a>
        </nav>
    </div>
</header>
    
<section class="edit-service">
    <h2>Edit Service</h2>
    <form action="index.php?controller=service&action=updateService" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($service['id']) ?>">

        <label for="service_title">Service Title</label>
        <input type="text" name="service_title" id="service_title" value="<?= htmlspecialchars($service['service_title']) ?>" required>

        <label for="category">Category</label>
        <select name="category" id="category" required>
            <option value="Web Development" <?= $service['category'] == 'Web Development' ? 'selected' : '' ?>>Web Development</option>
            <option value="Graphic Design" <?= $service['category'] == 'Graphic Design' ? 'selected' : '' ?>>Graphic Design</option>
            <option value="Digital Marketing" <?= $service['category'] == 'Digital Marketing' ? 'selected' : '' ?>>Digital Marketing</option>
            <option value="Content Writing" <?= $service['category'] == 'Content Writing' ? 'selected' : '' ?>>Content Writing</option>
        </select>

        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($service['description']) ?></textarea>

        <label for="skills">Skills</label>
        <input type="text" name="skills" id="skills" value="<?= htmlspecialchars($service['skills']) ?>" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="<?= htmlspecialchars($service['price']) ?>" required>

        <label for="delivery_time">Delivery Time (days)</label>
        <input type="number" name="delivery_time" id="delivery_time" value="<?= htmlspecialchars($service['delivery_time']) ?>" required>

        <label for="expertise">Expertise Level</label>
        <select name="expertise" id="expertise" required>
            <option value="Beginner" <?= $service['expertise'] == 'Beginner' ? 'selected' : '' ?>>Beginner</option>
            <option value="Intermediate" <?= $service['expertise'] == 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
            <option value="Expert" <?= $service['expertise'] == 'Expert' ? 'selected' : '' ?>>Expert</option>
        </select>

        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" value="<?= htmlspecialchars($service['tags']) ?>" required>

        <label for="media_path">Image URL (Optional)</label>
        <input type="text" name="media_path" id="media_path" value="<?= htmlspecialchars($service['media_path']) ?>">

        <button type="submit">Update Service</button>
    </form>
</section>

</body>
</html>
