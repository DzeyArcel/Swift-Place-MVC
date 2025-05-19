<!DOCTYPE html>
<html>
<head>
    <title>Post a Service</title>
    <link rel="stylesheet" href="public/css/post-service.css">
    <style>
        .rating-stars span {
            font-size: 24px;
            color: gold;
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <ul>
            <li><a href="javascript:history.back()">&#8617;</a></li>
            <li><a href="index.php?controller=auth&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

    <div class="form-container">
        <h2>Post a New Service</h2>
        <form action="index.php?controller=service&action=submit" method="post" enctype="multipart/form-data">
            <input type="text" name="service_title" placeholder="Service Title" required><br>

            <label for="category">Category:</label><br>
            <input type="text" name="category" id="category" placeholder="Type or Choose Category" list="category-list" required><br>
            <datalist id="category-list">
                <option value="Web Development">
                <option value="Graphic Design">
                <option value="Writing">
                <option value="Video Editing">
                <option value="Programming">
                <option value="Music & Audio">
                <option value="Digital Marketing">
            </datalist><br>

            <label for="expertise">Expertise Level:</label><br>
            <select name="expertise" required>
                <option value="">--Select Level--</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Expert">Expert</option>
            </select><br>

            <textarea name="description" placeholder="Description" required></textarea><br>
            <input type="text" name="skills" placeholder="Skills (comma separated)" required><br>
            <input type="text" name="delivery_time" placeholder="Delivery Time (e.g. 3 days)" required><br>
            <input type="text" name="tags" placeholder="Tags (comma separated)" required><br>
            <input type="number" step="0.01" name="price" placeholder="Price ($)" required><br>

            <label for="duration">Duration (Days):</label><br>
            <input type="number" name="duration" placeholder="How many days to keep this service live?" required><br>

            <label>Upload Media:</label><br>
            <input type="file" name="media"><br><br>

            <div class="rating-stars">
                <label>Client Rating (Preview):</label><br>
                <span>★ ★ ★ ★ ☆</span>
            </div><br>

            <button type="submit">Post Service</button>
        </form>
    </div>
</body>
</html>
