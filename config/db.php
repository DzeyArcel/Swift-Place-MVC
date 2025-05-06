<?php
// config/db.php

// Prevent multiple class declarations
if (!class_exists('Database')) {
    class Database {
        private static $conn = null;

        public static function getConnection() {
            if (self::$conn === null) {
                self::$conn = new mysqli('localhost', 'root', '', 'swiftplace');
                if (self::$conn->connect_error) {
                    die("Connection failed: " . self::$conn->connect_error);
                }
            }
            return self::$conn;
        }
    }
}
?>


