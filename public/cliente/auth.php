<?php

require_once __DIR__ . '/../../app/Controllers/AuthController.php';

$action = $_GET['action'] ?? '';

$controller = new AuthController();

switch ($action) {

    case 'google':
        $controller->googleLogin();
        break;

    case 'enviarCodigo':
        $controller->enviarCodigo();
        break;

    case 'validarCodigo':
        $controller->validarCodigo();
        break;

    case 'guardarDatosCliente':
        $controller->guardarDatosCliente();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}