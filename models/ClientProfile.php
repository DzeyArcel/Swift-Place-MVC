<?php
require_once __DIR__ . '/../config/db.php';

class ClientProfile {
    private static function getConnection() {
        return Database::getConnection();
    }

    public static function getUserDetails($user_id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getProfile($user_id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT bio, contact, address, profile_pic FROM client_profiles WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function profileExists($user_id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT id FROM client_profiles WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public static function updateProfile($user_id, $bio, $contact, $address, $profile_pic) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("UPDATE client_profiles SET bio=?, contact=?, address=?, profile_pic=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $bio, $contact, $address, $profile_pic, $user_id);
        return $stmt->execute();
    }

    public static function insertProfile($user_id, $bio, $contact, $address, $profile_pic) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO client_profiles (user_id, bio, contact, address, profile_pic) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $bio, $contact, $address, $profile_pic);
        return $stmt->execute();
    }

    public static function deleteProfile($user_id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM client_profiles WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}
