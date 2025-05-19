<?php

require_once __DIR__ . '/../../config/db.php';

class ApplicationController
{
    public function acceptApplication() {
        session_start();
    
        if (!isset($_GET['application_id'])) {
            header("Location: index.php?controller=client&action=viewApplications&error=missing_id");
            exit();
        }
    
        $application_id = $_GET['application_id'];
        $userId = $_SESSION['user_id'];
        $db = Database::getConnection();
    
        // 1. Get job_id and freelancer_id
        $stmt = $db->prepare("SELECT job_id, freelancer_id FROM job_applications WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $db->error);
        }
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $stmt->bind_result($jobId, $freelancerId);
        $stmt->fetch();
        $stmt->close();
    
        // 2. Reject all other applications
        $stmt = $db->prepare("UPDATE job_applications SET status = 'rejected' WHERE job_id = ? AND id != ?");
        if (!$stmt) {
            die("Error preparing statement (reject others): " . $db->error);
        }
        $stmt->bind_param("ii", $jobId, $application_id);
        $stmt->execute();
        $stmt->close();
    
        // 3. Accept the current application
        $stmt = $db->prepare("UPDATE job_applications SET status = 'accepted' WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement (accept current): " . $db->error);
        }
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $stmt->close();
    
        // 4. Mark the job as in-progress
        $stmt = $db->prepare("UPDATE jobs SET status = 'in-progress' WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement (update job): " . $db->error);
        }
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $stmt->close();
    
        // 5. Get job title
        $stmt = $db->prepare("SELECT job_title FROM jobs WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement (get title): " . $db->error);
        }
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $stmt->bind_result($jobTitle);
        $stmt->fetch();
        $stmt->close();
    
        // 6. Send notification to freelancer
        $notificationMessage = "Congratulations! Your application for the job '$jobTitle' has been accepted by the client.";
        $notificationType = 'freelancer';
        $notificationLink = '';
        $isRead = 0;
    
        $stmt = $db->prepare("INSERT INTO notifications (user_id, type, message, link, is_read, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if (!$stmt) {
            die("Error preparing statement (notify): " . $db->error);
        }
        $stmt->bind_param("isssi", $freelancerId, $notificationType, $notificationMessage, $notificationLink, $isRead);
        $stmt->execute();
        $stmt->close();
    
        // 7. Redirect
        header("Location: index.php?controller=client&action=viewApplications&accepted=true");
        exit();
    }
    
    
    
    


    // Reject application
    public function rejectApplication()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    
        $applicationId = $_POST['application_id'];
    
        $db = Database::getConnection();
    
        // Begin a transaction for both rejecting, deleting, and creating notification
        $db->begin_transaction();
        
        try {
            // Fetch the freelancer's ID and job title related to this application
            $stmt = $db->prepare("SELECT freelancer_id, job_id FROM job_applications WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare SELECT query: " . $db->error);
            }
    
            $stmt->bind_param("i", $applicationId);
            $stmt->execute();
            $stmt->bind_result($freelancerId, $jobId);
            $stmt->fetch();
            $stmt->close();
    
            if (!$freelancerId) {
                throw new Exception("Freelancer ID not found for application ID: $applicationId");
            }
    
            // Fetch the job title for the notification
            $stmt = $db->prepare("SELECT job_title FROM jobs WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare SELECT query for job title: " . $db->error);
            }
    
            $stmt->bind_param("i", $jobId);
            $stmt->execute();
            $stmt->bind_result($jobTitle);
            $stmt->fetch();
            $stmt->close();
    
            if (!$jobTitle) {
                throw new Exception("Job title not found for job ID: $jobId");
            }
    
            // Log the values (for debugging)
            error_log("Freelancer ID: $freelancerId, Job Title: $jobTitle");
    
            // Insert a notification for the freelancer with the job title
            $notificationMessage = "Your application for the job '$jobTitle' has been rejected by the client.";
            $notificationType = 'freelancer';  // Set type for the notification
            $notificationLink = '';  // Can be used for links to application or job, if necessary
            $isRead = 0;  // Initial state of notification is 'unread'
            
            $stmt = $db->prepare("INSERT INTO notifications (user_id, type, message, link, is_read, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

            // Check if prepare() succeeded
            if (!$stmt) {
                throw new Exception("Failed to prepare INSERT query: " . $db->error);
            }
    
            $stmt->bind_param("isssi", $freelancerId, $notificationType, $notificationMessage, $notificationLink, $isRead); // KEEP AS IS

            $stmt->execute();
            $stmt->close();
    
            // Reject the application (update status)
            $stmt = $db->prepare("UPDATE job_applications SET status = 'rejected' WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare UPDATE query: " . $db->error);
            }
    
            $stmt->bind_param("i", $applicationId);
            $stmt->execute();
            $stmt->close();
    
            // Delete the application from the database
            $stmt = $db->prepare("DELETE FROM job_applications WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare DELETE query: " . $db->error);
            }
    
            $stmt->bind_param("i", $applicationId);
            $stmt->execute();
            $stmt->close();
    
            // Commit the transaction if all queries succeed
            $db->commit();
    
            // Redirect to view applications with a success message
            header("Location: index.php?controller=client&action=viewApplications&success=rejected");
            exit();
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $db->rollback();
            echo "❌ Error rejecting, deleting application, and notifying freelancer: " . $e->getMessage();
            exit();
        }
    }
    
    
}
