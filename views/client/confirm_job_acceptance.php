<!-- confirm_job_acceptance.php (Confirmation Page) -->
<h1>Confirm Job Acceptance</h1>

<p><strong>Job Title:</strong> <?php echo htmlspecialchars($_SESSION['accepted_job_details']['job_title']); ?></p>
<p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($_SESSION['accepted_job_details']['job_description'])); ?></p>
<p><strong>Freelancer:</strong> <?php echo htmlspecialchars($_SESSION['accepted_job_details']['freelancer_name']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['accepted_job_details']['freelancer_email']); ?></p>

<!-- Confirmation button -->
<a href="index.php?controller=application&action=jobTracking&job_id=<?php echo $_GET['job_id']; ?>" class="btn-confirm">Confirm and View Job Tracking</a>

<!-- Cancel button -->
<a href="index.php?controller=application&action=viewApplications" class="btn-cancel">Cancel</a>
