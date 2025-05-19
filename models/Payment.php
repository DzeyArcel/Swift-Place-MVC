<?php
require_once 'config/db.php';
class Payment {
// In Payment.php
 public static function create($jobId, $clientId, $filename) {
        // Get the database connection
        $db = Database::getConnection();

        // Prepare the SQL query
        $stmt = $db->prepare("INSERT INTO payments (job_id, client_id, receipt_file, uploaded_at) VALUES (?, ?, ?, NOW())");

        // Check if the statement preparation failed
        if ($stmt === false) {
            // Output detailed error information for debugging
            throw new Exception("Failed to prepare the SQL statement. MySQL Error: " . $db->error);
        }

        // Bind the parameters and execute the statement
        $stmt->bind_param("iis", $jobId, $clientId, $filename);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the SQL query. MySQL Error: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    }


    public static function getByJobId($jobId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM payments WHERE job_id = ?");
        $stmt->execute([$jobId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
