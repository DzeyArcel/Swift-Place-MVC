<?php

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ClientProfile.php';
require_once __DIR__ . '/../../models/Job.php';
require_once __DIR__ . '/../../models/Service.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Notification.php';
require_once __DIR__ . '/../../models/Application.php';
require_once 'models/Milestone.php';


class ClientController {
    

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $role = 'client';

            if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
                echo "<script>alert('All fields are required.'); window.location='/Swift-Place/views/auth/client_signup.php';</script>";
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email address.'); window.location='/Swift-Place/views/auth/client_signup.php';</script>";
                exit();
            }

            if (User::findByEmail($email)) {
                echo "<script>alert('Email already registered.'); window.location='/Swift-Place/views/auth/client_signup.php';</script>";
                exit();
            }

            $result = User::create($first_name, $last_name, $email, $password);

            if ($result) {
                echo "<script>alert('Account created successfully! Please log in.'); window.location='/Swift-Place/views/auth/login.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.'); window.location='/Swift-Place/views/auth/client_signup.php';</script>";
            }
        } else {
            include __DIR__ . '/../../views/auth/client_signup.php';
        }
    }

    public function login() {
        session_start();
        $max_attempts = 5;
        $lockout_time = 15 * 60;
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format.';
                header("Location: " . BASE_URL . "/views/auth/login.php");
                exit();
            }
    
            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
                $remaining_time = $_SESSION['lockout_time'] - time();
                if ($remaining_time > 0) {
                    $_SESSION['error_message'] = 'Too many failed attempts. Try again in ' . ceil($remaining_time / 60) . ' minutes.';
                    header("Location: " . BASE_URL . "/views/auth/login.php");
                    exit();
                } else {
                    unset($_SESSION['login_attempts'], $_SESSION['lockout_time']);
                }
            }
    
            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                unset($_SESSION['login_attempts'], $_SESSION['lockout_time']);
    
                header("Location: " . BASE_URL . "/index.php?controller=client&action=clientDashboard");
                exit();
            } else {
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['lockout_time'] = time() + $lockout_time;
                }
                $_SESSION['error_message'] = 'Invalid email or password.';
                header("Location: " . BASE_URL . "/views/auth/login.php");
                exit();
            }
        } else {
            include __DIR__ . '/../../views/auth/login.php';
        }
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
    


    public function clientDashboard() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $conn = Database::getConnection();
        $client_id = $_SESSION['user_id'];
        $client = User::getClientById($client_id);
    
        if (!$client) {
            echo "Client not found.";
            exit();
        }
    
        $client_name = $client['first_name'] ?? 'Client';
    
        // Fetch data
        Job::deleteExpiredJobs();
        $jobs = Job::getAllJobs();
        $services = Service::getAllServices();
    
        // Fetch accepted job for the client
        $applicationModel = new Application(Database::getConnection());
        $acceptedJob = $applicationModel->getAcceptedFreelancerByJobId($client_id); // Assuming this method fetches the accepted job for the client
        $jobId = $acceptedJob ? $acceptedJob['job_id'] : null; // Get the job ID of the accepted application
    
        // Notifications
        $clientNotif = new ClientNotification($conn);
        $notifications = $clientNotif->getNotificationsByUser($client_id);
        $unread_notifications = $clientNotif->getUnreadCount($client_id); // simplified
    
        // Pass the jobId to the view
        include __DIR__ . '/../../views/client/dashboard.php';
    }
    
    
    

    public function profile() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $user = ClientProfile::getUserDetails($user_id);
        $profile = ClientProfile::getProfile($user_id);

        include 'views/client/profile.php';
    }

    public function edit_profile() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $profile = ClientProfile::getProfile($user_id);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bio = $_POST['bio'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $profile_pic = $profile['profile_pic'] ?? '';

            if (!empty($_FILES["profile_pic"]["name"])) {
                $profile_pic = basename($_FILES["profile_pic"]["name"]);
                move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "public/uploads/" . $profile_pic);
            }

            if (ClientProfile::profileExists($user_id)) {
                ClientProfile::updateProfile($user_id, $bio, $contact, $address, $profile_pic);
            } else {
                ClientProfile::insertProfile($user_id, $bio, $contact, $address, $profile_pic);
            }

            header("Location: index.php?controller=client&action=profile");
            exit();
        }

        if (isset($_POST['delete'])) {
            ClientProfile::deleteProfile($user_id);
            header("Location: index.php?controller=client&action=profile");
            exit();
        }

        include 'views/client/edit_profile.php';
    }

    public function postJob() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        include 'views/jobs/post_job.php';
    }

    public function notifications() {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $client_id = $_SESSION['user_id'];
    
    
        $model = new ClientNotification(Database::getConnection());
    
        // Mark notification as read
        if (isset($_GET['notification_id']) && is_numeric($_GET['notification_id'])) {
            $notification_id = (int)$_GET['notification_id'];
            $model->markAsRead($notification_id, $client_id);
        }
    
        // Delete notification
        if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
            $delete_id = (int)$_GET['delete_id'];
            $result = $model->deleteNotification($delete_id, $client_id);
    
            // Check if the delete was successful
            if (!$result) {
                // Optionally log or show an error message here
                echo "❌ Error deleting notification!";
                exit();
            }
    
            // Redirect back to the notifications page after successful deletion
            header("Location: index.php?controller=client&action=notifications");
            exit();
        }
    
        // Get all notifications for the client
        $notifications = $model->getNotificationsByUser($client_id);
    
        require 'views/client/notification.php';
    }
    
    
    
    public function viewApplications() {
        session_start();
    
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $db = Database::getConnection();
        
        // Fetch all applications for the client with their status
        $stmt = $db->prepare("SELECT a.id, a.status, a.cover_letter, a.experience_summary, a.skills_used, a.questions_clarifications, a.availability, a.attachment, j.id AS job_id, j.job_title, CONCAT(f.first_name, ' ', f.last_name) AS freelancer_name, f.id AS freelancer_id
                              FROM job_applications a
                              JOIN jobs j ON a.job_id = j.id
                              JOIN freelancers f ON a.freelancer_id = f.id
                              WHERE j.client_id = ? ORDER BY a.status DESC");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $applications = [];
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }
        $stmt->close();
    
        // Separate pending and accepted applications
        $pendingApplications = array_filter($applications, function($app) {
            return $app['status'] == 'pending';
        });
        
        $acceptedApplications = array_filter($applications, function($app) {
            return $app['status'] == 'accepted';
        });
    
        // Pass the applications to the view
        require_once 'views/client/applications.php';
    }
    
    
    
    
    public function viewJob()
    {
        // Check if the client is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        // Get job_id from the URL parameters
        if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
            header("Location: index.php?controller=client&action=viewJobs&error=invalid_job");
            exit();
        }
    
        $jobId = $_GET['job_id'];
        $db = Database::getConnection();
    
        // Fetch the job details from the database
        $stmt = $db->prepare("SELECT j.title, j.description, j.status, f.first_name AS freelancer_first_name, f.last_name AS freelancer_last_name, fp.profile_picture AS freelancer_profile_picture
                              FROM jobs j
                              JOIN freelancers f ON j.freelancer_id = f.id
                              LEFT JOIN freelancer_profile fp ON f.id = fp.freelancer_id
                              WHERE j.id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $jobId);
            $stmt->execute();
            $result = $stmt->get_result();
            $jobDetails = $result->fetch_assoc();
            $stmt->close();
        } else {
            error_log("Failed to fetch job details: " . $db->error);
            header("Location: index.php?controller=client&action=viewJobs&error=db_error");
            exit();
        }
    
        // Load the job details view
        include 'views/client/job_tracking.php';
    }
    

    
    public function updateJobStatus()
    {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        if (!isset($_POST['job_id']) || !isset($_POST['status'])) {
            header("Location: index.php?controller=client&action=viewJob&error=invalid_input");
            exit();
        }
    
        $jobId = $_POST['job_id'];
        $status = $_POST['status'];
        $db = Database::getConnection();
    
        // Update job status
        $stmt = $db->prepare("UPDATE jobs SET status = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $status, $jobId);
            $stmt->execute();
            $stmt->close();
            header("Location: index.php?controller=client&action=viewJob&job_id=$jobId&success=status_updated");
            exit();
        } else {
            error_log("Failed to update job status: " . $db->error);
            header("Location: index.php?controller=client&action=viewJob&job_id=$jobId&error=db_error");
            exit();
        }
    }
    



