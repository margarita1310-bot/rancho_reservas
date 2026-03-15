<?php

session_start();

require_once __DIR__ . '/../../app/Controllers/LoginController.php';
require_once __DIR__ . '/../../app/Controllers/AdminController.php';

$logincontroller = new LoginController();
$admincontroller = new AdminController();

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['admin']) && !in_array($action, ['login', 'autenticar'])) {
    $action = 'login';
}

switch ($action) {
    
    case 'login':
        $logincontroller->login();
        break;

    case 'autenticar':
        $logincontroller->autenticar();
        break;
        
    case 'logout':
        $admincontroller->logout();
        break;

    default:
        if (method_exists($admincontroller, $action)) {
            $admincontroller->$action();
        } else {
            $admincontroller->dashboard();
        }
        break;
}
