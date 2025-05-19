<?php
// models/Milestone.php

require_once 'config/db.php';

class Milestone {

    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::getConnection(); // Make sure your Database class provides a connection method
    }

    // Get milestones by job ID
    public static function getByJobId($jobId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM job_milestones WHERE job_id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Create a new milestone
    public static function create($jobId, $freelancerId, $title, $description, $status, $dueDate, $attachment = null) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO job_milestones (job_id, freelancer_id, title, description, status, due_date, attachment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iisssss", $jobId, $freelancerId, $title, $description, $status, $dueDate, $attachment);
        return $stmt->execute();
    }

    public static function delete($id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM job_milestones WHERE id = ?");
        $stmt->bind_param("i", $id); // 'i' = integer
        return $stmt->execute();
    }
    

    // Update milestone method
    public function updateMilestone($milestoneId, $title, $status, $dueDate, $description, $attachmentName = null)
    {
        $sql = "UPDATE job_milestones SET title = ?, status = ?, due_date = ?, description = ?, attachment = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssssi', $title, $status, $dueDate, $description, $attachmentName, $milestoneId);

        return $stmt->execute();
    }
    


    // Mark milestone with custom status
    public static function markStatus($milestoneId, $status) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE job_milestones SET status = ? WHERE id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $status, $milestoneId);
        return $stmt->execute();
    }

    // Get a milestone by its ID
    public static function getById($milestoneId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM job_milestones WHERE id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $milestoneId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Add a new milestone to the database
 public function addMilestone($jobId, $title, $description, $status, $dueDate, $attachment = null) {
     $db = Database::getConnection(); // Assuming $db is a mysqli connection

     // Insert query - Notice the ID is not included here as it's auto-incrementing
     $sql = "INSERT INTO job_milestones (job_id, title, description, status, due_date, attachment) 
             VALUES (?, ?, ?, ?, ?, ?)";

     // Prepare statement
     $stmt = $db->prepare($sql);
     if ($stmt === false) {  
         return false; // Return false if statement preparation fails
     }

     // Bind parameters
     // "i" = integer, "s" = string, "d" = double (for date), "b" = blob for file
     $stmt->bind_param("isssss", $jobId, $title, $description, $status, $dueDate, $attachment);

     // Execute the statement
     return $stmt->execute();
 }

public static function getJobIdByMilestone($milestoneId) {
    $db = Database::getConnection();

    // Prepare SQL statement
    $stmt = $db->prepare("SELECT job_id FROM job_milestones WHERE id = ?");
    if (!$stmt) {
        error_log("Error preparing query: " . $db->error);
        return null;
    }

    // Bind the parameter
    $stmt->bind_param("i", $milestoneId);

    // Execute the statement
    if (!$stmt->execute()) {
        error_log("Error executing query: " . $stmt->error);
        return null;
    }

    // Get result and fetch data
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        return $row['job_id'] ?? null;
    }

    // No result found, log and return null
    error_log("No job_id found for milestoneId: $milestoneId");
    return null;
}



 public function updateMilestoneStatus($milestoneId, $status) {
        $db = Database::getConnection();
        $sql = "UPDATE job_milestones SET status = ? WHERE id = ?";
        
        $stmt = $db->prepare($sql);
        if ($stmt === false) {
            return false; // Error preparing the statement
        }

        // Bind parameters
        $stmt->bind_param("si", $status, $milestoneId);

        // Execute and check for success
        return $stmt->execute();
    }
 public function markAsCompleted($milestoneId) {
    $db = Database::getConnection();
    
    // Update milestone status to 'completed'
    $sql = "UPDATE job_milestones SET status = 'completed' WHERE id = ?";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $milestoneId);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

public function countAllMilestones($jobId) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM job_milestones WHERE job_id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}


// Milestone.php (Model)
public static function updateStatus($id, $status)
{
    $db = Database::getConnection();

    $stmt = $db->prepare("UPDATE job_milestones SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id); // "s" for string, "i" for integer
    $stmt->execute();
}


}
