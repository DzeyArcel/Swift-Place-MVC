<?php
require_once 'models/Application.php';
require_once 'models/Job.php'; // 🔥 Add this line

class FreelancerApplicationController
{
    public function showApplicationForm() {
    session_start();

    if (!isset($_SESSION['freelancer_id'])) {
        header("Location: index.php?controller=freelancer&action=login");
        exit();
    }

    if (!isset($_POST['job_id']) || !is_numeric($_POST['job_id'])) {
        echo "Job ID is missing.";
        return;
    }

    $job_id = (int)$_POST['job_id'];

    require_once 'models/Job.php';
    $jobModel = new Job(Database::getConnection());
    $job = $jobModel->getJobById($job_id);  // You need this method

    if (!$job) {
        echo "Job not found.";
        return;
    }

    require 'views/freelancer/apply_job.php';
}

public function submitApplication()
{
    session_start();
    if (!isset($_SESSION['freelancer_id'])) {
        header("Location: /index.php?controller=freelancer&action=login");
        exit();
    }

    $freelancerId = $_SESSION['freelancer_id'];
    $jobId = $_POST['job_id'];
    $coverLetter = $_POST['cover_letter'];
    $expectedDuration = $_POST['expected_duration'];
    $proposedBudget = $_POST['proposed_budget'];
    $experienceSummary = $_POST['experience_summary'];
    $skillsUsed = $_POST['skills_used'];
    $availableStartDate = $_POST['available_start_date'];
    $expectedEndDate = $_POST['expected_end_date'];

    // Handle file upload
    $attachment = null;
    if (!empty($_FILES['attachment']['name'])) {
        $filename = uniqid() . "_" . basename($_FILES["attachment"]["name"]);
        $targetPath = "public/uploads/" . $filename;
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetPath)) {
            $attachment = $filename;
        }
    }

    // ✅ Instantiate Application model and call create()

    $applicationModel = new Application(Database::getConnection());

    $result = $applicationModel->create([
        'freelancer_id' => $freelancerId,
        'job_id' => $jobId,
        'cover_letter' => $coverLetter,
        'expected_duration' => $expectedDuration,
        'proposed_budget' => $proposedBudget,
        'experience_summary' => $experienceSummary,
        'skills_used' => $skillsUsed,
        'available_start_date' => $availableStartDate,
        'expected_end_date' => $expectedEndDate,
        'attachment' => $attachment,
    ]);

    if ($result) {
        header("Location: /index.php?controller=freelancer&action=dashboard&success=applied");

    } else {
        echo "Something went wrong!";
    }
}
}