<?php
date_default_timezone_set('Asia/Manila');

// Default controller and action
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controller = strtolower($controller);
$controllerDir = __DIR__ . '/controllers/';
$className = '';
$controllerFile = '';

// Determine controller path and class
switch ($controller) {
    case 'freelancer':
        $controllerFile = $controllerDir . 'freelancer/FreelancerController.php';
        $className = 'FreelancerController';
        break;

    case 'client':
        $controllerFile = $controllerDir . 'client/ClientController.php';
        $className = 'ClientController';

        // Optional alias for cleaner URL
        if ($action === 'dashboard') {
            $action = 'clientDashboard';
        }
        break;

    case 'auth':
        $controllerFile = $controllerDir . 'AuthController.php';
        $className = 'AuthController';
        break;

    case 'job':
        $controllerFile = $controllerDir . 'client/JobController.php';
        $className = 'JobController';
        break;

    default:
        // Fallback for custom or newly added controllers
        $controllerPath = $controllerDir . $controller . '/' . ucfirst($controller) . 'Controller.php';
        $className = ucfirst($controller) . 'Controller';

        if (file_exists($controllerPath)) {
            $controllerFile = $controllerPath;
        } else {
            // fallback if controller subfolder does not exist
            $controllerFile = $controllerDir . ucfirst($controller) . 'Controller.php';
        }
        break;
}

// Execute controller and action
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($className)) {
        $controllerInstance = new $className();

        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
            exit();
        } else {
            echo "❌ Method <strong>'$action'</strong> not found in controller <strong>'$className'</strong>.";
        }
    } else {
        echo "❌ Class <strong>'$className'</strong> not found in file: <code>$controllerFile</code>.";
    }
} else {
    echo "❌ Controller file not found: <code>$controllerFile</code>";
}
