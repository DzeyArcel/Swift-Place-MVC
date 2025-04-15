<?php
// config/db.php

if (!class_exists('Database')) {
    class Database {
        public static function getConnection() {
            $conn = new mysqli('localhost', 'root', '', 'swiftplace');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            return $conn;
        }
    }
}
