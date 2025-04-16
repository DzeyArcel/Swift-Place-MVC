<?php
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ClientProfile.php';
require_once __DIR__ . '/../../models/Job.php';
require_once __DIR__ . '/../../models/Service.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Notification.php';

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
                echo "<script>alert('Invalid email format.'); window.location='/Swift-Place/views/auth/login.php';</script>";
                exit();
            }

            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
                $remaining_time = $_SESSION['lockout_time'] - time();
                if ($remaining_time > 0) {
                    echo "<script>alert('Too many failed attempts. Try again in " . ceil($remaining_time / 60) . " minutes.'); window.location='/Swift-Place/views/auth/login.php';</script>";
                    exit();
                } else {
                    unset($_SESSION['login_attempts']);
                    unset($_SESSION['lockout_time']);
                }
            }

            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                unset($_SESSION['login_attempts'], $_SESSION['lockout_time']);

                header("Location: /Swift-Place/index.php?controller=client&action=clientDashboard");
                exit();
            } else {
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['lockout_time'] = time() + $lockout_time;
                }
                echo "<script>alert('Invalid email or password.'); window.location='/Swift-Place/views/auth/login.php';</script>";
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
        $jobs = Job::getAllJobs();
        Job::deleteExpiredJobs();
        $services = Service::getAllServices();
    
        // Load Client Notifications
     
        $notifModel = new ClientNotification($conn);
        $notifications = $notifModel->getNotificationsByUser($client_id);
    
        // Calculate unread notifications
        $unread_notifications = 0;
        if ($notifications) {
            foreach ($notifications as $notif) {
                if ($notif['is_read'] == 0) {
                    $unread_notifications++;
                }
            }
        }
    
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
    
        if (!isset($_SESSION['client_id'])) {
            header("Location: index.php?controller=client&action=login");
            exit();
        }
    
        $client_id = $_SESSION['client_id'];
    
        require_once 'models/Notification.php';
        $model = new ClientNotification(Database::getConnection());
    
        // Mark as read
        if (isset($_GET['notification_id'])) {
            $model->markAsRead($_GET['notification_id'], $client_id);
        }
    
        // Delete notification
        if (isset($_GET['delete_id'])) {
            $model->deleteNotification($_GET['delete_id'], $client_id);
            header("Location: index.php?controller=client&action=notifications");
            exit();
        }
    
        $notifications = $model->getNotificationsByUser($client_id);
    
        require 'views/client/notifications.php';
    }
    
}
