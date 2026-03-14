<?php

require_once __DIR__ . '/../../app/config/env.php';
require_once __DIR__ . '/../../app/Controllers/ClienteController.php';

$controller = new ClienteController();

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index':
        $controller->index();
        break;

    default:
        echo "Acción no válida.";
        break;
}
