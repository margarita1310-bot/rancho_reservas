<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once '../../app/Controllers/ClienteController.php';

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
