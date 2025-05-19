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

    if (!$freelancerId) {
        echo "You must be logged in as a freelancer to view job tracking.";
        return;
    }

    // Fetch all accepted jobs for the freelancer
    $jobs = Job::getJobsForFreelancer($freelancerId);



    // For each job, fetch associated milestones and check deadline status
    $jobsData = [];
    $today = date('Y-m-d'); // Get the current date

    foreach ($jobs as $job) {
        // Add logic to check if the job is expired
        $job['is_expired'] = ($today > $job['deadline']); // Compare today's date with job deadline

        $milestones = Milestone::getByJobId($job['id']); // Get milestones for each job
        $job['milestones'] = $milestones; // Add milestones to job

        // Fetch the receipt and completion status from the jobs table
        $db = Database::getConnection();
        
        if ($db === false) {
            echo "Database connection error.";
            return;
        }

        // Using prepared statement to prevent SQL injection
        $stmt = $db->prepare("SELECT receipt, is_completed FROM jobs WHERE id = ?");
        if ($stmt === false) {
            echo "Error preparing the statement.";
            return;
        }

        $stmt->bind_param("i", $job['id']); // Bind the job ID
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $jobDetails = $result->fetch_assoc();

            // Merge the additional job details (receipt and is_completed)
            $job['receipt'] = $jobDetails['receipt'];
            $job['is_completed'] = $jobDetails['is_completed'];
        } else {
            // Handle case where no job details are found
            $job['receipt'] = null;
            $job['is_completed'] = false;
        }

        $jobsData[] = $job;  // Add the job with its milestones and details to jobsData array
    }

    // Handle form submission for adding a milestone
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? ''; // Get description from form
        $status = $_POST['status'] ?? 'pending';
        $dueDate = $_POST['due_date'] ?? '';
        $jobId = $_POST['job_id'] ?? null;  // Get job ID from form

        // Handle file upload for attachment
        $attachment = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $uploadDir = 'public/uploads/milestones/';
            $fileName = basename($_FILES['attachment']['name']);
            $filePath = $uploadDir . $fileName;

            // Check if the file is a valid attachment (optional: validate file type and size)
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $filePath)) {
                $attachment = $fileName; // Store the file name for later use
            } else {
                $error = "Failed to upload attachment.";
            }
        }

        if ($title && $dueDate && $jobId) {
            // Count existing milestones for this job
            $existingMilestones = Milestone::getByJobId($jobId);

            if (count($existingMilestones) >= 3) {
                $error = "You can only add up to 3 milestones for this job.";
            } else {
                // Create milestone for a specific job, including attachment
                Milestone::create($jobId, $freelancerId, $title, $description, $status, $dueDate, $attachment);
                header("Location: index.php?controller=freelancer&action=viewJobTracking");
                exit;
            }
        } else {
            $error = "Title, due date, and job ID are required.";
        }
    }

    // Pass the data to the view, including the error message if present
    include 'views/freelancer/job_tracking.php';
}



    
    
    
    
    
    
    
    
    public function updateMilestone() {
        session_start(); // Ensure session is started
    
        if (!isset($_SESSION['freelancer_id'])) {
            // Redirect if freelancer not logged in
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    
        $freelancerId = $_SESSION['freelancer_id'];
        $milestoneId = $_GET['milestone_id'] ?? null;
    
        // Check if milestoneId is valid
        if (!$milestoneId) {
            // Optional: Add an error message and redirect
            header('Location: index.php?controller=freelancer&action=jobTracking');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['milestone_title'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? 'pending';
            $dueDate = $_POST['due_date'] ?? '';
    
            if (!empty($title) && !empty($dueDate)) {
                // Update the milestone using the Milestone model
                Milestone::update($milestoneId, $title, $description, $status, $dueDate);
            }
        }
    
        // Redirect back to job tracking or the relevant page after the update
        header("Location: index.php?controller=freelancer&action=jobTracking");
        exit;
    }
    

  

    
    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_milestone'])) {
        $milestoneId = $_POST['milestone_id'];
        $jobId = $_POST['job_id'];
        $title = $_POST['edit_title'];
        $status = $_POST['edit_status'];
        $dueDate = $_POST['edit_due_date'];
        $attachment = $_FILES['attachment'] ?? null;

        $milestone = Milestone::getById($milestoneId);

        // Handle attachment upload
        $attachmentName = $milestone['attachment']; // Keep old if no new upload
        if ($attachment && $attachment['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/uploads/milestones/';
            $newFileName = uniqid() . '_' . basename($attachment['name']);
            $uploadPath = $uploadDir . $newFileName;
            move_uploaded_file($attachment['tmp_name'], $uploadPath);
            $attachmentName = $newFileName;
        }

        Milestone::update($milestoneId, [
            'title' => $title,
            'status' => $status,
            'due_date' => $dueDate,
            'attachment' => $attachmentName
        ]);

        header("Location: index.php?controller=freelancer&action=jobTracking");
        exit;
    }

    // For GET request when clicking "Edit"
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'], $_GET['job_id'])) {
        $jobId = $_GET['job_id'];
        $milestoneId = $_GET['edit'];
        // Redirect with edit flag (this is already handled in your view)
        header("Location: index.php?controller=freelancer&action=jobTracking&edit=$milestoneId");
        exit;
    }
}
public function submitCompletion()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $jobId = $_POST['job_id'] ?? null;
        $comments = trim($_POST['comments'] ?? '');
        $fileName = '';
        $externalLink = trim($_POST['external_link'] ?? '');

        if (!$jobId) {
            $_SESSION['error_message'] = 'Job ID is missing.';
            header("Location: index.php?controller=freelancer&action=jobTracking");
            exit;
        }

        // Allowed file extensions and MIME types
        $allowedExtensions = [
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar',
            'jpg', 'jpeg', 'png', 'gif',
            'mp4', 'mov', 'avi', 'mkv', 'webm', 'csv'
        ];

        $allowedMimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            'application/zip',
            'application/x-rar-compressed',
            'image/jpeg',
            'image/png',
            'image/gif',
            'video/mp4',
            'video/quicktime',
            'video/x-msvideo',
            'video/x-matroska',
            'video/webm',
            'text/csv'
        ];

        $maxFileSize = 100 * 1024 * 1024; // 100 MB for large files like videos

        if (!empty($_FILES['final_attachment']['name'])) {
            $fileTmp = $_FILES['final_attachment']['tmp_name'];
            $fileType = mime_content_type($fileTmp); // more reliable than $_FILES['type']
            $fileSize = $_FILES['final_attachment']['size'];
            $originalName = basename($_FILES['final_attachment']['name']);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedMimeTypes) || !in_array($extension, $allowedExtensions)) {
                $_SESSION['error_message'] = 'Invalid file type. Only documents, images, videos, and archives are allowed.';
                header("Location: index.php?controller=freelancer&action=viewJobTracking");
                exit;
            }

            if ($fileSize > $maxFileSize) {
                $_SESSION['error_message'] = 'File is too large. Max size is 100MB.';
                header("Location: index.php?controller=freelancer&action=viewJobTracking");
                exit;
            }

            $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $originalName);
            $uploadDir = "public/uploads/final_files/";
            $uploadPath = $uploadDir . $fileName;

            if (!move_uploaded_file($fileTmp, $uploadPath)) {
                $_SESSION['error_message'] = 'Failed to upload the file. Please try again.';
                header("Location: index.php?controller=freelancer&action=viewJobTracking");
                exit;
            }
        }

        $db = Database::getConnection();

        $stmt = $db->prepare("
            UPDATE jobs 
            SET is_submitted = 1, 
                final_attachment = ?, 
                completion_comments = ?, 
                external_link = ?, 
                status = 'pending_review' 
            WHERE id = ?
        ");

        $stmt->bind_param("sssi", $fileName, $comments, $externalLink, $jobId);

        // Handle job update and client notification
        if ($stmt->execute()) {
            // Get client ID for the job
            $clientQuery = $db->prepare("SELECT client_id, job_title FROM jobs WHERE id = ?");
            $clientQuery->bind_param("i", $jobId);
            $clientQuery->execute();
            $clientResult = $clientQuery->get_result();
            $client = $clientResult->fetch_assoc();

           if ($client) {
    // Prepare client notification
    $clientId = $client['client_id'];
    $jobTitle = $client['job_title'];
    $notificationMessage = "A freelancer has submitted the final file for your job '$jobTitle'.";
    $notificationLink = "index.php?controller=client&action=viewJob&job_id=" . $jobId;
    $isRead = 0;

    // Set notification type
    $notificationType = 'client';

    // Insert client notification into the 'notifications' table
    $notifyStmt = $db->prepare("
        INSERT INTO notifications (user_id, type, message, link, is_read, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $notifyStmt->bind_param("isssi", $clientId, $notificationType, $notificationMessage, $notificationLink, $isRead);
    $notifyStmt->execute();
}

            $_SESSION['success_message'] = 'Job successfully submitted for client review.';
        } else {
            $_SESSION['error_message'] = 'Failed to update the job. Please try again.';
        }

        header("Location: index.php?controller=freelancer&action=viewJobTracking");
        exit;
    } else {
        header("Location: index.php?controller=freelancer&action=viewJobTracking");
        exit;
    }
}


public function markJobAsPaidAndDone() {
    session_start();

    // Ensure freelancer is logged in
    $freelancerId = $_SESSION['freelancer_id'] ?? null;
    if (!$freelancerId) {
        echo "You must be logged in as a freelancer to mark the job as paid and completed.";
        return;
    }

    // Get job ID and status
    $jobId = $_POST['job_id'] ?? null;
    $isPaid = isset($_POST['is_paid']) ? 1 : 0;
    $isCompleted = isset($_POST['is_completed']) ? 1 : 0;

    if (!$jobId) {
        echo "Job ID is required.";
        return;
    }

    // Check if the freelancer owns this job (via accepted application)
    if (!Job::isJobOwnedByFreelancer($jobId, $freelancerId)) {
        echo "Unauthorized: You are not assigned to this job.";
        return;
    }

    // Update job status
    $db = Database::getConnection();
    if (!$db) {
        echo "Database connection error.";
        return;
    }

    $stmt = $db->prepare("UPDATE jobs SET is_paid = ?, is_completed = ? WHERE id = ?");
    if (!$stmt) {
        echo "Error preparing the statement: " . $db->error;
        return;
    }

    $stmt->bind_param("iii", $isPaid, $isCompleted, $jobId);

    if ($stmt->execute()) {
        // Get client ID and job title for the notification
        $clientQuery = $db->prepare("SELECT client_id, job_title FROM jobs WHERE id = ?");
        $clientQuery->bind_param("i", $jobId);
        $clientQuery->execute();
        $clientResult = $clientQuery->get_result();
        $client = $clientResult->fetch_assoc();

        if ($client) {
            $clientId = $client['client_id'];
            $jobTitle = $client['job_title'];
            $notificationMessage = "A freelancer has marked your job '$jobTitle' as paid and submitted the final file.";
            $notificationLink = "index.php?controller=client&action=viewJob&job_id=" . $jobId;
            $isRead = 0;
            $notificationType = 'client';

            // Insert notification for the client
            $notifyStmt = $db->prepare("
                INSERT INTO notifications (user_id, type, message, link, is_read, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $notifyStmt->bind_param("isssi", $clientId, $notificationType, $notificationMessage, $notificationLink, $isRead);
            $notifyStmt->execute();
            $notifyStmt->close();
        }

        $stmt->close();
        $clientQuery->close();

        $_SESSION['success_message'] = 'Job successfully submitted for client review.';
    } else {
        $_SESSION['error_message'] = 'Failed to update the job. Please try again.';
    }

    header("Location: index.php?controller=freelancer&action=viewJobTracking");
    exit;
}

public function quitJob()
{
    session_start(); // Ensure session is started

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'], $_SESSION['freelancer_id'])) {
        $jobId = (int) $_POST['job_id'];
        $freelancerId = (int) $_SESSION['freelancer_id'];

        $db = Database::getConnection();

        // Check if freelancer is actually accepted for the job
        $checkStmt = $db->prepare("SELECT * FROM job_applications WHERE freelancer_id = ? AND job_id = ? AND status = 'accepted'");
        $checkStmt->bind_param("ii", $freelancerId, $jobId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Update the application status to 'quit' (or you could delete it if that's your design)
            $quitStmt = $db->prepare("UPDATE job_applications SET status = 'quit' WHERE freelancer_id = ? AND job_id = ?");
            $quitStmt->bind_param("ii", $freelancerId, $jobId);

            if ($quitStmt->execute()) {
                // Notify the client
                $stmt = $db->prepare("SELECT client_id, job_title FROM jobs WHERE id = ?");
                $stmt->bind_param("i", $jobId);
                $stmt->execute();
                $jobInfo = $stmt->get_result()->fetch_assoc();

                if ($jobInfo) {
                    $clientId = $jobInfo['client_id'];
                    $jobTitle = $jobInfo['job_title'];
                    $message = "A freelancer has withdrawn from your job '$jobTitle'.";
                    $link = "index.php?controller=client&action=viewJob&job_id=" . $jobId;

                    $notify = $db->prepare("INSERT INTO notifications (user_id, type, message, link, is_read, created_at)
                                            VALUES (?, 'client', ?, ?, 0, NOW())");
                    $notify->bind_param("iss", $clientId, $message, $link);
                    $notify->execute();
                }

                $_SESSION['success'] = "You have successfully quit the job.";
            } else {
                $_SESSION['error'] = "Unable to quit the job. Please try again.";
            }
        } else {
            $_SESSION['error'] = "You are not currently assigned to this job.";
        }
    } else {
        $_SESSION['error'] = "Invalid request.";
    }

    header("Location: index.php?controller=freelancer&action=viewJobTracking");
    exit;
}


public function viewCompletedJobs()
{
    session_start();
    $freelancerId = $_SESSION['freelancer_id'] ?? null;

    if (!$freelancerId) {
        echo "You must be logged in as a freelancer to view completed jobs.";
        return;
    }

    $completedJobs = Job::getCompletedJobsForFreelancer($freelancerId);
    include 'views/freelancer/completed_jobs.php'; // Create this view
}













}
