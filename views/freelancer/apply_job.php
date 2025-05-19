<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply to Job</title>
    <link rel="stylesheet" href="public/css/job_application.css">
    
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

<h2>Apply to Job: <?= isset($job['job_title']) ? htmlspecialchars($job['job_title']) : 'Unknown Job' ?></h2>


<form action="index.php?controller=freelancerApplication&action=submitApplication" method="post" enctype="multipart/form-data">

    <input type="hidden" name="job_id" value="<?= htmlspecialchars($_POST['job_id'] ?? '') ?>">

    
    <label>Cover Letter:</label>
<textarea name="cover_letter" required></textarea><br>

<label>Estimated Completion Time:</label>
<input type="text" name="expected_duration" required><br>

<label>Experience Summary:</label>
<textarea name="experience_summary" required></textarea><br>

<label>Skills Used:</label>
<textarea name="skills_used" required></textarea><br>

<label>Questions or Clarifications:</label>
<textarea name="questions_clarifications"></textarea><br>

<label>Availability (hour's/day):</label>
<input type="number" name="availability" required><br>

<label>Attachment/Work Samples (Optional):</label>
<input type="file" name="attachment"><br><br>

<button type="submit">Apply</button>

</form>




</body>
</html>
