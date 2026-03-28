<?php

require_once ROOT_PATH . '/app/models/Reserva.php';

class ReservaController {

    private $model;

    public function __construct() {
        $this->model = new Reserva();
    }

    private function json($data, $code = 200) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    public function index() {
        $reserva = $this->model->getAllReservas();
        $this->json($reserva);
    }

    public function guardar() {
        
        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;
        $mesas_reservadas = $_POST['mesas_reservadas'] ?? 0;
        $personas = $_POST['personas'] ?? 0;
        $total = $_POST['total'] ?? 0;

        if (!$id_cliente || !$id_evento || $mesas_reservadas <= 0 || $personas <= 0) {
            $this->json(['status' => 'error', 'msg' => 'Faltan campos requeridos'], 400);
        }

        $id = $this->model->crearReserva(
            $id_cliente,
            $id_evento,
            $mesas_reservadas,
            $personas,
            $total
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

        $reserva = $this->model->getByIdReserva($id);

        if (!$reserva) {
            $this->json(['status' => 'error', 'msg' => 'Reserva no encontrada'], 404);
        }

        $this->json($reserva);
    }

    public function cancelar() {

        $id_reserva = $_POST['id_reserva'] ?? null;

        if (!$id_reserva) {
            $this->json([
                'status' => 'error',
                'msg' => 'Reserva inválida'
            ]);
        }

        $reserva = $this->model->getByIdReserva($id_reserva);

        if (!$reserva){
            $this->json([
                'status' => 'error',
                'msg' => 'No encontrada'
            ]);
        }

        $ok = $this->model->cancelarReserva($id_reserva);

        if (!$ok) {
            $this->json([
                'status' => 'error',
                'msg' => 'Error al cancelar'
            ]);
        }

        $this->json([
            'status' => 'ok'
        ]);
    }

    public function comprobante() {

        $id_reserva = $_GET['id_reserva'] ?? null;

        if (!$id_reserva) {
            $this->json([
                'status' => 'error',
                'msg' => 'Reserva inválida'
            ]);
        }

        $reserva = $this->model->getDetallesReserva($id_reserva);

        if (!$reserva){
            $this->json([
                'status' => 'error',
                'msg' => 'No encontrada'
            ]);
        }

        require_once ROOT_PATH . '/app/views/cliente/comprobante.php';
    }
}
