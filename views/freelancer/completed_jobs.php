<h2>Completed Jobs</h2>

<?php if (empty($completedJobs)): ?>
    <p>You have no completed jobs yet.</p>
<?php else: ?>
    <ul>
    <?php foreach ($completedJobs as $job): ?>
        <li>
            <strong><?= htmlspecialchars($job['job_title']) ?></strong> - <?= htmlspecialchars($job['budget']) ?> USD
            <br>Client: <?= htmlspecialchars($job['first_name'] . ' ' . $job['last_name']) ?>
            <br>Completed and Paid
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
