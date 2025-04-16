<?php
require_once __DIR__ . '/../config/db.php';

class FreelancerNotification {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUnreadCount($freelancer_id) {
        $query = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['unread_count'];
        $stmt->close();
        return $count;
    }

    public function getNotificationsByUser($freelancer_id) {
        $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notifications;
    }

    public function markAsRead($id, $user_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteNotification($id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}


    class ClientNotification {
        private $conn;
    
        public function __construct($conn) {
            $this->conn = $conn;
        }
    
        public function getNotificationsByUser($user_id) {
            $stmt = $this->conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->get_result();
        }
    
        public function markAsRead($id, $user_id) {
            $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    
        public function deleteNotification($id, $user_id) {
            $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    

