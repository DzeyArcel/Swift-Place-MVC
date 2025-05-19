<?php
require_once 'models/Milestone.php';


class MilestoneController
{
    public function edit()
{
    if (!isset($_GET['milestone_id'])) {
        die("Milestone ID not provided");
    }

    $milestoneId = $_GET['milestone_id'];
    $jobId = $_GET['job_id'] ?? null;

    $milestone = Milestone::getById($milestoneId);

    if (!$milestone) {
        die("Milestone not found");
    }

    require_once 'views/freelancer/edit_milestone.php';
}

public function update()
{
    // Ensure the form is submitted with the necessary data
    if (isset($_POST['milestone_id'], $_POST['edit_title'], $_POST['edit_status'], $_POST['edit_due_date'], $_POST['edit_description'])) {

        // Sanitize and get the POST data
        $milestoneId = $_POST['milestone_id'];
        $title = $_POST['edit_title'];
        $status = $_POST['edit_status'];
        $dueDate = $_POST['edit_due_date'];
        $description = $_POST['edit_description'];

        // Handle file upload if there is a new attachment (optional)
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $attachment = $_FILES['attachment'];
            $attachmentName = $attachment['name'];
            $attachmentTemp = $attachment['tmp_name'];
            $attachmentPath = 'public/uploads/milestones/' . $attachmentName;
            move_uploaded_file($attachmentTemp, $attachmentPath);
        } else {
            $attachmentName = null; // No attachment, keep it null or use the existing one
        }

        // Call the model to update the milestone in the database
        $milestoneModel = new Milestone();
        $updated = $milestoneModel->updateMilestone($milestoneId, $title, $status, $dueDate, $description, $attachmentName);

        if ($updated) {
            // Redirect back to job tracking or milestone view
            header('Location: index.php?controller=freelancer&action=viewJobTracking');
            exit;
        } else {
            // Error: Failed to update milestone
            $error = "Failed to update milestone. Please try again.";
        }
    } else {
        // Missing required data
        $error = "Please fill out all fields.";
    }

    // Return to the same page with the error message if necessary
    include 'views/freelancer/jobTracking.php'; // Adjust this path as needed
}


    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['milestone_id'])) {
            $id = $_POST['milestone_id'];
            Milestone::delete($id);
            header("Location: index.php?controller=freelancer&action=viewJobTracking");
            exit;
        }
    }
 public function add() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the posted data
        $jobId = $_POST['job_id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $dueDate = $_POST['due_date'] ?? '';
        $attachment = null;

        // Validate required fields
        if (!$jobId || $title === '' || $description === '' || $dueDate === '') {
            $error = 'All fields are required.';
            $this->redirectToHome($error);
            return;
        }

        // ✅ Milestone limit check: Ensure no more than 3 milestones per job
        $milestone = new Milestone();
      $existingCount = $milestone->countAllMilestones($jobId);

        if ($existingCount >= 3) {
            $error = 'You can only add up to 3 milestones per job.';
            $this->redirectToHome($error);
            return;
        }

        // Handle file upload (optional)
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $uploadDir = 'public/uploads/milestones/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $attachment = time() . '_' . basename($_FILES['attachment']['name']);
            $uploadPath = $uploadDir . $attachment;

          $allowedTypes = [
    // Documents
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

    // Images
    'image/jpeg',
    'image/png',
    'image/gif',

    // Audio
    'audio/mpeg',        // .mp3
    'audio/mp3',         // .mp3 (alternative)
    'audio/wav',         // .wav
    'audio/x-wav',       // .wav

    // Video
    'video/mp4',         // .mp4
    'video/x-msvideo',   // .avi
    'video/quicktime',   // .mov
    'video/x-matroska',  // .mkv
    'video/webm'         // .webm
];


            if (!in_array($_FILES['attachment']['type'], $allowedTypes)) {
                $error = 'Invalid file type.';
                $this->redirectToHome($error);
                return;
            }

            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadPath)) {
                $error = 'File upload failed.';
                $this->redirectToHome($error);
                return;
            }
        }

        // Default status should be 'in_progress'
        $status = 'in_progress';

        // Insert into DB
        $result = $milestone->addMilestone($jobId, $title, $description, $status, $dueDate, $attachment);

        if ($result) {
            $this->redirectToHome();
        } else {
            $error = 'Failed to add milestone.';
            $this->redirectToHome($error);
        }
    } else {
        $this->redirectToHome();
    }
}

  

private function redirectToHome($error = null) {
    if ($error) {
        $_SESSION['error_message'] = $error;
    }
    header('Location: index.php?controller=freelancer&action=viewJobTracking');
    exit();
}




public function proceedToPayment($jobId) {
    // Check how many completed milestones there are for this job
    $milestoneModel = new Milestone();
    $completedMilestones = $milestoneModel->countCompletedMilestones($jobId);

    // If 3 milestones are completed, proceed to payment
    if ($completedMilestones >= 3) {
        // Redirect or process the payment logic
        echo "You can now proceed to payment!";
        // Redirect to payment page or logic to initiate payment
    } else {
        echo "❌ You need to mark at least 3 milestones as completed to proceed to payment.";
        echo "<a href='" . BASE_URL . "/index.php?controller=milestone&action=view&job_id=$jobId'>Go back to milestones</a>";
    }
}

// MilestoneController.php
public function MarkAsCompleted($id = null)
{
    if (!$id && isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    if (!$id) {
        $_SESSION['error_message'] = 'Milestone ID not provided.';
        header("Location: index.php?controller=client&action=myJobs");
        exit();
    }

    $milestone = Milestone::getById($id);

    if ($milestone && $milestone['status'] !== 'completed') {
        Milestone::updateStatus($id, 'completed');
        $_SESSION['success_message'] = 'Milestone marked as completed!';
    } else {
        $_SESSION['error_message'] = 'This milestone is already completed or does not exist.';
    }

   header("Location: index.php?controller=jobtracking&action=jobTracking&job_id=" . $milestone['job_id']);
exit();

}





}
?>
