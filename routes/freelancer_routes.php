<?php
// routes/freelancer.php
require_once 'controllers/freelancer/FreelancerAuthController.php';

$auth = new FreelancerAuthController();

if ($_SERVER['REQUEST_URI'] === '/freelancer/signup' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $auth->showSignupForm();
} elseif ($_SERVER['REQUEST_URI'] === '/freelancer/signup' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->register();
}
