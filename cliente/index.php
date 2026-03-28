<?php

define('ROOT_PATH', dirname(__DIR__, 1));

require_once ROOT_PATH . '/app/config/env.php';

require_once ROOT_PATH . '/app/controllers/ClienteController.php';
require_once ROOT_PATH . '/app/controllers/AuthController.php';
require_once ROOT_PATH . '/app/controllers/PagoController.php';
require_once ROOT_PATH . '/app/controllers/EventoController.php';
require_once ROOT_PATH . '/app/controllers/ReservaController.php';

$clienteController = new ClienteController();
$authController = new AuthController();
$pagoController = new PagoController();
$eventoController = new EventoController();
$reservaController = new ReservaController();

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index':
        $clienteController->index();
        break;
    
    case 'google':
        $authController->googleLogin();
        break;

    case 'enviarCodigo':
        $authController->enviarCodigo();
        break;

    case 'validarCodigo':
        $authController->validarCodigo();
        break;

    case 'guardarDatosCliente':
        $authController->guardarDatosCliente();
        break;
    
    case 'crearOrden':
        $pagoController->crearOrden();
        break;

    case 'capturarPago':
        $pagoController->capturar();
        break;
    
    case 'verificarMesas':
        $eventoController->verificarMesas();
        break;

    case 'guardarReserva':
        $reservaController->guardar();
        break;

    case 'cancelarReserva':
        $reservaController->cancelar();
        break;

    case 'comprobante':
        $reservaController->comprobante();
        break;

    default:
        echo "Acción no válida.";
        break;
}
