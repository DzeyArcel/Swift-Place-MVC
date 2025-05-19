<?php
require_once __DIR__ . '/../config/db.php';

class Job {
    
    public static function getAllJobs() {
    $conn = Database::getConnection();

    $stmt = $conn->prepare("
        SELECT jobs.*, 
               users.first_name AS poster_name, 
               client_profiles.profile_pic AS client_profile_picture
        FROM jobs
        JOIN users ON jobs.client_id = users.id
        JOIN client_profiles ON users.id = client_profiles.user_id
        WHERE jobs.status = 'open'
        ORDER BY jobs.posted_at DESC
    ");

    if ($stmt) {
        $stmt->execute();
        return $stmt->get_result();
    } else {
        error_log("❌ MySQL Error: " . $conn->error);
        return []; // Return empty array to indicate no results
    }
}



public static function create($client_id, $title, $description, $category, $budget, $deadline, $skills, $type, $experience) {
    $conn = Database::getConnection();

    $created_at = date('Y-m-d H:i:s'); // get current timestamp
    $status = 'open'; // set default status

    $stmt = $conn->prepare("INSERT INTO jobs (client_id, job_title, job_description, category, budget, deadline, required_skill, job_type, experience_level, status, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssdssssss", $client_id, $title, $description, $category, $budget, $deadline, $skills, $type, $experience, $status, $created_at);

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
    
        if ($interval->d >= 30) {
            return $postedTime->format('F j, Y'); // Example: March 14, 2025
        } elseif ($interval->d > 0) {
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
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



public static function findById($jobId) {
    $conn = Database::getConnection();

    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return false;
}

// In Job model
public static function getJobById($job_id) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    $stmt->close();
    return $job;
}



public static function markAsInProgress($jobId, $freelancerId)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE jobs SET status = 'in_progress', assigned_to = ? WHERE id = ?");
    return $stmt->execute([$freelancerId, $jobId]);
}
public static function getMilestones($jobId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, title, status, due_date FROM job_milestones WHERE job_id = ?");
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $milestones = [];
        $stmt->bind_result($milestoneId, $milestoneTitle, $milestoneStatus, $milestoneDueDate);
        while ($stmt->fetch()) {
            $milestones[] = [
                'id' => $milestoneId,
                'title' => $milestoneTitle,
                'status' => $milestoneStatus,
                'due_date' => $milestoneDueDate
            ];
        }
        $stmt->close();
        return $milestones;
    }

    public static function getJobWithClient($jobId) {
        // Assuming the database connection is available
        $db = Database::getConnection();
    
        // Prepare the SQL query to get the job details and associated client
        $sql = "
            SELECT j.*, u.first_name, u.last_name, job_description
            FROM jobs j
            JOIN users u ON j.client_id = u.id
            WHERE j.id = ?
        ";
    
        $stmt = $db->prepare($sql);
    
        // Check for errors in the prepare statement
        if ($stmt === false) {
            die('MySQL prepare error: ' . $db->error);
        }
    
        // Bind the job ID to the prepared statement
        $stmt->bind_param("i", $jobId);  // "i" means the parameter is an integer
    
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute error: ' . $stmt->error);
        }
    
        // Get the result
        $result = $stmt->get_result();
    
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the row as an associative array
            return $result->fetch_assoc();
        } else {
            return null; // No job found
        }
    }
    
    
public static function getJobsForFreelancer($freelancerId)
{
    $db = Database::getConnection();

    $sql = "SELECT j.id, j.job_title, j.job_description, j.deadline, j.receipt, j.is_completed, j.budget, 
                   u.first_name, u.last_name
            FROM jobs j
            JOIN users u ON j.client_id = u.id
            JOIN job_applications a ON a.job_id = j.id
            WHERE a.freelancer_id = ?
              AND a.status = 'accepted'
              AND (j.is_completed = 0 OR j.receipt IS NULL)";  // This line excludes finished and paid jobs

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

    
    
    
public static function isJobOwnedByFreelancer($jobId, $freelancerId) {
    $conn = Database::getConnection();

    // Correct query based on your job_applications table structure
    $query = "SELECT COUNT(*) AS total 
              FROM job_applications 
              WHERE job_id = ? AND freelancer_id = ? AND status = 'accepted'";
    
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $jobId, $freelancerId);  // "ii" for two integers (job_id, freelancer_id)
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] > 0;  // Return true if freelancer is linked to this job
}

    
public static function markAsPaid($jobId, $receiptFilename = null) {
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE jobs SET is_completed = 1, receipt = ? WHERE id = ?");
    $stmt->bind_param("si", $receiptFilename, $jobId);
    $stmt->execute();
    $stmt->close();
}


    

    public function updateJobSubmission($jobId, $filePath, $comments)
{
    global $db;

    $query = "UPDATE jobs SET status = 'completed', final_attachment = :filePath, comments = :comments WHERE id = :jobId";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':filePath', $filePath);
    $stmt->bindParam(':comments', $comments);
    $stmt->bindParam(':jobId', $jobId);
    $stmt->execute();
}

    public static function getAcceptedFreelancerId($jobId) {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT freelancer_id FROM job_applications WHERE job_id = ? AND status = 'accepted' LIMIT 1");

    if (!$stmt) {
        throw new Exception("Failed to prepare statement.");
    }

    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($freelancerId);
    $stmt->fetch();
    $stmt->close();

    return $freelancerId;
}

public static function quitJob($jobId, $freelancerId)
{
    $db = Database::getConnection();

    if (!$db) {
        error_log("Database connection failed in quitJob.");
        return false;
    }

    $stmt = $db->prepare("
        UPDATE job_applications 
        SET status = 'withdrawn' 
        WHERE job_id = ? AND freelancer_id = ? AND status = 'accepted'
    ");

    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        return false;
    }

    $stmt->bind_param("ii", $jobId, $freelancerId);
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    // Make sure an actual row was updated
    return $stmt->affected_rows > 0;
}










public static function getById($freelancerId)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT first_name, last_name FROM freelancers WHERE id = ?");
    $stmt->bind_param("i", $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public static function getCompletedJobsForFreelancer($freelancerId)
{
    $db = Database::getConnection();
    $sql = "SELECT j.id, j.job_title, j.job_description, j.deadline, j.receipt, j.is_completed, j.budget, 
                   u.first_name, u.last_name
            FROM jobs j
            JOIN users u ON j.client_id = u.id
            JOIN job_applications a ON a.job_id = j.id
            WHERE a.freelancer_id = ?
              AND a.status = 'accepted'
              AND j.is_completed = 1
              AND j.receipt IS NOT NULL";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getJobsByClientId($clientId) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("
        SELECT jobs.*, 
               users.first_name,
               users.last_name,
               users.email,
               freelancer_profiles.phone,
               freelancer_profiles.profile_pic,
               freelancers.category
        FROM jobs
        LEFT JOIN freelancers ON jobs.freelancer_id = freelancers.id
        LEFT JOIN users ON freelancers.user_id = users.id
        LEFT JOIN freelancer_profiles ON users.id = freelancer_profiles.user_id
        WHERE jobs.client_id = ?
        ORDER BY jobs.posted_at DESC
    ");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    return $stmt->get_result();
}


}



?>
