<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

require_once '../../app/Controllers/LoginController.php';
require_once '../../app/Controllers/AdminController.php';

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['admin']) && !in_array($action, ['login', 'autenticar'])) {
    $action = 'login';
}

switch ($action) {
    case 'login':
        $controller = new LoginController();
        $controller->login();
        break;

    case 'autenticar':
        $controller = new LoginController();
        $controller->autenticar();
        break;
        
    case 'logout':
        $controller = new AdminController();
        $controller->logout();
        break;

    default:
        $controller = new AdminController();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $controller->dashboard();
        }
        break;
}
