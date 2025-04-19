<?php
date_default_timezone_set('Asia/Manila');

define('BASE_URL', '/Swift-Place'); // Change if your project folder has a different name

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerDir = __DIR__ . '/controllers/';
$className = '';
$controllerFile = '';

// Routing logic
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

    default:
        echo "❌ Unknown controller '$controller'.<br>";
        echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
        exit();
}

// Load controller file
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($className)) {
        $controllerInstance = new $className();

        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
            exit();
        } else {
            echo "❌ Method '$action' not found in controller '$className'.<br>";
            echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
        }
    } else {
        echo "❌ Class '$className' not found in $controllerFile.<br>";
        echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
    }
} else {
    echo "❌ Controller file not found: $controllerFile<br>";
    echo "<a href='" . BASE_URL . "/index.php'>Go to Home</a>";
}