public function checkAllMilestonesCompleted($jobId) {
    $milestoneModel = new Milestone();
    // Fetch all milestones for the given job
    $milestones = $milestoneModel->getMilestonesByJobId($jobId);

    // Check if all milestones are completed
    foreach ($milestones as $milestone) {
        if ($milestone['status'] != 'completed') {
            return false; // Return false if any milestone is not completed
        }
    }
    return true; // Return true if all milestones are completed
}

public function makeFullPayment() {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['job_id'])) {
        $jobId = $_GET['job_id'];

        // Ensure the client has marked all milestones as completed
        if ($this->checkAllMilestonesCompleted($jobId)) {
            // Proceed with the payment
            $paymentResult = $this->processPayment($jobId);
            if ($paymentResult) {
                $_SESSION['success_message'] = 'Payment successful!';
                header('Location: index.php?controller=client&action=viewJobTracking');
                exit();
            } else {
                $_SESSION['error_message'] = 'Payment failed. Please try again.';
                header('Location: index.php?controller=client&action=viewJobTracking');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'You must mark all milestones as completed before making the payment.';
            header('Location: index.php?controller=client&action=viewJobTracking');
            exit();
        }
    }
}

 public function uploadReceipt() {
    $jobId = $_GET['job_id'] ?? null;

    if (!$jobId) {
        $_SESSION['error'] = "Invalid job ID.";
        header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $jobId);
        exit;
    }

    require_once 'models/Job.php';
    $job = Job::getJobById($jobId);

    if (!$job) {
        $_SESSION['error'] = "Job not found.";
        header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $jobId);
        exit;
    }

    require 'views/client/upload_receipt.php';
}


    // Method to handle the receipt submission
  public function submitReceipt() {
    session_start(); // Start session to access session variables

    $jobId = $_POST['job_id'] ?? null;
    $clientId = $_SESSION['user_id'] ?? null;

    // Validate session and job ID
    if (!$clientId || !$jobId) {
        $_SESSION['error_message'] = "Invalid session or job ID.";
        header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=$jobId");
        exit;
    }

    // Validate receipt upload
    if (!isset($_FILES['receipt']) || $_FILES['receipt']['error'] !== 0) {
        $_SESSION['error_message'] = "Please upload a valid receipt.";
        header("Location: index.php?controller=client&action=uploadReceipt&job_id=$jobId");
        exit;
    }

    // Handle uploaded file
    $receiptFile = $_FILES['receipt'];
    $filename = uniqid() . '_' . basename($receiptFile['name']);
    $targetDir = 'public/uploads/receipts/';
    $targetPath = $targetDir . $filename;

    // Optional: Validate file type and size
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($receiptFile['type'], $allowedTypes)) {
        $_SESSION['error_message'] = "Invalid file type. Only JPG, PNG, or PDF files are allowed.";
        header("Location: index.php?controller=client&action=uploadReceipt&job_id=$jobId");
        exit;
    }

    if ($receiptFile['size'] > $maxSize) {
        $_SESSION['error_message'] = "File size exceeds the 2MB limit.";
        header("Location: index.php?controller=client&action=uploadReceipt&job_id=$jobId");
        exit;
    }

    // Create receipts directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($receiptFile['tmp_name'], $targetPath)) {
        // Save receipt and update job
        require_once 'models/Payment.php';
        require_once 'models/Job.php';

        // Save in payments table (optional, if you use it)
        Payment::create($jobId, $clientId, $filename);

        // FIXED: Pass filename to update the receipt column
        Job::markAsPaid($jobId, $filename);

        // Notify freelancer
        $freelancerId = Job::getAcceptedFreelancerId($jobId);
        if ($freelancerId) {
            $notificationMessage = "The client has uploaded a payment receipt for the job. Please review it and confirm.";
            $notificationType = 'freelancer';
            $notificationLink = "index.php?controller=freelancer&action=checkPayment&job_id=$jobId";
            $isRead = 0;

            $db = Database::getConnection();
            $notifStmt = $db->prepare("INSERT INTO notifications (user_id, type, message, link, is_read, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $notifStmt->bind_param("isssi", $freelancerId, $notificationType, $notificationMessage, $notificationLink, $isRead);
            $notifStmt->execute();
            $notifStmt->close();
        }

        $_SESSION['success_message'] = "Receipt uploaded successfully. Freelancer has been notified.";
        header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=$jobId");
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to upload receipt.";
        header("Location: index.php?controller=client&action=uploadReceipt&job_id=$jobId");
        exit;
    }
}





