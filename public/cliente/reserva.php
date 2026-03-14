<?php

require_once __DIR__ . '/../../app/Controllers/ReservaController.php';

$controller = new ReservaController();

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'guardar':
        $controller->guardar();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}