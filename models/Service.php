<?php
require_once __DIR__ . '/../config/db.php'; // Adjust path as needed

class Service {

    
    public static function getAllServices() {
        $conn = Database::getConnection();
    
        // Join with freelancers table to get first_name and last_name
        $query = "
            SELECT services.*, freelancers.first_name, freelancers.last_name
            FROM services
            JOIN freelancers ON services.freelancer_id = freelancers.id
        ";
    
        $stmt = $conn->prepare($query);
    
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $services = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
    
        return $services;
    }

    public static function getServicesByFreelancer($freelancer_id)
    {
        $conn = Database::getConnection();
        $services = [];
    
        $stmt = $conn->prepare("SELECT s.*, CONCAT(f.first_name, ' ', f.last_name) AS freelancer_name 
                                FROM services s 
                                JOIN freelancers f ON s.freelancer_id = f.id 
                                WHERE s.freelancer_id = ? 
                                ORDER BY s.created_at DESC");
    
        if ($stmt) {
            $stmt->bind_param("i", $freelancer_id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
    
            $stmt->close();
        }
    
        return $services;
    }
    
    public static function getServiceById($id, $freelancer_id)
    {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("SELECT * FROM services WHERE id = ? AND freelancer_id = ?");
        $stmt->bind_param("ii", $id, $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $service;
    }
    

    public static function updateService($data)
    {
        $conn = Database::getConnection();
    
        $stmt = $conn->prepare("UPDATE services SET service_title = ?, category = ?, description = ?, skills = ?, price = ?, delivery_time = ?, expertise = ?, tags = ?, media_path = ? WHERE id = ? AND freelancer_id = ?");
        
        if (!$stmt) {
            echo "Prepare failed: " . $conn->error;
            return false;
        }
    
        $stmt->bind_param(
            "sssssssssii",  // adjust if delivery_time is numeric
            $data['service_title'],
            $data['category'],
            $data['description'],
            $data['skills'],
            $data['price'],
            $data['delivery_time'],
            $data['expertise'],
            $data['tags'],
            $data['media_path'],
            $data['id'],
            $data['freelancer_id']
        );
    
        if (!$stmt->execute()) {
            echo "Execute failed: " . $stmt->error;
            return false;
        }
    
        $stmt->close();
        $conn->close();
        return true;
    }
    

    public static function postService($data) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("INSERT INTO services 
            (freelancer_id, service_title, category, expertise, description, skills, delivery_time, tags, media_path, price, rating, duration, expires_at, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, NOW())");

        $stmt->bind_param(
            "issssssssdds",
            $data['freelancer_id'],
            $data['title'],
            $data['category'],
            $data['expertise'],
            $data['description'],
            $data['skills'],
            $data['delivery_time'],
            $data['tags'],
            $data['media_path'],
            $data['price'],
            $data['duration'],
            $data['expires_at']
        );

        $stmt->execute();
        $insertedId = $stmt->insert_id;
        $stmt->close();

        return $insertedId;
    }

    public static function deleteService($service_id, $freelancer_id)
{
    $conn = Database::getConnection();

    $stmt = $conn->prepare("DELETE FROM services WHERE id = ? AND freelancer_id = ?");
    $stmt->bind_param("ii", $service_id, $freelancer_id);

    $success = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $success;
}

}
