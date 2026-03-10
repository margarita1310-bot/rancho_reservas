<?php

require_once __DIR__ . '/../../app/Controllers/ClienteController.php';
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller = new ClienteController();
        $controller->index();
        break;

    default:
        echo "Acción no válida.";
        break;
}
