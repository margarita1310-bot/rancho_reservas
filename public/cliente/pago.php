<?php

require_once __DIR__ . '/../../app/Controllers/PagoController.php';

$controller = new PagoController();

$action = $_GET['action'] ?? '';

switch ($action) {
    
    case 'crearOrden':
        $controller->crearOrden();
        break;

    case 'capturar':
        $controller->crearOrden();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}