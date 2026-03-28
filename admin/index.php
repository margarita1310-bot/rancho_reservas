<?php

session_start();

define('ROOT_PATH', dirname(__DIR__, 1));

require_once ROOT_PATH . '/app/config/env.php';

require_once ROOT_PATH . '/app/controllers/LoginController.php';
require_once ROOT_PATH . '/app/controllers/AdminController.php';
require_once ROOT_PATH . '/app/controllers/PromocionController.php';
require_once ROOT_PATH . '/app/controllers/EventoController.php';

$loginController = new LoginController();
$adminController = new AdminController();
$promocionController = new PromocionController();
$eventoController = new EventoController();

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['admin']) && !in_array($action, ['login', 'autenticar'])) {
    $action = 'login';
}

switch ($action) {
    
    case 'inicio':
        $adminController->inicio();
        break;

    case 'login':
        $loginController->login();
        break;

    case 'autenticar':
        $loginController->autenticar();
        break;
        
    case 'logout':
        $adminController->logout();
        break;

    case 'guardarPromocion':
        $promocionController->guardar();
        break;

    case 'obtenerPromocion':
        $promocionController->obtener();
        break;

    case 'actualizarPromocion':
        $promocionController->actualizar();
        break;

    case 'eliminarPromocion':
        $promocionController->eliminar();
        break;

    case 'guardarEvento':
        $eventoController->guardar();
        break;

    case 'obtenerEvento':
        $eventoController->obtener();
        break;

    case 'actualizarEvento':
        $eventoController->actualizar();
        break;

    case 'eliminarEvento':
        $eventoController->eliminar();
        break;

    case 'cancelarEvento':
        $eventoController->cancelarEvento();
        break;

    default:
        if (method_exists($adminController, $action)) {
            $adminController->$action();
        } else {
            $adminController->inicio();
        }
        break;
}
