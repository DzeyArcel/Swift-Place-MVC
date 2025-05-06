<?php
date_default_timezone_set('Asia/Manila');
define('BASE_URL', '/Swift-Place'); // Adjust if your folder name is different

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerDir = __DIR__ . '/controllers/';
$controllerFile = '';
$className = '';

// Basic Routing
switch ($controller) {
    case 'freelancer':
        $controllerFile = $controllerDir . 'freelancer/FreelancerController.php';
        $className = 'FreelancerController';
        break;

    case 'freelancerApplication':
        $controllerFile = $controllerDir . 'freelancer/FreelancerApplicationController.php';
        $className = 'FreelancerApplicationController';
        break;

    case 'client':
        $controllerFile = $controllerDir . 'client/ClientController.php';
        $className = 'ClientController';
        break;

    case 'job':
        $controllerFile = $controllerDir . 'client/JobController.php';
        $className = 'JobController';
        break;

    case 'application':
        $controllerFile = $controllerDir . 'client/ApplicationController.php';
        $className = 'ApplicationController';
        break;

    case 'service':
        $controllerFile = $controllerDir . 'freelancer/ServiceController.php';
        $className = 'ServiceController';
        break;

    case 'auth':
        $controllerFile = $controllerDir . 'AuthController.php';
        $className = 'AuthController';
        break;

    case 'home':
        require_once 'views/home/homepage.php';
        exit();

        case 'jobtracking':  // Correct CamelCase to match URL
            $controllerFile = $controllerDir . 'client/JobTrackingController.php';
            $className = 'JobTrackingController';
            break;
    

    default:
        echo "❌ Unknown controller '$controller'.<br>";
        echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
        exit();
}

// Load Controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($className)) {
        $controllerInstance = new $className();

        if (method_exists($controllerInstance, $action)) {
            // Optional: Log which controller and action are being called
            error_log("Routing to $className->$action()");

            // Execute the action
            $controllerInstance->$action();
        } else {
            echo "❌ Method '$action' not found in controller '$className'.<br>";
            echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
        }
    } else {
        echo "❌ Class '$className' not found in '$controllerFile'.<br>";
        echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
    }
} else {
    echo "❌ Controller file not found: '$controllerFile'.<br>";
    echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
}
