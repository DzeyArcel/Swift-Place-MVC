<?php
class FreelancerProfile {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getFreelancerBasicInfo($freelancer_id) {
        $stmt = $this->conn->prepare("SELECT * FROM freelancers WHERE id = ?");
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getProfile($freelancer_id) {
        $stmt = $this->conn->prepare("SELECT phone, address, skills, experience, bio, profile_picture FROM freelancer_profile WHERE freelancer_id = ?");
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function profileExists($freelancer_id) {
        $stmt = $this->conn->prepare("SELECT freelancer_id FROM freelancer_profile WHERE freelancer_id = ?");
        $stmt->bind_param("i", $freelancer_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function updateProfile($freelancer_id, $phone, $address, $skills, $experience, $bio, $profilePicture = null) {
        if ($profilePicture) {
            $stmt = $this->conn->prepare("UPDATE freelancer_profile SET phone = ?, address = ?, skills = ?, experience = ?, bio = ?, profile_picture = ? WHERE freelancer_id = ?");
            $stmt->bind_param("ssssssi", $phone, $address, $skills, $experience, $bio, $profilePicture, $freelancer_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE freelancer_profile SET phone = ?, address = ?, skills = ?, experience = ?, bio = ? WHERE freelancer_id = ?");
            $stmt->bind_param("ssssssi", $phone, $address, $skills, $experience, $bio, $freelancer_id);
        }
        return $stmt->execute();
    }
    
    
    public function createProfile($freelancer_id, $phone, $address, $skills, $experience, $bio, $profilePicture = null) {
        $stmt = $this->conn->prepare("INSERT INTO freelancer_profile (freelancer_id, phone, address, skills, experience, bio, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $freelancer_id, $phone, $address, $skills, $experience, $bio, $profilePicture);
        return $stmt->execute();
    }
    

    public function deleteProfile($freelancer_id) {
        $stmt = $this->conn->prepare("DELETE FROM freelancer_profile WHERE freelancer_id = ?");
        $stmt->bind_param("i", $freelancer_id);
        return $stmt->execute();
    }
}
