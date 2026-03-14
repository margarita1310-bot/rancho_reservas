<?php

session_start();

require_once __DIR__ . '/../../app/Controllers/LoginController.php';
require_once __DIR__ . '/../../app/Controllers/AdminController.php';

$LoginController = new LoginController();
$Admincontroller = new AdminController();

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['admin']) && !in_array($action, ['login', 'autenticar'])) {
    $action = 'login';
}

switch ($action) {
    
    case 'login':
        $LoginController->login();
        break;

    case 'autenticar':
        $LoginController->autenticar();
        break;
        
    case 'logout':
        $AdminController->logout();
        break;

    default:
        if (method_exists($Admincontroller, $action)) {
            $Admincontroller->$action();
        } else {
            $Admincontroller->dashboard();
        }
        break;
}
