<?php
require_once 'models/Freelancer.php';
require_once 'config/db.php';
require_once 'models/Notification.php';
require_once 'models/Job.php';
require_once 'models/Service.php';

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

public function dashboard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Redirect if not logged in
    if (!isset($_SESSION['freelancer_id'])) {
        header("Location: /Swift-Place/index.php?controller=freelancer&action=loginForm");
        exit();
    }

    $conn = Database::getConnection();
    $freelancer_id = $_SESSION['freelancer_id'];
    $freelancer_name = $_SESSION['freelancer_name'] ?? "Freelancer";

    // Use Notification as object
    $notificationModel = new FreelancerNotification($conn);
    $unread_notifications = $notificationModel->getUnreadCount($freelancer_id);
    $notifications = $notificationModel->getNotificationsByUser($freelancer_id);

    // Other models
    $jobs = Job::getAllJobs();
    $services = Service::getAllServices();

    // View
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
    
            if (isset($_POST['save'])) {
                if ($model->profileExists($freelancer_id)) {
                    $model->updateProfile($freelancer_id, $phone, $address, $skills, $experience, $bio);
                } else {
                    $model->createProfile($freelancer_id, $phone, $address, $skills, $experience, $bio);
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
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        require_once 'models/Notification.php';
        $model = new Notification(Database::getConnection());
    
        $freelancer_id = $_SESSION['freelancer_id'];
    
       // Mark as read
    if (isset($_GET['notification_id'])) {
        $model->markAsRead($_GET['notification_id'], $freelancer_id);
    }

    // Delete
    if (isset($_GET['delete_id'])) {
        $model->deleteNotification($_GET['delete_id'], $freelancer_id);
        header("Location: index.php?controller=freelancer&action=notifications");
        exit();
    }
    
        $notifications = $model->getNotificationsByUser($freelancer_id);
    
        require 'views/freelancer/notifications.php';
    }
    
    
}
