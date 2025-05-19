<h2>Upload Payment Receipt for Job #<?= htmlspecialchars($job['id']) ?></h2>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<form action="index.php?controller=client&action=submitReceipt" method="post" enctype="multipart/form-data">
    <input type="hidden" name="job_id" value="<?= $job['id']; ?>">

    <label for="receipt">Upload Receipt (PDF/JPG/PNG):</label>
    <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png" required><br><br>

    <button type="submit">Submit Receipt</button>
</form>
