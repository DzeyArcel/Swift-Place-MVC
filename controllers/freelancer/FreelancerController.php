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
                header("Location: /Swift-Place/index.php?controller=freelancer&action=loginForm");
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
        $conn = Database::getConnection();

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
            exit();
        }

        $stmt = $conn->prepare("SELECT id, first_name, password FROM freelancers WHERE email = ?");
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $first_name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['freelancer_id'] = $id;
                $_SESSION['freelancer_name'] = $first_name;
                header("Location: /Swift-Place/index.php?controller=freelancer&action=dashboard");
                exit();
            } else {
                echo "<script>alert('Invalid password.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
                exit();
            }
        } else {
            echo "<script>alert('No account found with that email.'); window.location.href='index.php?controller=freelancer&action=loginForm';</script>";
            exit();
        }
    }

    public function loginForm() {
        require 'views/auth/freelancer_login.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /Swift-Place/index.php?controller=freelancer&action=loginForm");
        exit();
    }

    public function dashboard() {
        session_start();
    
        // Redirect to login if not logged in
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: /Swift-Place/index.php?controller=freelancer&action=loginForm");
            exit();
        }
    
        // DB connection
        $conn = Database::getConnection();
    
        // Session variables
        $freelancer_id = $_SESSION['freelancer_id'];
        $freelancer_name = $_SESSION['freelancer_name'] ?? "Freelancer";
    
        // Fetch data via models
        $unread_notifications = Notification::getUnreadCount($conn, $freelancer_id);
        $notifications = Notification::getAll($conn, $freelancer_id);
        $jobs = Job::getAllJobs(); // Can be filtered to active ones only
        $services = Service::getAllServices(); // All services (or filter if needed)
    
        // Pass data to view
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
    

    public function editService()
    {
        session_start();
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }

        $freelancer_id = $_SESSION['freelancer_id'];
        if (!isset($_GET['id'])) {
            echo "Service ID missing.";
            return;
        }

        $service_id = $_GET['id'];
        $service = Service::getServiceById($service_id, $freelancer_id);

        if (!$service) {
            echo "Service not found or access denied.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $service_id,
                'freelancer_id' => $freelancer_id,
                'service_title' => $_POST['service_title'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'skills' => $_POST['skills'],
                'price' => $_POST['price'],
                'delivery_time' => $_POST['delivery_time'],
                'expertise' => $_POST['expertise'],
                'tags' => $_POST['tags'],
                'media_path' => $_POST['media_path'] ?? ''
            ];

            if (Service::updateService($data)) {
                header("Location: index.php?controller=freelancer&action=myServices");
                exit();
            } else {
                echo "Failed to update service.";
            }
        }

        require 'views/freelancer/edit_service.php';
    }
    
}
