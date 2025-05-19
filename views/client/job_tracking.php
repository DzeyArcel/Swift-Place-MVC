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
        <a href="index.php?controller=client&action=myJobs" class="active">Your Jobs</a>
        <a href="index.php?controller=client&action=profile">Profile</a>
        <a href="index.php?controller=client&action=logout" class="logout">Logout</a>
    </nav>
</header>

<main class="container">
    <h1>Job Tracking</h1>

    <section class="job-details">
        <h2><?= htmlspecialchars($title); ?></h2>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($description)); ?></p>
        <p><strong>Salary:</strong> $<?= number_format($job['budget'], 2) ?></p>
        <p><strong>Deadline:</strong> <?= date('F j, Y', strtotime($deadline)); ?></p>
    </section>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
    <?php elseif (isset($_SESSION['error_message'])): ?>
        <p class="error"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
    <?php endif; ?>

    <section class="milestone-section">
        <h3>Milestones</h3>
        <table>
            <thead>
                <tr>
                    <th>Milestone</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Description</th>
                    <th>Attachment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($milestones)): ?>
                    <tr><td colspan="6">No milestones found for this job.</td></tr>
                <?php else: ?>
                    <?php foreach ($milestones as $milestone): ?>
                        <tr class="<?= strtolower(str_replace(' ', '-', $milestone['status'])); ?>">
                            <td><?= htmlspecialchars($milestone['title']); ?></td>
                            <td><?= htmlspecialchars($milestone['status']); ?></td>
                            <td><?= date('F j, Y', strtotime($milestone['due_date'])); ?></td>
                            <td><?= isset($milestone['description']) ? nl2br(htmlspecialchars($milestone['description'])) : 'No description available'; ?></td>
                            <td>
                                <?php if (!empty($milestone['attachment'])): ?>
                                    <a href="public/uploads/milestones/<?= htmlspecialchars($milestone['attachment']); ?>" target="_blank">View Attachment</a>
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($milestone['status'] === 'in_progress'): ?>
                                    <a href="index.php?controller=milestone&action=MarkAsCompleted&id=<?= $milestone['id']; ?>"
                                       onclick="return confirm('Mark this milestone as completed?');"
                                       class="action-link">Mark as Completed</a>
                                <?php elseif ($milestone['status'] === 'completed'): ?>
                                    <span class="completed-status">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- ✅ Freelancer Final Submission -->

<section class="submission-review">
    <h3>Freelancer Final Submission</h3>
    <?php if (!empty($job['is_submitted']) && $job['is_submitted'] == 1): ?>
        <p><strong>Comments from Freelancer:</strong> <?= nl2br(htmlspecialchars($job['completion_comments'])) ?></p>
        
        <?php if (!empty($job['final_attachment'])): ?>
            <p><strong>Submitted File:</strong> 
                <a href="public/uploads/final_files/<?= htmlspecialchars($job['final_attachment']) ?>" download>
                    <?= htmlspecialchars($job['final_attachment']) ?>
                </a>
            </p>
        <?php elseif (!empty($job['external_link'])): ?>
            <p><strong>Download Link:</strong> 
                <a href="<?= htmlspecialchars($job['external_link']) ?>" target="_blank">
                    <?= htmlspecialchars($job['external_link']) ?>
                </a>
            </p>
        <?php else: ?>
            <p>No file or link submitted.</p>
        <?php endif; ?>

        <!-- Review Form -->
        <h4>Review the Submission</h4>
        <form method="POST" action="index.php?controller=client&action=approveJob">
            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
            <label for="approval_comments">Comments:</label><br>
            <textarea name="approval_comments" id="approval_comments" rows="4" placeholder="Your feedback..."></textarea><br><br>
            <button type="submit" name="action" value="approve" class="btn-approve">Approve</button>
            <button type="submit" name="action" value="reject" class="btn-reject">Reject </button>
        </form>
    <?php else: ?>
        <p>The freelancer has not yet submitted the final file or link for this job.</p>
    <?php endif; ?>
</section>




    <!-- ✅ Payment Eligibility -->
    <section class="payment-section">
        <?php
        $completedCount = 0;
        foreach ($milestones as $milestone) {
            if ($milestone['status'] === 'completed') {
                $completedCount++;
            }
        }
        ?>
        <h3>Final Payment</h3>
        <?php if ($completedCount >= 3): ?>
            <p>At least 3 milestones are completed. You can now make the full payment.</p>
            <a href="index.php?controller=client&action=uploadReceipt&job_id=<?= htmlspecialchars($jobId) ?>" class="btn-payment">Submit Payment Receipt</a>
        <?php else: ?>
            <p>You must mark at least 3 milestones as completed before making the full payment.</p>
        <?php endif; ?>
    </section>

    <!-- ✅ Accepted Freelancers -->
   <div class="freelancer-cards">
    <?php foreach ($acceptedApplications as $app): ?>
        <div class="freelancer-card">
            <img src="public/uploads/profile/<?= htmlspecialchars($app['profile_picture'] ?? 'default.png'); ?>" alt="Profile Picture" class="freelancer-pic">
            <div class="freelancer-info">
                <strong><?= htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?></strong><br>
                <span>Email: <?= htmlspecialchars($app['email']); ?></span><br>
                <span>Phone: <?= htmlspecialchars($app['phone'] ?? 'N/A'); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>



    <footer class="back-link">
        <a href="index.php?controller=client&action=viewApplications">← Back to Applications</a>
    </footer>
</main>

</body>
</html>
