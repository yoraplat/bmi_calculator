<?php

use Scripts\Controllers\HistoryController;
use Scripts\Controllers\LoginController;
use Scripts\Controllers\PageController;
use Scripts\Controllers\RegisterController;
use Scripts\Services\SessionService;

include('./Scripts/Controllers/PageController.php');
include('./Scripts/Database/DatabaseService.php');
include('./Scripts/Controllers/RegisterController.php');
include('./Scripts/Controllers/LoginController.php');
include('./Scripts/Controllers/HistoryController.php');
include('./Scripts/Services/SessionService.php');

$current_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// The files should be in a different file
$_ENV['servername'] = "localhost";
$_ENV['serveruser'] = "root";
$_ENV['serverpass'] = "Test123!";
$_ENV['dbname'] = "bmi_calculator";
$_ENV['PORT'] = "5000";
$_ENV['HOST'] = "http://localhost:" . $_ENV['PORT'];

// Initiate session service
$session_service = new SessionService();

switch ($current_uri) {
    case '/':
        if ($method === 'GET') {
            if ($session_service->isAuthenticated()) {
                echo PageController::index();
            } else {
                header("Location: " . $_ENV['HOST'] . "/login");
            }
        }
        break;
    case '/history':
        if ($method === 'GET') {
            if ($session_service->isAuthenticated()) {
                echo HistoryController::index();
            } else {
                header("Location: " . $_ENV['HOST'] . "/login");
            }
        }
        break;
    case '/api/calculate':
        if ($method === 'POST') {
            if ($session_service->isAuthenticated()) {
                echo PageController::post();
            } else {
                header("Location: " . $_ENV['HOST'] . "login");
            }
        }
        break;
    case '/register':
        if ($method === 'GET') {
            if (!$session_service->isAuthenticated()) {
                echo RegisterController::index();
            } else {
                header("Location: " . $_ENV['HOST']);
            }
        }
    case '/api/register':
        if ($method === 'POST') {
            if (!$session_service->isAuthenticated()) {
                echo json_encode(RegisterController::post());
            } else {
                header("Location: " . $_ENV['HOST']);
            }
        }
        break;
    case '/login':
        if ($method === 'GET') {
            if (!$session_service->isAuthenticated()) {
                echo LoginController::index();
            } else {
                header("Location: " . $_ENV['HOST']);
            }
        }
        break;
    case '/api/login':
        if ($method === 'POST') {
            if (!$session_service->isAuthenticated()) {
                echo json_encode(LoginController::post());
            } else {
                header("Location: " . $_ENV['HOST']);
            }
        }
        break;
    case '/api/logout':
        $session_service->logout();
        break;

    default:
        echo file_get_contents(require './Scripts/Pages/404.php');
        break;
}
