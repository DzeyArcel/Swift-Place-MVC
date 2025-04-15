<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controllers/client/ClientController.php';
require_once '../controllers/client/ClientAuthController.php';

$action = $_GET['action'] ?? '';

$clientController = new ClientController();
$authController = new ClientAuthController();

switch ($action) {
    case 'signupClient':
        $clientController->register();
        break;

    case 'loginClient':
        $authController->login();
        break;

    default:
        echo "❌ Unknown action.";
        break;
}
