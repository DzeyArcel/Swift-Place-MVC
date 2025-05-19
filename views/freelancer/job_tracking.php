
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Tracking</title>
    <link rel="stylesheet" href="public/css/jobtrack.css">
    <style>
        /* Your custom styles can be placed here */
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
            <li><a href="index.php?controller=freelancer&action=profile"><i class="fas fa-user"></i>Profile</a></li>
            <li><a href="index.php?controller=auth&action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<section class="#">
<h1>Job Tracking</h1>

<?php $editingMilestoneId = $_GET['edit'] ?? null; ?>

<?php if (empty($jobsData)): ?>
    <p>No accepted jobs to track.</p>
<?php else: ?>
    <?php foreach ($jobsData as $job): ?>
        <div class="job">
            <h2><?= htmlspecialchars($job['job_title']) ?></h2>
            <p><strong>Client:</strong> <?= htmlspecialchars($job['first_name'] . ' ' . $job['last_name']) ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($job['job_description'] ?? 'No description')) ?></p>
            <p><strong>Salary:</strong> $<?= number_format($job['budget'], 2) ?></p>
            <p><strong>Deadline:</strong> <?= date('F j, Y', strtotime($job['deadline'])) ?>
                <?php if ($job['is_expired']): ?>
                    <span class="expired-label">(Expired)</span>
                <?php endif; ?>
            </p>

            <!-- Milestones -->
            <h3>Milestones</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Attachment</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($job['milestones'])): ?>
                        <tr><td colspan="6">No milestones added yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($job['milestones'] as $m): ?>
                            <tr>
                                <?php if ($editingMilestoneId == $m['id']): ?>
                                    <form method="POST" enctype="multipart/form-data" action="index.php?controller=milestone&action=update">
                                        <input type="hidden" name="milestone_id" value="<?= $m['id'] ?>">
                                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                        <td><input type="text" name="edit_title" value="<?= htmlspecialchars($m['title']) ?>" required></td>
                                        <td>
                                            <select name="edit_status">
                                                <option value="pending" <?= $m['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="in_progress" <?= $m['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                                <option value="completed" <?= $m['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                            </select>
                                        </td>
                                        <td><input type="date" name="edit_due_date" value="<?= $m['due_date'] ?>"></td>
                                        <td>
                                            <?php if (!empty($m['attachment'])): ?>
                                                <a href="public/uploads/milestones/<?= $m['attachment'] ?>" target="_blank">View</a>
                                            <?php else: ?>None<?php endif; ?>
                                        </td>
                                        <td><textarea name="edit_description"><?= htmlspecialchars($m['description']) ?></textarea></td>
                                        <td>
                                            <button type="submit" name="update_milestone">Save</button>
                                            <a class="btn-link" href="index.php?controller=freelancer&action=jobTracking">Cancel</a>
                                        </td>
                                    </form>
                                <?php else: ?>
                                    <td><?= $m['title'] ?></td>
                                    <td><?= ucfirst($m['status']) ?></td>
                                    <td><?= date('M j, Y', strtotime($m['due_date'])) ?></td>
                                    <td>
                                        <?php if (!empty($m['attachment'])): ?>
                                            <a href="public/uploads/milestones/<?= $m['attachment'] ?>" target="_blank">View</a>
                                        <?php else: ?>None<?php endif; ?>
                                    </td>
                                    <td><?= nl2br(htmlspecialchars($m['description'])) ?></td>
                                    <td>
                                        <a class="btn-link" href="index.php?controller=milestone&action=edit&milestone_id=<?= $m['id'] ?>&job_id=<?= $job['id'] ?>">Edit</a>
                                        |
                                        <form method="POST" action="index.php?controller=milestone&action=delete" style="display:inline;">
                                            <input type="hidden" name="milestone_id" value="<?= $m['id'] ?>">
                                            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Add Milestone -->
            <div class="milestone-form">
                <h3>Add New Milestone</h3>
                <form method="POST" enctype="multipart/form-data" action="index.php?controller=milestone&action=add">
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">

                    <label>Title:
                        <input type="text" name="title" required>
                    </label><br><br>

                    <label>Description:
                        <textarea name="description" required></textarea>
                    </label><br><br>

                    <label>Status:
                        <select name="status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                        </select>
                    </label><br><br>

                    <label>Due Date:
                        <input type="date" name="due_date" required>
                    </label><br><br>

                    <label>Attachment:
                        <input type="file" name="attachment" required>
                    </label><br><br>

                    <button type="submit">Add Milestone</button>
                </form>
            </div>

            <!-- Submit Job Completion -->
            <div class="submit-job-section">
                <h3>Submit Job for Review</h3>
                <form method="POST" action="index.php?controller=freelancer&action=submitCompletion" enctype="multipart/form-data">
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">

                    <label>Final File (optional):
                        <input type="file" name="final_attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar,.mp4,.mov,.avi,.mkv,.webm,.csv">
                    </label>
                    <br><em>You can upload a file OR provide a download link below.</em><br><br>

                    <label>Download Link (optional):
                        <input type="url" name="external_link" placeholder="https://example.com/download">
                    </label><br><br>

                    <label>Comments:
                        <textarea name="comments" rows="3" placeholder="Any comments for the client..."></textarea>
                    </label><br><br>

                    <button type="submit">Submit Final Work</button>
                </form>
            </div>

            <!-- Receipt Section -->
  <div class="receipt-section">
    <h3>Receipt Details</h3>
    <?php if (!empty($job['receipt'])): ?>
        <p><strong>Receipt:</strong> 
        <a href="public/uploads/receipts/<?= htmlspecialchars($job['receipt']) ?>" target="_blank">View Receipt</a></p>
    <?php else: ?>
        <p>No receipt submitted yet.</p>
    <?php endif; ?>
</div>


           
          <!-- Mark Job as Paid and Completed -->
<div class="job-done-section">
    <h3>Mark Job as Completed and Paid</h3>
    <?php if (isset($job['is_paid']) && $job['is_paid'] && isset($job['is_completed']) && $job['is_completed']): ?>
        <p><strong>Status:</strong> Completed and Paid</p>
    <?php else: ?>
        <form method="POST" action="index.php?controller=freelancer&action=markJobAsPaidAndDone">
            <input type="hidden" name="job_id" value="<?= htmlspecialchars($job['id']) ?>">

            <!-- Mark as Paid -->
            <?php if (isset($job['is_paid']) && !$job['is_paid']): ?>
                <div>
                    <label for="is_paid">Mark as Paid:</label>
                    <input type="checkbox" name="is_paid" value="1" id="is_paid">
                </div>
            <?php endif; ?>

            <!-- Mark as Completed -->
            <?php if (isset($job['is_completed']) && !$job['is_completed']): ?>
                <div>
                    <label for="is_completed">Mark as Completed:</label>
                    <input type="checkbox" name="is_completed" value="1" id="is_completed">
                </div>
            <?php endif; ?>

            <button type="submit">Update Job Status</button>
        </form>
        <!-- Quit Job Section -->
<div class="quit-job-section" style="margin-top: 20px;">
    <h3>Quit Job</h3>
 <form action="index.php?controller=freelancer&action=quitJob" method="POST" onsubmit="return confirm('Are you sure you want to quit this job?');">
            <input type="hidden" name="job_id" value="<?= htmlspecialchars($job['id']) ?>">
            <button type="submit" class="btn btn-danger">Quit Job</button>
        </form>

</div>
<a href="index.php?controller=freelancer&action=viewCompletedJobs" class="btn">View Completed Jobs</a>


    <?php endif; ?>
</div>

    <?php endforeach; ?>
<?php endif; ?>




</body>
</html>
