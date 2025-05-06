<?php
// models/Milestone.php

require_once 'config/db.php';

class Milestone {

    // Get milestones by application ID
    public static function getByApplicationId($applicationId) {
        $conn = Database::getConnection(); // Get the database connection
    
        // Prepare SQL query (assuming the correct column name is 'job_id' instead of 'application_id')
        $stmt = $conn->prepare("SELECT * FROM job_milestones WHERE job_id = ?");
        
        // Check for errors in prepare()
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        
        // Bind the applicationId parameter (which is actually job_id)
        $stmt->bind_param("i", $applicationId); // Assuming $applicationId is actually a job_id
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch all milestones
        $milestones = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $milestones;
    }
    
    
    // Create a new milestone
    public static function create($applicationId, $title, $description, $amount, $dueDate) {
        $conn = Database::getConnection(); // Get the database connection
        $status = 'in_progress';

        // Prepare SQL query
        $stmt = $conn->prepare("INSERT INTO job_milestones (application_id, title, description, amount, due_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Check for errors in prepare()
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        
        $stmt->bind_param("issdss", $applicationId, $title, $description, $amount, $dueDate, $status);
        $stmt->execute();
        $stmt->close();
    }

    // Mark milestone as completed
    public static function markCompleted($milestoneId) {
        $conn = Database::getConnection(); // Get the database connection

        // Prepare SQL query
        $stmt = $conn->prepare("UPDATE job_milestones SET status = 'completed' WHERE id = ?");
        
        // Check for errors in prepare()
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        
        $stmt->bind_param("i", $milestoneId);
        $stmt->execute();
        $stmt->close();
    }
    public static function getByJobId($jobId) {
        $db = Database::getConnection();  // ✅ Don't rely on global $db

        if (!$db) {
            die('Database connection failed.');
        }

        $sql = "SELECT * FROM job_milestones WHERE job_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("i", $jobId);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    
}
?>
