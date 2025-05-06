<?php
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ClientProfile.php';
require_once __DIR__ . '/../../models/Job.php';
require_once __DIR__ . '/../../models/Service.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Notification.php';
require_once __DIR__ . '/../../models/Application.php';


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
        include 'views/client/job_details.php';
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
    

    public function sendMessage()
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    // Get data from the form
    if (!isset($_POST['message']) || empty($_POST['message']) || !isset($_POST['job_id'])) {
        header("Location: index.php?controller=client&action=viewJob&job_id=" . $_POST['job_id'] . "&error=message_empty");
        exit();
    }

    $message = $_POST['message'];
    $jobId = $_POST['job_id'];
    $userId = $_SESSION['user_id']; // Assuming the session stores the logged-in client's ID

    $db = Database::getConnection();

    // Store the message in the database (you may create a separate table for messages)
    $stmt = $db->prepare("INSERT INTO messages (job_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    if ($stmt) {
        $stmt->bind_param("iis", $jobId, $userId, $message);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?controller=client&action=viewJob&job_id=$jobId&success=message_sent");
        exit();
    } else {
        error_log("Failed to send message: " . $db->error);
        header("Location: index.php?controller=client&action=viewJob&job_id=$jobId&error=db_error");
        exit();
    }
}

    
    

    
}
