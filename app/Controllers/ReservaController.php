<?php

require_once __DIR__ . '/../Models/Reserva.php';

class ReservaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Reserva();
    }

    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        $reservas = $this->model->getAll();

        echo json_encode($reservas);
        exit;
    }

    public function guardar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;
        $mesas = $_POST['mesas_reservadas'] ?? 0;
        $personas = $_POST['personas'] ?? 0;
        $total = $_POST['total'] ?? 0;
        $estado = $_POST['estado'] ?? 'pendiente';

        if (!$id_cliente || !$id_evento || !$mesas || !$personas) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'msg' => 'Faltan campos requeridos'
            ]);
            exit;
        }

        $id = $this->model->create(
            $id_cliente,
            $id_evento,
            $mesas,
            $personas,
            $total,
            $estado
        );

        if (!$id) {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
            exit;
        }

        echo json_encode([
            'status' => 'ok',
            'id_reserva' => $id
        ]);
        exit;
    }

    public function obtener()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            return;
        }

        $reserva = $this->model->getById($id);

        if (!$reserva) {
            http_response_code(404);
            return;
        }

        echo json_encode($reserva);
        exit;
    }

    public function actualizar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            return;
        }

        $ok = $this->model->update(
            $id,
            $_POST['mesas_reservadas'],
            $_POST['personas'],
            $_POST['total'],
            $_POST['estado']
        );

        if ($ok) {
            echo json_encode(['status' => 'ok']);
            exit;
        }

        http_response_code(500);
        echo json_encode(['status' => 'error']);
        exit;
    }

    public function eliminar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'msg' => 'ID no proporcionado'
            ]);
            exit;
        }

        if ($this->model->delete($id)) {
            echo json_encode(['status' => 'ok']);
            exit;
        }

        http_response_code(500);
        echo json_encode(['status' => 'error']);
        exit;
    }
}

if(isset($_GET['action'])) {
    $controller = new ReservaController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
        exit;
    }
}