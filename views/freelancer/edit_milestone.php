<!-- In views/freelancer/edit_milestone.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Milestone</title>
    <link rel="stylesheet" href="public/css/job_tracking.css">
</head>
<body>
<header>
    <div class="navbar">
        <div class="logo-container">
            <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
        <nav>
            <a href="index.php?controller=freelancer&action=dashboard">Dashboard</a>
            <a href="index.php?controller=freelancer&action=myServices">Your Posted Services</a>
            <a href="index.php?controller=freelancer&action=profile">Profile</a>
            <li><a href="index.php?controller=client&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>
    </div>
</header>

<h2>Edit Milestone</h2>
<form action="index.php?controller=milestone&action=update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="milestone_id" value="<?= $milestone['id'] ?>">

    <label>Title:</label>
    <input type="text" name="edit_title" value="<?= htmlspecialchars($milestone['title']) ?>" required><br>

    <label>Status:</label>
<select name="edit_status">
    <option value="pending" <?= $milestone['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
    <option value="in_progress" <?= $milestone['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
    <option value="completed" <?= $milestone['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
</select><br>


    <label>Due Date:</label>
    <input type="date" name="edit_due_date" value="<?= $milestone['due_date'] ?>" required><br>

    <label>Description:</label><br>
    <textarea name="edit_description" rows="4" required><?= htmlspecialchars($milestone['description']) ?></textarea><br>

    <label>Attachment (optional):</label><br>
    <input type="file" name="attachment"><br>

    <button type="submit">Update</button>
</form>



</body>
</html>
