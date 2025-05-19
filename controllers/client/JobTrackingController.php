<?php
require_once __DIR__ . '/../../config/db.php';
require_once 'models/Job.php';

class JobTrackingController
{
    public function viewJobTracking()
    {
        session_start();
        error_log("Entered viewJobTracking method");
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
            header("Location: index.php?controller=client&action=viewApplications&error=invalid_job");
            exit();
        }
    
        $jobId = $_GET['job_id'];
        $userId = $_SESSION['user_id'];
    
        // Fetch job and milestone data
        $db = Database::getConnection();
        
        // Get job details
        $stmt = $db->prepare("SELECT title, description, deadline, budget FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $stmt->bind_result($title, $description, $deadline, $budget);
        $stmt->fetch();
        $stmt->close();
    
        // Get job milestones (Ensure you are using the correct table name `job_milestones`)
        $stmt = $db->prepare("SELECT id, title, status, due_date, attachment FROM job_milestones WHERE job_id = ?");
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $milestones = [];
        $stmt->bind_result($milestoneId, $milestoneTitle, $milestoneStatus, $milestoneDueDate, $milestoneAttachment);
        while ($stmt->fetch()) {
            $milestones[] = [
                'id' => $milestoneId,
                'title' => $milestoneTitle,
                'status' => $milestoneStatus,
                'due_date' => $milestoneDueDate,
                'attachment' => $milestoneAttachment // Store the attachment in the array
            ];
        }
        $stmt->close();
    
        // Render the job tracking page
        include_once 'views/client/job_tracking.php';
    }
    

  

   // Inside ClientController.php
public function jobTracking()
{
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
        header("Location: index.php?controller=client&action=myJobs");
        exit();
    }

    $jobId = $_GET['job_id'];
    $db = Database::getConnection();

    // Fetch job details
   $stmt = $db->prepare("SELECT job_title, job_description, deadline, budget, is_submitted, completion_comments, final_attachment, external_link FROM jobs WHERE id = ?");

    if (!$stmt) die('MySQL error: ' . $db->error);

    $stmt->bind_param("i", $jobId);
    $stmt->execute();
  $stmt->bind_result($title, $description, $deadline, $budget, $isSubmitted, $completionComments, $finalAttachment, $externalLink);
$stmt->fetch();
$stmt->close();


    if (!$title) {
        header("Location: index.php?controller=client&action=myJobs&error=job_not_found");
        exit();
    }

    // Fetch accepted freelancers
    $acceptedApplications = [];
    $stmt = $db->prepare("SELECT f.first_name, f.last_name, f.email
                          FROM job_applications a
                          JOIN freelancers f ON a.freelancer_id = f.id
                          WHERE a.job_id = ? AND a.status = 'accepted'");
    if (!$stmt) die('MySQL error: ' . $db->error);

    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($freelancerFirstName, $freelancerLastName, $freelancerEmail);
    while ($stmt->fetch()) {
        $acceptedApplications[] = [
            'first_name' => $freelancerFirstName,
            'last_name' => $freelancerLastName,
            'email' => $freelancerEmail
        ];
    }
    $stmt->close();

    // Fetch milestones (with file attachments)
    $milestones = [];
    $stmt = $db->prepare("SELECT id, title, description, status, due_date, attachment FROM job_milestones WHERE job_id = ?");
    if (!$stmt) die('MySQL error: ' . $db->error);

    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($milestoneId, $milestoneTitle, $milestoneDescription, $milestoneStatus, $milestoneDueDate, $milestoneAttachment);
    while ($stmt->fetch()) {
        $milestones[] = [
            'id' => $milestoneId,
            'title' => $milestoneTitle,
            'description' => $milestoneDescription,
            'status' => $milestoneStatus,
            'due_date' => $milestoneDueDate,
            'attachment' => $milestoneAttachment ? 'public/uploads/milestones/' . $milestoneAttachment : null
        ];
    }
    $stmt->close();

    $job = [
    'id' => $jobId,
    'title' => $title,
    'description' => $description,
    'deadline' => $deadline,
    'budget' => $budget,
    'is_submitted' => $isSubmitted,
    'completion_comments' => $completionComments,
    'final_attachment' => $finalAttachment,
    'external_link' => $externalLink
];


    require_once 'views/client/job_tracking.php';
}

   
   
}

?>