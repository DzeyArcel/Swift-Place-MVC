<?php
class AuthController {
    public function showRoleChoice() {
        include './views/auth/choose_role.php';
    }

    public function chooseRole() {
        if (isset($_POST['user_type'])) {
            $role = $_POST['user_type'];

            // Redirect based on chosen role
            if ($role === 'client') {
                header("Location: /Swift-Place/views/auth/register_client.php");
            } elseif ($role === 'freelancer') {
                header("Location: /Swift-Place/views/auth/register_freelancer.php");
            } else {
                echo "Invalid role selected.";
            }
        } else {
            echo "Please choose a role.";
        }
    }

   

        public function logout() {
            session_start();
            session_destroy();
            header("Location: index.php"); // or login page
            exit();
        }
    
    
}


