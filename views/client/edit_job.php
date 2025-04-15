<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Swift-Place/public/css/clientjobpost.css"> <!-- your custom CSS file -->
</head>
<body>

    <div class="container">
        <h2>Edit Job</h2>
        <form method="POST" action="index.php?controller=job&action=updateJob&id=<?php echo $job['id']; ?>">

            <input type="text" name="job_title" value="<?php echo htmlspecialchars($job['job_title']); ?>" required><br>
            <textarea name="job_description" required><?php echo htmlspecialchars($job['job_description']); ?></textarea><br>
            <input type="text" name="category" value="<?php echo htmlspecialchars($job['category']); ?>" required><br>
            <input type="number" name="budget" value="<?php echo htmlspecialchars($job['budget']); ?>" required><br>
            <input type="date" name="deadline" value="<?php echo htmlspecialchars($job['deadline']); ?>" required><br>
            <input type="text" name="job_type" value="<?php echo htmlspecialchars($job['job_type']); ?>" required><br>
            <input type="text" name="experience_level" value="<?php echo htmlspecialchars($job['experience_level']); ?>" required><br>
            <button type="submit">Update Job</button>
        </form>
    </div>

</body>
</html>
