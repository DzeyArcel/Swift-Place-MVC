<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Track your job's milestones and deadlines at Swift Place.">
    <title>Job Tracking</title>
    <link rel="stylesheet" href="public/css/job_tracking.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

<header class="navbar">
    <div class="logo-container">
        <img src="public/photos/Logos-removebg-preview.png" alt="Swift Place" class="logo-img">
    </div>
    <input type="text" placeholder="Search for services..." class="search-bar">
    <nav class="nav-links">
        <a href="index.php?controller=client&action=Clientdashboard">Dashboard</a>
        <a href="index.php?controller=client&action=viewApplications">Applications</a>
        <a href="index.php?controller=job&action=myJobs" class="active">Your Jobs</a>
        <a href="index.php?controller=client&action=profile">Profile</a>
        <a href="index.php?controller=client&action=logout" class="logout">Logout</a>
    </nav>
</header>

<h1>Job Tracking</h1>

<h2>Job: <?php echo htmlspecialchars($title); ?></h2>
<p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($description)); ?></p>
<p><strong>Deadline:</strong> <?php echo date('F j, Y', strtotime($deadline)); ?></p>

<h3>Milestones</h3>
<table>
    <thead>
        <tr>
            <th>Milestone</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($milestones)): ?>
            <tr>
                <td colspan="4">No milestones found for this job.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($milestones as $milestone): ?>
                <tr class="<?php echo strtolower(str_replace(' ', '-', $milestone['status'])); ?>">
                    <td><?php echo htmlspecialchars($milestone['title']); ?></td>
                    <td><?php echo htmlspecialchars($milestone['status']); ?></td>
                    <td><?php echo date('F j, Y', strtotime($milestone['due_date'])); ?></td>
                    <td>
                        <?php if ($milestone['status'] === 'in_progress'): ?>
                            <a href="index.php?controller=client&action=markMilestoneCompleted&milestone_id=<?php echo $milestone['id']; ?>">Mark as Completed</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<h3>Accepted Freelancers</h3>
<?php if (empty($acceptedApplications)): ?>
    <p>No accepted freelancers for this job yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($acceptedApplications as $app): ?>
            <li>
                <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                (<?php echo htmlspecialchars($app['email']); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="index.php?controller=client&action=viewApplications">Back to Applications</a>

</body>
</html>
