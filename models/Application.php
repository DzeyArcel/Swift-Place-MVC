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

    
}
?>