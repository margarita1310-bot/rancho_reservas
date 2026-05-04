<?php

session_start();

define('ROOT_PATH', dirname(__DIR__, 2));

require_once ROOT_PATH . '/app/config/env.php';

require_once ROOT_PATH . '/app/controllers/LoginController.php';
require_once ROOT_PATH . '/app/controllers/AdminController.php';
require_once ROOT_PATH . '/app/controllers/ProductoController.php';
require_once ROOT_PATH . '/app/controllers/CategoriaProductoController.php';
require_once ROOT_PATH . '/app/controllers/EventoController.php';
require_once ROOT_PATH . '/app/controllers/EventoFinalizadoController.php';
require_once ROOT_PATH . '/app/controllers/PromocionController.php';
require_once ROOT_PATH . '/app/controllers/ReservaController.php';

$loginController = new LoginController();
$adminController = new AdminController();
$productoController = new ProductoController();
$categoriaProductoController = new CategoriaProductoController();
$eventoController = new EventoController();
$eventoFinalizadoController = new EventoFinalizadoController();
$promocionController = new PromocionController();
$reservaController = new ReservaController();

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
        
    case 'perfil':
        $loginController->getPerfil();
        break;

    case 'actualizarPerfil':
        $loginController->actualizarPerfil();
        break;

    case 'logout':
        $loginController->logout();
        break;

    case 'guardarProducto':
        $productoController->guardar();
        break;

    case 'obtenerProducto':
        $productoController->obtener();
        break;

    case 'actualizarProducto':
        $productoController->actualizar();
        break;

    case 'eliminarProducto':
        $productoController->eliminar();
        break;

    case 'guardarCategoriaProducto':
        $categoriaProductoController->guardar();
        break;

    case 'eliminarCategoriaProducto':
        $categoriaProductoController->eliminar();
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

    case 'actualizarMesasEvento':
        $eventoController->actualizarMesas();
        break;

    case 'subirImagenesEvento':
        $eventoFinalizadoController->subirImagenesEvento();
        break;

    case 'eliminarImagenesEvento':
        $eventoFinalizadoController->eliminarImagenesEvento();
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
    
    case 'cancelarReserva':
        $reservaController->cancelar();
        break;

    default:
        if (method_exists($adminController, $action)) {
            $adminController->$action();
        } else {
            $adminController->inicio();
        }
        break;
}
