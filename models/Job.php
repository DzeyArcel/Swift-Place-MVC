<?php
require_once __DIR__ . '/../config/db.php';

class Job {
    
    public static function getAllJobs() {
        $conn = Database::getConnection();
    
        $stmt = $conn->prepare("
            SELECT jobs.*, users.first_name AS poster_name
            FROM jobs
            JOIN users ON jobs.client_id = users.id
            ORDER BY jobs.created_at DESC
        ");
    
        if ($stmt) {
            $stmt->execute();
            return $stmt->get_result();
        } else {
            echo "❌ MySQL Error: " . $conn->error;
            return new \mysqli_result($conn, null); // Avoid returning null
        }
    }


    public static function create($client_id, $title, $description, $category, $budget, $deadline, $skills, $type, $experience) {
        $conn = Database::getConnection();
    
        $created_at = date('Y-m-d H:i:s'); // get current timestamp
    
        $stmt = $conn->prepare("INSERT INTO jobs (client_id, job_title, job_description, category, budget, deadline, required_skill, job_type, experience_level, created_at) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        $stmt->bind_param("isssdsssss", $client_id, $title, $description, $category, $budget, $deadline, $skills, $type, $experience, $created_at);
    
        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        return false;
    }
    

    public static function notifyFreelancers($job_id, $client_id, $title) {
        $conn = Database::getConnection();
        $result = $conn->query("SELECT id FROM freelancers WHERE id != $client_id");

        while ($row = $result->fetch_assoc()) {
            $freelancer_id = $row['id'];
            $message = "New job posted: $title";
            $link = "job-details.php?id=$job_id";

            $notify = $conn->prepare("INSERT INTO notifications (user_id, type, message, link) VALUES (?, 'freelancer', ?, ?)");
            $notify->bind_param("iss", $freelancer_id, $message, $link);
            $notify->execute();
        }
    }
    public static function deleteExpiredJobs() {
        $db = Database::getConnection();
        $sql = "DELETE FROM jobs WHERE deadline < CURDATE()";
        $db->query($sql);
    }
    

    

    public static function formatTimeSincePost($posted_at) {
        $postedTime = new DateTime($posted_at);
        $now = new DateTime();
        $interval = $postedTime->diff($now);
    
        if ($interval->d > 0) {
            return $interval->d . ' day(s) ago';
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour(s) ago';
        } else {
            return $interval->i . ' minute(s) ago';
        }
    }
    

    public static function getAllActiveJobs() {
        $db = Database::getConnection();
        $sql = "SELECT * FROM jobs WHERE deadline >= CURDATE()";
        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    


    public static function getJobsByClient($client_id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM jobs WHERE client_id = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public static function deleteByClient($job_id, $client_id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM jobs WHERE id = ? AND client_id = ?");
        $stmt->bind_param("ii", $job_id, $client_id);
        return $stmt->execute();
    }
    


    public static function deleteJob($job_id, $client_id) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ? AND client_id = ?");
    $stmt->bind_param("ii", $job_id, $client_id);
    return $stmt->execute();
}
    

public static function getJobByIdAndClient($job_id, $client_id) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND client_id = ?");
    $stmt->bind_param("ii", $job_id, $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public static function update($id, $client_id, $title, $description, $category, $budget, $deadline, $type, $experience) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("UPDATE jobs SET job_title = ?, job_description = ?, category = ?, budget = ?, deadline = ?, job_type = ?, experience_level = ? WHERE id = ? AND client_id = ?");
    $stmt->bind_param("sssdsssii", $title, $description, $category, $budget, $deadline, $type, $experience, $id, $client_id);
    return $stmt->execute();
}


    public static function getAll($conn) {
        $query = "SELECT jobs.*, CONCAT(users.first_name, ' ', users.last_name) AS poster_name
                  FROM jobs 
                  JOIN users ON jobs.client_id = users.id 
                  ORDER BY jobs.created_at DESC";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public static function getAvailableJobs() {
        require 'config/db.php';

        // Delete expired jobs
        $conn->query("DELETE FROM jobs WHERE deadline < CURDATE()");

        $sql = "SELECT jobs.*, CONCAT(users.first_name, ' ', users.last_name) AS poster_name
                FROM jobs 
                JOIN users ON jobs.client_id = users.id 
                ORDER BY jobs.created_at DESC";

        $result = $conn->query($sql);
        $jobs = [];

        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $conn->close();
        return $jobs;
    }
}



?>
