<?php
require_once 'models/Job.php';
require_once 'models/Notification.php';
require_once 'models/Milestone.php'; // Needed to fetch milestones
require_once 'models/Application.php';

class JobController {
    public function postJob() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        include __DIR__ . '/../../views/client/post_job.php';

        // ✅ Corrected path
    }

    public function submitJob() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client_id = $_SESSION['user_id'];
            $title = $_POST['job_title'];
            $description = $_POST['job_description'];
            $category = $_POST['category'];
            $budget = $_POST['budget'];
            $deadline = $_POST['deadline'];
            $skills = $_POST['required_skill'];
            $type = $_POST['job_type'];
            $experience = $_POST['experience_level'];

            // Create job via model
            $job_id = Job::create($client_id, $title, $description, $category, $budget, $deadline, $skills, $type, $experience);

            if ($job_id) {
                // Notify freelancers
                Job::notifyFreelancers($job_id, $client_id, $title);
                echo "<script>alert('Job posted successfully!'); window.location.href = 'index.php?controller=client&action=clientDashboard';</script>";
            } else {
                echo "<script>alert('Failed to post job.'); window.history.back();</script>";
            }
        }
    }

    public function myPostedJobs() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $client_id = $_SESSION['user_id'];
        $jobs = Job::getJobsByClient($client_id);


        include 'views/client/my_posted_jobs.php';
    }

    public function deleteJob() {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $client_id = $_SESSION['user_id'];
        $job_id = $_GET['id'];

        if (Job::deleteByClient($job_id, $client_id)) {
            header("Location: index.php?controller=job&action=myPostedJobs");
        } else {
            echo "❌ Failed to delete job.";
        }
    }

    public function myJobs() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $client_id = $_SESSION['user_id'];
        $jobs = Job::getJobsByClient($client_id);

        include 'views/client/my_posted_jobs.php';
    }

    public function editJob() {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $job_id = $_GET['id'];
        $client_id = $_SESSION['user_id'];
    
        require_once 'models/Job.php';
        $job = Job::getJobByIdAndClient($job_id, $client_id);
    
        if (!$job) {
            echo "<script>alert('Job not found or unauthorized access'); window.location.href='index.php?controller=job&action=myPostedJobs';</script>";
            return;
        }
    
        include 'views/client/edit_job.php';
    }
    
    public function updateJob() {
        session_start();
    
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $job_id = $_GET['id'];
        $client_id = $_SESSION['user_id'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['job_title'];
            $description = $_POST['job_description'];
            $category = $_POST['category'];
            $budget = $_POST['budget'];
            $deadline = $_POST['deadline'];
            $type = $_POST['job_type'];
            $experience = $_POST['experience_level'];
    
            require_once 'models/Job.php';
            $success = Job::update($job_id, $client_id, $title, $description, $category, $budget, $deadline, '', $type);
    
            if ($success) {
                echo "<script>alert('Job updated successfully!'); window.location.href='index.php?controller=job&action=myPostedJobs';</script>";
            } else {
                echo "<script>alert('Failed to update job.'); window.history.back();</script>";
            }
        }
    }


    public function trackJob() {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        if (!isset($_GET['jobId']) || !is_numeric($_GET['jobId'])) {
            header("Location: index.php?controller=job&action=myJobs&error=invalid_job");
            exit();
        }
    
        $jobId = $_GET['jobId'];
    
        // Get job and freelancer info
        $jobModel = new Job();
        $job = $jobModel->getJobById($jobId);
        
        if (!$job) {
            header("Location: index.php?controller=job&action=myJobs&error=job_not_found");
            exit();
        }
    
        $applicationModel = new Application(Database::getConnection());
        $freelancer = $applicationModel->getAcceptedFreelancerByJobId($jobId); // Get accepted freelancer
    
        // Fetch milestones for this job
        $milestones = Milestone::getByJobId($jobId); 
    
        // Send data to the view
        $title = $job['title'];
        $description = $job['description'];
        $deadline = $job['deadline'];
    
        include __DIR__ . '/../../views/client/jobTracking.php';
    }

    
    
    
    
    

    public function updateJobStatus()
    {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        if (!isset($_POST['job_id'], $_POST['status'])) {
            header("Location: index.php?controller=job&action=myJobs&error=invalid_request");
            exit();
        }
    
        $jobId = $_POST['job_id'];
        $status = $_POST['status'];
    
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE jobs SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $jobId);
        $stmt->execute();
        $stmt->close();
    
        header("Location: index.php?controller=job&action=trackJob&jobId=$jobId&success=status_updated");
        exit();
    }
    
// In JobController

public function jobDetails() {
    if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
        // Handle error: job ID is missing or invalid
        echo "Job ID is missing or invalid.";
        return;
    }

    $jobId = $_GET['job_id'];

    // Get job details using the provided job ID
    $jobDetails = Job::getJobById($jobId); 

    if ($jobDetails) {
        // Pass job details to the view
        include('views/job/jobDetails.php');  // Ensure this view exists and is set up to display job details
    } else {
        echo "Job not found.";
    }
}

public function viewJob()
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
        header("Location: index.php?controller=client&action=dashboard&error=invalid_job");
        exit();
    }

    $jobId = $_GET['job_id'];
    $jobModel = new Job(Database::getConnection());
    $job = $jobModel->getJobById($jobId);

    if (!$job) {
        header("Location: index.php?controller=client&action=dashboard&error=job_not_found");
        exit();
    }

    require 'views/client/job_details.php'; // Make sure this view exists
}

    
    
}
