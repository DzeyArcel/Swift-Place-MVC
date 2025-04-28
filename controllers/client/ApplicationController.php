<?php

require_once __DIR__ . '/../../config/db.php';

class ApplicationController
{
    // Accept application
    public function acceptApplication()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $applicationId = $_POST['application_id'];

        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE job_applications SET status = 'accepted' WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $applicationId);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: index.php?controller=client&action=viewApplications&success=accepted");
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
            // Fetch the freelancer's ID related to this application
            $stmt = $db->prepare("SELECT freelancer_id FROM job_applications WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare SELECT query: " . $db->error);
            }
    
            $stmt->bind_param("i", $applicationId);
            $stmt->execute();
            $stmt->bind_result($freelancerId);
            $stmt->fetch();
            $stmt->close();
    
            if ($freelancerId) {
                // Insert a notification for the freelancer
                $notificationMessage = "Your application has been rejected by the client.";
                $notificationType = 'application';  // Set type for the notification
                $notificationLink = '';  // Can be used for links to application or job, if necessary
                $isRead = 0;  // Initial state of notification is 'unread'
                $stmt = $db->prepare("INSERT INTO notifications (user_id, type, message, link, is_read, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    
                // Check if prepare() succeeded
                if (!$stmt) {
                    throw new Exception("Failed to prepare INSERT query: " . $db->error);
                }
    
                $stmt->bind_param("isssi", $freelancerId, $notificationType, $notificationMessage, $notificationLink, $isRead);
                $stmt->execute();
                $stmt->close();
            }
    
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
