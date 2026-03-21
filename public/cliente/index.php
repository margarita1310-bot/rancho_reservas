<?php

require_once __DIR__ . '/../../app/config/env.php';
require_once __DIR__ . '/../../app/Controllers/ClienteController.php';
require_once __DIR__ . '/../../app/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Controllers/PagoController.php';
require_once __DIR__ . '/../../app/Controllers/ReservaController.php';

$clienteController = new ClienteController();
$authController = new AuthController();
$pagoController = new PagoController();
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
    
    case 'guardarReserva':
        $reservaController->guardar();
        break;

    default:
        echo "Acción no válida.";
        break;
}
