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
        header("Location: index.php?controller=freelancer&action=login");
        exit();
    }

    $freelancerId = $_SESSION['freelancer_id'];
    $jobId = $_POST['job_id'];
    $coverLetter = $_POST['cover_letter'];
    $expectedDuration = $_POST['expected_duration'];
    $experienceSummary = $_POST['experience_summary'];
    $skillsUsed = $_POST['skills_used'];
    $questions = $_POST['questions_clarifications'];
    $availability = $_POST['availability'];

    // Handle file upload
    $attachment = null;
    if (!empty($_FILES['attachment']['name'])) {
        $filename = uniqid() . "_" . basename($_FILES["attachment"]["name"]);
        $targetPath = "public/uploads/" . $filename;
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetPath)) {
            $attachment = $filename;
        }
    }

    $applicationModel = new Application(Database::getConnection());

    $result = $applicationModel->create([
        'freelancer_id' => $freelancerId,
        'job_id' => $jobId,
        'cover_letter' => $coverLetter,
        'expected_duration' => $expectedDuration,
        'experience_summary' => $experienceSummary,
        'skills_used' => $skillsUsed,
        'questions_clarifications' => $questions,
        'availability' => $availability,
        'attachment' => $attachment,
    ]);

    if ($result) {
        // 🛎️ After successful application, notify the client
        $db = Database::getConnection();

        // 1. Get client ID and job title
        $stmt = $db->prepare("SELECT client_id, job_title FROM jobs WHERE id = ?");
        if (!$stmt) {
            die('Prepare failed: (' . $db->errno . ') ' . $db->error);
        }
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $stmt->bind_result($clientId, $jobTitle);
        $stmt->fetch();
        $stmt->close();

        if ($clientId) {
            // 2. Get freelancer name
            $stmt = $db->prepare("SELECT first_name, last_name FROM freelancers WHERE id = ?");
            if (!$stmt) {
                die('Prepare failed: (' . $db->errno . ') ' . $db->error);
            }
            $stmt->bind_param("i", $freelancerId);
            $stmt->execute();
            $stmt->bind_result($firstName, $lastName);
            $stmt->fetch();
            $stmt->close();

            $freelancerName = $firstName . ' ' . $lastName;

            // 3. Create a custom notification message
            $notificationText = "$freelancerName applied for your job \"$jobTitle\".";

        
// 4. Insert into notifications (for client)
$stmt = $db->prepare("INSERT INTO notifications (user_id, type, message, is_read, created_at) VALUES (?, 'client', ?, 0, NOW())");
if (!$stmt) {
    die('Prepare failed: (' . $db->errno . ') ' . $db->error);
}
$stmt->bind_param("is", $clientId, $notificationText);
$stmt->execute();
$stmt->close();


        }

        // 5. Redirect back to freelancer dashboard
        header("Location: index.php?controller=freelancer&action=dashboard&success=applied");
        exit();
    } else {
        echo "Something went wrong!";
    }
}


}