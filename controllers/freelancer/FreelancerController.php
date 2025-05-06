<?php
require_once 'models/Freelancer.php';
require_once 'config/db.php';
require_once 'models/Notification.php';
require_once 'models/Job.php';
require_once 'models/Service.php';
require_once 'models/Application.php';  
require_once 'models/Milestone.php';



class FreelancerController {

    

    public function signup() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $conn = Database::getConnection();

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $job_category = $_POST['job_category'];
            $experience = $_POST['experience'];
            $skills = $_POST['skills'];
            $portfolio_link = !empty($_POST['portfolio_link']) ? $_POST['portfolio_link'] : null;

            $sql = "INSERT INTO freelancers (first_name, last_name, email, password, job_category, experience, skills, portfolio_link)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $password, $job_category, $experience, $skills, $portfolio_link);

            if ($stmt->execute()) {
                // Redirect to login
                header("Location: /Swift-Place/index.php?controller=freelancer&action=Showlogin");
                exit();
            } else {
                echo "❌ Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Invalid request method.";
        }
    }

    public function login() {
        session_start();
        require_once 'config/db.php'; // Ensure the DB connection file is included
    
        $conn = Database::getConnection();
    
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
    
        // Basic validation
        if (empty($email) || empty($password)) {
            echo "<script>alert('Please fill in both email and password.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
            exit();
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
            exit();
        }
    
        // Prepare and execute query
        $stmt = $conn->prepare("SELECT id, first_name, password FROM freelancers WHERE email = ?");
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        // Validate result
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $first_name, $hashed_password);
            $stmt->fetch();
    
            if (password_verify($password, $hashed_password)) {
                // Login successful
                $_SESSION['freelancer_id'] = $id;
                $_SESSION['freelancer_name'] = $first_name;
    
                header("Location: /Swift-Place/index.php?controller=freelancer&action=dashboard");
                exit();
            } else {
                // Password incorrect
                echo "<script>alert('Invalid password.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
                exit();
            }
        } else {
            // Email not found
            echo "<script>alert('No freelancer account found with that email.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
            exit();
        }
    }
    

// In FreelancerController.php

public function showLogin()
{
    require_once 'views/auth/freelancer_login.php';
}

public function logout()
{
    session_start();
    session_unset();
    session_destroy();

    // Redirect directly to the homepage
    header("Location: views/home/homepage.php");
    exit();
}

