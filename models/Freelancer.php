<?php
require_once __DIR__ . '/../config/db.php';

class Freelancer {
    public static function create($first_name, $last_name, $email, $password, $job_category, $experience, $skills, $portfolio_link) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("INSERT INTO freelancers (first_name, last_name, email, password, job_category, experience, skills, portfolio_link) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $password, $job_category, $experience, $skills, $portfolio_link);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return true;
    }

    public static function findByEmail($email) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("SELECT * FROM freelancers WHERE email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc(); // returns false if no match
    }
}
