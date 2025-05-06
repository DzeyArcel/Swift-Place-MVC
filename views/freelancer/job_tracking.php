<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Tracking</title>
    <link rel="stylesheet" href="public/css/job_tracking.css">
</head>
<body>

<h1>Job Tracking</h1>

<?php if (empty($jobsData)): ?>
    <p>No accepted jobs to track.</p>
<?php else: ?>
    <?php foreach ($jobsData as $job): ?>
        <div class="job">
            <h2><?= htmlspecialchars($job['job_title']) ?></h2>
            <p><strong>Client:</strong> <?= htmlspecialchars($job['first_name'] . ' ' . $job['last_name']) ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($job['job_description'] ?? 'No description available.')) ?></p>
            <p><strong>Deadline:</strong> <?= date('F j, Y', strtotime($job['deadline'] ?? '')) ?></p>

            <h3>Milestones</h3>
            <table border="1" cellpadding="6">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($job['milestones'])): ?>
                        <tr><td colspan="3">No milestones yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($job['milestones'] as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m['title'] ?? 'No title') ?></td>
                                <td><?= htmlspecialchars($m['status'] ?? 'No status') ?></td>
                                <td><?= date('M j, Y', strtotime($m['due_date'] ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (isset($_SESSION['freelancer_id'], $job['freelancer_id']) && $_SESSION['freelancer_id'] == $job['freelancer_id']): ?>


                <h3>Add New Milestone</h3>

                <?php if (!empty($error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=freelancer&action=updateMilestone&job_id=<?= $job['id'] ?>">
                    <label>Title:<br>
                        <input type="text" name="milestone_title" required>
                    </label><br><br>

                    <label>Description:<br>
                        <textarea name="description" rows="3"></textarea>
                    </label><br><br>

                    <label>Status:<br>
                        <select name="status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </label><br><br>

                    <label>Due Date:<br>
                        <input type="date" name="due_date" required>
                    </label><br><br>

                    <button type="submit">Add Milestone</button>
                </form>

            <?php endif; ?>

            <hr>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>

<?php // End of PHP block
?>