public function dashboard()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Redirect if not logged in
    if (!isset($_SESSION['freelancer_id'])) {
        header("Location: /Swift-Place/index.php?controller=freelancer&action=showLogin");
        exit();
    }

    $conn = Database::getConnection();
    $freelancer_id = $_SESSION['freelancer_id'];
    $freelancer_name = $_SESSION['freelancer_name'] ?? "Freelancer";

    // Notification model
    $notificationModel = new FreelancerNotification($conn);
    $unread_notifications = $notificationModel->getUnreadCount($freelancer_id);
    $notifications = $notificationModel->getNotificationsByUser($freelancer_id);

    // Jobs and Services
    $jobs = Job::getAllJobs();
    $services = Service::getAllServices();

    // Load view
    require_once 'views/freelancer/dashboard.php';
}



    //Servicess
    public function myServices()
    {
        session_start();
    
        // Redirect if not logged in
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        // Get freelancer ID and their services
        $freelancer_id = $_SESSION['freelancer_id'];
    
        try {
            $services = Service::getServicesByFreelancer($freelancer_id);
        } catch (Exception $e) {
            $services = []; // fallback in case of DB failure
            error_log("Error fetching services: " . $e->getMessage());
        }
    
        // Load the view
        require 'views/freelancer/my_services.php';
    }
    

    public function viewProfile()
    {
        if (isset($_GET['freelancer_id'])) {
            $freelancer_id = $_GET['freelancer_id'];
    
            // Load model
            require_once 'models/FreelancerProfile.php';
            $model = new FreelancerProfile(Database::getConnection());
    
            // Fetch the freelancer's basic info and profile details
            $basicInfo = $model->getFreelancerBasicInfo($freelancer_id);
            $profile = $model->getProfile($freelancer_id);
    
            // Just include the view directly
            include 'views/freelancer/profile_popup.php';
        } else {
            echo "Freelancer not found.";
        }
    }
    

    public function getProfile($freelancer_id)
    {
        // Modify this query to include address, experience, phone, and skills
        $sql = "SELECT freelancer_profile.*, freelancers.address, freelancers.phone, freelancers.experience, freelancers.skills
                FROM freelancer_profile
                JOIN freelancers ON freelancer_profile.freelancer_id = freelancers.id
                WHERE freelancer_profile.freelancer_id = :freelancer_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':freelancer_id', $freelancer_id);
        $stmt->execute();

        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        return $profile;
    }


    public function profile() {
        session_start();
    
        if (empty($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        $freelancer_id = $_SESSION['freelancer_id'];
    
        require_once 'models/FreelancerProfile.php';
        $model = new FreelancerProfile(Database::getConnection());
    
        $basicInfo = $model->getFreelancerBasicInfo($freelancer_id);
        $profile = $model->getProfile($freelancer_id);
    
        require 'views/freelancer/profile.php';
    }
    
    public function editProfile() {
        session_start();
    
        if (empty($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        $freelancer_id = $_SESSION['freelancer_id'];
    
        require_once 'models/FreelancerProfile.php';
        $model = new FreelancerProfile(Database::getConnection());
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $skills = trim($_POST['skills'] ?? '');
            $experience = trim($_POST['experience'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
    
            // Handle image upload if exists
            $profilePicture = null;
            if (!empty($_FILES['profile_picture']['name'])) {
                $uploadDir = 'public/uploads/';
                $filename = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
                $targetFile = $uploadDir . $filename;
    
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                    $profilePicture = $filename;
                }
            }
    
            if (isset($_POST['save'])) {
                if ($model->profileExists($freelancer_id)) {
                    $model->updateProfile($freelancer_id, $phone, $address, $skills, $experience, $bio, $profilePicture);
                } else {
                    $model->createProfile($freelancer_id, $phone, $address, $skills, $experience, $bio, $profilePicture);
                }
                header("Location: index.php?controller=freelancer&action=profile");
                exit();
            }
    
            if (isset($_POST['delete'])) {
                $model->deleteProfile($freelancer_id);
                header("Location: index.php?controller=freelancer&action=profile");
                exit();
            }
        }
    
        $profile = $model->getProfile($freelancer_id);
        require 'views/freelancer/edit_profile.php';
    }

    
    public function notifications() {
        session_start();
        // Ensure freelancer is logged in
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        // Include the Notification model for freelancers
        require_once 'models/Notification.php';
        $model = new FreelancerNotification(Database::getConnection());
    
        // Get the freelancer's ID from the session
        $freelancer_id = $_SESSION['freelancer_id'];
    
        // Mark notification as read if `notification_id` is passed
        if (isset($_GET['notification_id'])) {
            $model->markAsRead($_GET['notification_id'], $freelancer_id);
        }
    
        // Delete notification if `delete_id` is passed
        if (isset($_GET['delete_id'])) {
            $model->deleteNotification($_GET['delete_id'], $freelancer_id);
            header("Location: index.php?controller=freelancer&action=notifications");
            exit();
        }
    
        // Get all notifications for the freelancer
        $notifications = $model->getNotificationsByUser($freelancer_id);
    
        // Load the notifications view
        require 'views/freelancer/notification.php';
    }
    
   
    public function viewJobTracking() {
        // Start the session
        session_start();
    
        // Ensure freelancer is logged in
        $freelancerId = $_SESSION['freelancer_id'] ?? null;
    
        // Debugging: Check if freelancer ID exists in session
        if (!$freelancerId) {
            echo "You must be logged in as a freelancer to view job tracking.";
            return;
        }
    
        // Fetch all accepted jobs for the freelancer
        $jobs = Job::getJobsForFreelancer($freelancerId);
    
        if (empty($jobs)) {
            echo "No accepted jobs found.";
            return;
        }
    
        // For each job, fetch associated milestones
        $jobsData = [];
        foreach ($jobs as $job) {
            $milestones = Milestone::getByJobId($job['id']); // Get milestones for each job
            $job['milestones'] = $milestones; // Add milestones to job
            $jobsData[] = $job;  // Add the job with its milestones to jobsData array
        }
    
        // Handle form submission for adding a milestone
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? ''; // Get description from form
            $amount = $_POST['amount'] ?? null;
            $dueDate = $_POST['due_date'] ?? '';
            $jobId = $_POST['job_id'] ?? null;  // Get job ID from form
    
            if ($title && $dueDate && $jobId) {
                // Create milestone for a specific job
                Milestone::create($jobId, $title, $description, $amount, $dueDate);
                header("Location: index.php?controller=freelancer&action=viewJobTracking");
                exit;
            } else {
                $error = "Title, due date, and job ID are required.";
            }
        }
    
        // Pass the data to the view, including the error message if present
        include 'views/freelancer/job_tracking.php';
    }
    
    
    
    
    

    public function updateMilestone() {
        if (!isset($_SESSION['freelancer_id'])) {
            // Redirect to login if freelancer is not logged in
            header('Location: login.php');
            exit;
        }

        $freelancerId = $_SESSION['freelancer_id'];
        $jobsData = Job::getJobsForFreelancer($freelancerId);

        $jobId = $_GET['job_id'];
        $milestoneId = $_GET['milestone_id'] ?? null;

        // Fetch job details to ensure this freelancer is working on the job
        $job = Job::getJobById($jobId);
        if ($job['freelancer_id'] !== $freelancerId) {
            // Redirect if freelancer is not associated with the job
            header('Location: /freelancer/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $milestoneTitle = $_POST['milestone_title'];
            $milestoneDescription = $_POST['description']; // Get description from form
            $milestoneStatus = $_POST['status'];
            $milestoneDueDate = $_POST['due_date'];

            if ($milestoneId) {
                // Update existing milestone
                Milestone::update($milestoneId, $milestoneTitle, $milestoneDescription, $milestoneStatus, $milestoneDueDate);
            } else {
                // Create new milestone
                Milestone::create($jobId, $freelancerId, $milestoneTitle, $milestoneDescription, $milestoneStatus, $milestoneDueDate);
            }

            // Redirect back to job tracking page
            header("Location: index.php?controller=freelancer&action=viewJobTracking&job_id=$jobId");
            exit;
        }

        // Fetch job and milestones to pass to the view
        $milestones = Milestone::getMilestonesByJobId($jobId);
        require_once('views/freelancer/job_tracking.php');
    }

    public function submitProject() {
        $jobId = $_GET['job_id'];
        $freelancerId = $_SESSION['freelancer_id'];
    
        // Ensure this freelancer is the one handling the job
        $job = Job::getJobById($jobId);
        if ($job['freelancer_id'] !== $freelancerId) {
            header('Location: /freelancer/dashboard');
            exit;
        }
    
        // Update job status to "submitted"
        Job::updateStatus($jobId, 'submitted');
    
        // Redirect back to job tracking page
        header("Location: index.php?controller=freelancer&action=viewJobTracking&job_id=$jobId");
        exit;
    }
    

}
