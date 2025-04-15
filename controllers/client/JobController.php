<?php
require_once 'models/Job.php';

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
            $success = Job::update($job_id, $client_id, $title, $description, $category, $budget, $deadline, '', $type, $experience);
    
            if ($success) {
                echo "<script>alert('Job updated successfully!'); window.location.href='index.php?controller=job&action=myPostedJobs';</script>";
            } else {
                echo "<script>alert('Failed to update job.'); window.history.back();</script>";
            }
        }
    }
    
    
    
}