// ClientController - Review and approve job
public function reviewJob()
{
    session_start();

    if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
        header("Location: index.php?controller=client&action=myJobs&error=invalid_job");
        exit;
    }

    $jobId = (int) $_GET['job_id'];

    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();

    if (!$job) {
        header("Location: index.php?controller=client&action=myJobs&error=not_found");
        exit;
    }

    if ($job['status'] === 'pending_review') {
        require_once 'views/client/review_job.php';
    } else {
        header("Location: index.php?controller=client&action=myJobs");
        exit;
    }
}




// ClientController - Approve job and mark it as completed
public function approveJob()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $jobId = $_POST['job_id'] ?? null;
        $comments = trim($_POST['approval_comments'] ?? '');
        $action = $_POST['action'] ?? null;

        if (!$jobId || !$action) {
            $_SESSION['error_message'] = 'Missing job information or action.';
            header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $jobId);
            exit;
        }

        try {
            $db = Database::getConnection();
            if (!$db) {
                throw new Exception("Database connection failed.");
            }

            // Get freelancer_id, job title, and final attachment file
            $jobStmt = $db->prepare("
                SELECT ja.freelancer_id, j.job_title, j.final_attachment 
                FROM job_applications ja 
                JOIN jobs j ON ja.job_id = j.id 
                WHERE ja.job_id = ? AND j.status = 'pending_review'
            ");
            if (!$jobStmt) {
                throw new Exception("Job SELECT prepare failed: " . $db->error);
            }

            $jobStmt->bind_param("i", $jobId);
            $jobStmt->execute();
            $jobResult = $jobStmt->get_result();
            $job = $jobResult->fetch_assoc();
            $jobStmt->close();

            if (!$job) {
                throw new Exception("Job not found or freelancer not accepted.");
            }

            $freelancerId = $job['freelancer_id'];
            $jobTitle = $job['job_title'];
            $submissionFile = $job['final_attachment'] ?? null;

            // Prepare status update query
            if ($action === 'approve') {
                $sql = "
                    UPDATE jobs 
                    SET status = 'approved', approval_comments = ?, approved_at = NOW() 
                    WHERE id = ? AND status = 'pending_review'
                ";
            } elseif ($action === 'reject') {
                $sql = "
                    UPDATE jobs 
                    SET status = 'in_progress', rejection_comments = ?, approved_at = NULL, is_submitted = 0, final_attachment = NULL 
                    WHERE id = ? AND status = 'pending_review'
                ";
            } else {
                $_SESSION['error_message'] = 'Invalid action.';
                header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $jobId);
                exit;
            }

            $stmt = $db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Status UPDATE prepare failed: " . $db->error);
            }

            $stmt->bind_param("si", $comments, $jobId);
            $success = $stmt->execute();
            $stmt->close();

            // Delete submission file if rejected
            if ($success && $action === 'reject' && $submissionFile && file_exists("public/uploads/" . $submissionFile)) {
                unlink("public/uploads/" . $submissionFile);
            }

            // Notify freelancer
            if ($success) {
                $notificationType = 'freelancer';
                $notificationLink = "index.php?controller=freelancer&action=viewJob&job_id=" . $jobId;
                $isRead = 0;

                $notificationMessage = ($action === 'approve')
                    ? "Congratulations! Your submission for the job '$jobTitle' has been approved by the client."
                    : "Your submission for the job '$jobTitle' has been rejected. Feedback: \"$comments\".";

                $notifStmt = $db->prepare("
                    INSERT INTO notifications (user_id, type, message, link, is_read, created_at)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                if (!$notifStmt) {
                    throw new Exception("Notification INSERT prepare failed: " . $db->error);
                }

                $notifStmt->bind_param("isssi", $freelancerId, $notificationType, $notificationMessage, $notificationLink, $isRead);
                $notifStmt->execute();
                $notifStmt->close();
            }

            $_SESSION['success_message'] = ($action === 'approve') 
                ? 'Job approved and freelancer notified.'
                : 'Job rejected, freelancer notified, and submission removed.';

        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            $_SESSION['error_message'] = 'Database error: ' . $e->getMessage();
        }

        header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $jobId);
        exit();
    }
}

public function rateService() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $serviceId = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
        $clientId = $_SESSION['user_id'];

        if ($serviceId > 0 && $rating !== null && $rating >= 1 && $rating <= 5) {
            $success = Service::saveRating($serviceId, $clientId, $rating);
            if ($success) {
                $_SESSION['flash_message'] = "Rating submitted successfully.";
            } else {
                $_SESSION['flash_message'] = "Failed to submit rating. Please try again.";
            }
        } else {
            $_SESSION['flash_message'] = "Invalid rating submission.";
        }

        header("Location: index.php?controller=client&action=clientDashboard");
        exit;
    }
}




    
}
