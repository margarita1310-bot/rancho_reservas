<?php
require_once __DIR__ . '/../../app/Controllers/EventoController.php';

$controller = new EventoController();

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'guardar':
        $controller->guardar();
        break;

    case 'obtener':
        $controller->obtener();
        break;

    case 'actualizar':
        $controller->actualizar();
        break;

    case 'eliminar':
        $controller->eliminar();
        break;

    default:
        http_response_code(400);
        echo json_encode(['status' => 'error', 'msg' => 'Acción no válida']);
        break;
}
