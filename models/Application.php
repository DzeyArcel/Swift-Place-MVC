<?php
require_once __DIR__ . '/../config/db.php';

class Application
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO job_applications 
            (freelancer_id, job_id, cover_letter, expected_duration, 
             experience_summary, skills_used, questions_clarifications, availability, attachment) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param(
            "iisssssss",
            $data['freelancer_id'],
            $data['job_id'],
            $data['cover_letter'],
            $data['expected_duration'],
            $data['experience_summary'],
            $data['skills_used'],
            $data['questions_clarifications'],
            $data['availability'],
            $data['attachment']
        );
    
        return $stmt->execute();
    }
    


public function getApplicationsByClient($clientId)
{
    $sql = "
        SELECT ja.*, j.job_title AS job_title, f.first_name AS freelancer_name
        FROM job_applications ja
        JOIN jobs j ON ja.job_id = j.id
        JOIN freelancers f ON ja.freelancer_id = f.id
        WHERE j.client_id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("❌ SQL prepare() failed: " . $this->conn->error);
    }

    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


public static function findById($id)
{
    $db = Database::getConnection();
    
    // Check if connection is successful
    if ($db->connect_error) {
        error_log("Database connection failed: " . $db->connect_error); // Log error if connection fails
        return false;
    }

    $query = "SELECT a.*, j.title AS job_title FROM job_applications a JOIN jobs j ON a.job_id = j.id WHERE a.id = ?";

    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('i', $id); // Bind integer parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            error_log("No application found with ID: " . $id); // Log if no result is found
            return false;
        }
    } else {
        // Prepare failed, log the error
        error_log("Failed to prepare query: " . $db->error);
        return false;
    }
}



public static function accept($id)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE job_applications SET status = 'accepted' WHERE id = ?");
    return $stmt->execute([$id]);
}

public static function rejectOthers($jobId, $acceptedId)
{
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE job_applications SET status = 'rejected' WHERE job_id = ? AND id != ?");
    return $stmt->execute([$jobId, $acceptedId]);
}

public function getAcceptedFreelancerByJobId($jobId)
{
    $stmt = $this->conn->prepare("
        SELECT f.*, fp.profile_picture 
        FROM job_applications ja
        JOIN freelancers f ON ja.freelancer_id = f.id
        LEFT JOIN freelancer_profile fp ON f.id = fp.freelancer_id
        WHERE ja.job_id = ? AND ja.status = 'accepted'
        LIMIT 1
    ");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


public static function getJobIdByApplicationId($applicationId) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT job_id FROM job_applications WHERE id = ?");
    $stmt->bind_param("i", $applicationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['job_id'];
    } else {
        return null;
    }
}

public function getAllAcceptedApplicationsByJobId($jobId) {
    $conn = $this->conn;

    // Prepare the SQL query to get accepted applications along with freelancer details
    $stmt = $conn->prepare("
        SELECT a.id AS application_id, f.first_name, f.last_name, f.email
        FROM job_applications a
        JOIN freelancers f ON a.freelancer_id = f.id
        WHERE a.job_id = ? AND a.status = 'accepted'
    ");

    // Bind the job ID parameter
    $stmt->bind_param("i", $jobId);
    
    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch all results as an associative array
    $applications = $result->fetch_all(MYSQLI_ASSOC);
    
    // Close the statement
    $stmt->close();

    // Return the list of accepted applications
    return $applications;
}


public static function getById($id) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT * FROM job_applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

public static function getAcceptedApplicationByFreelancerId($freelancerId) {
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT * FROM job_applications WHERE freelancer_id = ? AND status = 'accepted' LIMIT 1");
    $stmt->bind_param("i", $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

}
?>