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
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['unread_count'];
        $stmt->close();
        return $count;
    }

    public function getNotificationsByUser($freelancer_id) {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND type = 'freelancer' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notifications;
    }

    public function markAsRead($id, $freelancer_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND type = 'freelancer'");
        $stmt->bind_param("ii", $id, $freelancer_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteNotification($id, $freelancer_id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ? AND type = 'freelancer'");
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
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notifications;
    }

    public function markAsRead($id, $client_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND type = 'client'");
        $stmt->bind_param("ii", $id, $client_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteNotification($id, $client_id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ? AND type = 'client'");
        $stmt->bind_param("ii", $id, $client_id);
        $stmt->execute();
        $stmt->close();
    }
}


?>