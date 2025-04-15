<?php
// models/User.php

require_once __DIR__ . '/../config/db.php'; // ✅ Ensure correct DB path

class User {
    public static function create($first_name, $last_name, $email, $password) {
        $conn = Database::getConnection();

        $password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
            if ($stmt->execute()) {
                return true;
            } else {
                echo "❌ MySQL Execute Error: " . $stmt->error;
            }
        } else {
            echo "❌ MySQL Prepare Error: " . $conn->error;
        }

        return false;
    }

    public static function findByEmail($email) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            echo "❌ MySQL Prepare Error: " . $conn->error;
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getClientById($id) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("SELECT first_name FROM users WHERE id = ?");
        if (!$stmt) {
            echo "❌ MySQL Prepare Error: " . $conn->error;
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
