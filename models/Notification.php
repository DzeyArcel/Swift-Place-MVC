<?php
require_once __DIR__ . '/../config/db.php';



class FreelancerNotification {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUnreadCount($freelancer_id) {
        $query = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND type = 'freelancer' AND is_read = 0";
        $stmt = $this->conn->prepare($query);

        // Check if the statement preparation was successful
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ensure there is a result
        $count = $result ? $result->fetch_assoc()['unread_count'] : 0;

        $stmt->close();
        return $count;
    }

    // Get all notifications for the freelancer
    public function getNotificationsByUser($freelancer_id) {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND type = 'freelancer' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);

        // Check if the statement preparation was successful
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ensure there are results and handle empty cases
        $notifications = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $notifications;
    }

    // Mark a notification as read
    public function markAsRead($id, $freelancer_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND type = 'freelancer'");

        // Check if the statement preparation was successful
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $freelancer_id);
        $stmt->execute();
        $stmt->close();
    }

    // Delete a notification
    public function deleteNotification($id, $freelancer_id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ? AND type = 'freelancer'");

        // Check if the statement preparation was successful
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $freelancer_id);
        $stmt->execute();
        $stmt->close();
    }
}

class ClientNotification {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUnreadCount($client_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM notifications WHERE user_id = ? AND type = 'client' AND is_read = 0");

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] ?? 0;
    }

    public function getNotificationsByUser($client_id) {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND type = 'client' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // If statement preparation fails, log the error and return an empty array
            error_log("MySQL Error: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch results as an associative array
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notifications;
    }

    // Mark a notification as read
    public function markAsRead($id, $client_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND type = 'client'");

        if (!$stmt) {
            // If statement preparation fails, log the error
            error_log("MySQL Error: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("ii", $id, $client_id);
        $result = $stmt->execute();
        $stmt->close();

        // Return true if the update was successful, false otherwise
        return $result;
    }

    // Delete a notification for a specific client
    public function deleteNotification($id, $client_id) {
        // Prepare DELETE statement
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ? AND type = 'client'");
        
        if (!$stmt) {
            error_log("MySQL Error (prepare): " . $this->conn->error); // Log any prepare statement issues
            return false;
        }
    
        // Bind parameters
        $stmt->bind_param("ii", $id, $client_id);
    
        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Successful deletion
        } else {
            error_log("MySQL Error (execution): " . $stmt->error); // Log any execution errors
            $stmt->close();
            return false; // Failure to delete
        }
    }
    
}


?>