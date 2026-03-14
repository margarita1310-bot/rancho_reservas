<?php

require_once __DIR__ . '/../Models/Reserva.php';

class ReservaController {

    private $model;

    public function __construct() {
        $this->model = new Reserva();
        header('Content-Type: application/json; charset=utf-8');
    }

    private function json($data, $code = 200) {
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    public function index() {
        $reserva = $this->model->getAll();
        $this->json($reserva);
    }

    public function guardar() {
        
        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;
        $mesas_reservadas = $_POST['mesas_reservadas'] ?? 0;
        $personas = $_POST['personas'] ?? 0;
        $total = $_POST['total'] ?? 0;
        $estado = $_POST['estado'] ?? 'pendiente';

        if (!$id_cliente || !$id_evento || !$mesas_reservadas || !$personas) {
            $this->json(['status' => 'error', 'msg' => 'Faltan campos requeridos'], 400);
        }

        $id = $this->model->create(
            $id_cliente,
            $id_evento,
            $mesas_reservadas,
            $personas,
            $total,
            $estado
        );

        if (!$id) {
            $this->json(['status' => 'error'], 500);
        }

        $this->json([
            'status' => 'ok',
            'id_reserva' => $id
        ]);
    }

    public function obtener() {
        
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error', 'msg' => 'ID requerido'], 400);
        }

        $reserva = $this->model->getById($id);

        if (!$reserva) {
            $this->json(['status' => 'error', 'msg' => 'Reserva no encontrada'], 404);
        }

        $this->json($reserva);
    }
}

if (isset($_GET['action'])) {
    $controller = new ReservaController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    }
}