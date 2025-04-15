<?php

require_once __DIR__ . '/../controllers/client/ClientController.php';
require_once './controllers/client/ClientDashboardController.php';

$clientController = new ClientController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'signup':
        $clientController->signup();
        break;
    case 'login':
        $clientController->login();
        break;
    case 'dashboard':
        $clientController->dashboard();
        break;
    default:
        echo "Invalid client route.";
        break;
}




$jobController = new JobController();

if ($action === 'postJobForm') {
    $jobController->postJobForm();
} elseif ($action === 'submitJob') {
    $jobController->submitJob();
}
