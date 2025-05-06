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
        $stmt = $db->prepare("SELECT title, description, deadline FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $stmt->bind_result($title, $description, $deadline);
        $stmt->fetch();
        $stmt->close();

        // Get job milestones (Ensure you are using the correct table name `job_milestones`)
        $stmt = $db->prepare("SELECT id, title, status, due_date FROM job_milestones WHERE job_id = ?");
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $milestones = [];
        $stmt->bind_result($milestoneId, $milestoneTitle, $milestoneStatus, $milestoneDueDate);
        while ($stmt->fetch()) {
            $milestones[] = [
                'id' => $milestoneId,
                'title' => $milestoneTitle,
                'status' => $milestoneStatus,
                'due_date' => $milestoneDueDate
            ];
        }
        $stmt->close();

        // Render the job tracking page
        include_once 'views/client/job_tracking.php';
    }

    public function markMilestoneCompleted()
    {
        session_start();
        error_log("Entered markMilestoneCompleted method");

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if (!isset($_GET['milestone_id']) || !is_numeric($_GET['milestone_id'])) {
            header("Location: index.php?controller=client&action=viewApplications&error=invalid_milestone");
            exit();
        }

        $milestoneId = $_GET['milestone_id'];

        // Update milestone status to "completed"
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE job_milestones SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $milestoneId);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?controller=client&action=viewJobTracking&job_id=" . $_GET['job_id']);
        exit();
    }

   // Inside ClientController.php
   public function jobTracking()
   {
       session_start();
   
       // Check if the user is logged in
       if (!isset($_SESSION['user_id'])) {
           header("Location: index.php?controller=auth&action=login");
           exit();
       }
   
       // Validate the job_id in the URL
       if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
           header("Location: index.php?controller=client&action=myJobs");
           exit();
       }
   
       $jobId = $_GET['job_id'];  // Get the job_id from the URL
       $db = Database::getConnection();
   
       // Fetch job details
       $stmt = $db->prepare("SELECT job_title, job_description, deadline FROM jobs WHERE id = ?");
       
       if ($stmt === false) {
           // Log or display the error message if query preparation fails
           die('MySQL error: ' . $db->error);  // Display error message
       }
   
       $stmt->bind_param("i", $jobId);
       $stmt->execute();
       $stmt->bind_result($title, $description, $deadline);
       $stmt->fetch();
       $stmt->close();
   
       if (!$title) {
           // Job not found
           header("Location: index.php?controller=client&action=myJobs&error=job_not_found");
           exit();
       }
   
       // Fetch accepted applications (freelancers)
       $acceptedApplications = [];
       $stmt = $db->prepare("SELECT f.first_name, f.last_name, f.email
                            FROM job_applications a
                            JOIN freelancers f ON a.freelancer_id = f.id
                            WHERE a.job_id = ? AND a.status = 'accepted'");
       
       if ($stmt === false) {
           // Log or display the error message if query preparation fails
           die('MySQL error: ' . $db->error);  // Display error message
       }
   
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
   
       // Fetch milestones related to the job
       $milestones = [];
       $stmt = $db->prepare("SELECT id, title, status, due_date FROM job_milestones WHERE job_id = ?");
       
       if ($stmt === false) {
           // Log or display the error message if query preparation fails
           die('MySQL error: ' . $db->error);  // Display error message
       }
   
       $stmt->bind_param("i", $jobId);
       $stmt->execute();
       $stmt->bind_result($milestoneId, $milestoneTitle, $milestoneStatus, $milestoneDueDate);
       while ($stmt->fetch()) {
           $milestones[] = [
               'id' => $milestoneId,
               'title' => $milestoneTitle,
               'status' => $milestoneStatus,
               'due_date' => $milestoneDueDate
           ];
       }
       $stmt->close();
   
       // Render the job tracking view
       require_once 'views/client/job_tracking.php';
   }
   
   
}

?>