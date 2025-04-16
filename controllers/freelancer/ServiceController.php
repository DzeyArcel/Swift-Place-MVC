<?php
require_once 'models/Service.php';
require_once 'config/db.php';

class ServiceController {
    public function postForm() {
        session_start();
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=loginForm");
            exit();
        }

        require 'views/freelancer/post_service.php';
    }

    public function submit() {
        session_start();
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=loginForm");
            exit();
        }

        $freelancer_id = $_SESSION['freelancer_id'];
        $media_path = null;

        // Media upload
        if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
            $upload_dir = 'public/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $media_name = basename($_FILES['media']['name']);
            $media_path = $upload_dir . time() . "_" . $media_name;
            move_uploaded_file($_FILES['media']['tmp_name'], $media_path);
        }

        $duration = intval($_POST['duration']);
        $expires_at = date('Y-m-d H:i:s', strtotime("+$duration days"));

        $data = [
            'freelancer_id' => $freelancer_id,
            'title' => $_POST['service_title'],
            'category' => $_POST['category'],
            'expertise' => $_POST['expertise'],
            'description' => $_POST['description'],
            'skills' => $_POST['skills'],
            'delivery_time' => $_POST['delivery_time'],
            'tags' => $_POST['tags'],
            'media_path' => $media_path,
            'price' => $_POST['price'],
            'duration' => $duration,
            'expires_at' => $expires_at,
        ];

        $service_id = Service::postService($data);

        // Notify clients
        $conn = Database::getConnection();
        $clients = $conn->query("SELECT id FROM users");

        while ($row = $clients->fetch_assoc()) {
            $client_id = $row['id'];
            if ($client_id == $freelancer_id) continue;

            $message = "New service posted: " . $_POST['service_title'];
            $link = "index.php?controller=service&action=view&id=$service_id";

            $notify = $conn->prepare("INSERT INTO notifications (user_id, type, message, link) VALUES (?, 'client', ?, ?)");
            $notify->bind_param("iss", $client_id, $message, $link);
            $notify->execute();
            $notify->close();
        }

        echo "<script>alert('Service posted successfully!'); window.location.href = 'index.php?controller=freelancer&action=dashboard';</script>";
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


    public function updateService()
    {
        session_start();
        if (!isset($_SESSION['freelancer_id'])) {
            header("Location: index.php?controller=freelancer&action=login");
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $freelancer_id = $_SESSION['freelancer_id'];
            $service_id = $_POST['id'];
    
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
                echo "❌ Failed to update service.";
            }
        } else {
            echo "Invalid request method.";
        }
    }
    
    public function deleteService()
{
    session_start();

    if (!isset($_SESSION['freelancer_id'])) {
        header("Location: index.php?controller=freelancer&action=login");
        exit();
    }

    if (!isset($_GET['id'])) {
        echo "❌ Service ID is missing.";
        exit();
    }

    $freelancer_id = $_SESSION['freelancer_id'];
    $service_id = $_GET['id'];

    if (Service::deleteService($service_id, $freelancer_id)) {
        header("Location: index.php?controller=freelancer&action=myServices");
        exit();
    } else {
        echo "❌ Failed to delete service.";
    }
}


}
