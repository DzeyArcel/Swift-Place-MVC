<?php
require_once __DIR__ . '/../../models/User.php';

class ClientAuthController {
    public function login() {
        session_start();
        $max_attempts = 5;
        $lockout_time = 15 * 60;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email format.'); window.location='/Swift-Place/views/auth/login.php';</script>";
                exit();
            }

            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
                $remaining_time = $_SESSION['lockout_time'] - time();
                if ($remaining_time > 0) {
                    echo "<script>alert('Too many failed attempts. Try again in " . ceil($remaining_time / 60) . " minutes.'); window.location='/Swift-Place/views/auth/login.php';</script>";
                    exit();
                } else {
                    unset($_SESSION['login_attempts']);
                    unset($_SESSION['lockout_time']);
                }
            }

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                unset($_SESSION['login_attempts'], $_SESSION['lockout_time']);

                // Redirect to dashboard using MVC route
                header("Location: /Swift-Place/index.php?controller=client&action=clientDashboard");

                exit();
            } else {
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['lockout_time'] = time() + $lockout_time;
                }
                echo "<script>alert('Invalid email or password.'); window.location='/Swift-Place/views/auth/login.php';</script>";
            }
        } else {
            include __DIR__ . '/../../views/auth/login.php';
        }
    }
}
