<?php

require_once ROOT_PATH . '/app/models/Reserva.php';

class ReservaController {

    private $model;

    public function __construct() {
        $this->model = new Reserva();
    }

    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function index() {
        $reserva = $this->model->getAllReservas();
        $this->json($reserva);
    }

    public function guardar() {
        $id_cliente = $_SESSION['cliente'] ?? null;
        $id_evento = $_POST['id_evento'] ?? null;
        $mesas_reservadas = (int) ($_POST['mesas_reservadas'] ?? 0);
        $personas = (int) ($_POST['personas'] ?? 0);
        $total = (float) ($_POST['total'] ?? 0);

        if (!isset($_SESSION['cliente'])) {
            $this->json([
                'status' => 'error',
                'msg' => 'No autenticado'
            ]);
        }

        if (!$id_evento) {
            $this->json([
                'status' => 'error',
                'msg' => 'Evento inválido'
            ]);
        }

        if (!is_numeric($mesas_reservadas) || !is_numeric($personas) || !is_numeric($total)) {
            $this->json([
                'status' => 'error',
                'msg' => 'Campos numéricos inválidos'
            ]);
        }

        if ($mesas_reservadas <= 0 || $personas <= 0 || $total <= 0) {
            $this->json([
                'status' => 'error',
                'msg' => 'Los valores deben ser mayores a cero'
            ]);
        }

        if (!$mesas_reservadas || !$personas || !$total) {
            $this->json([
                'status' => 'error',
                'msg' => 'Todos los campos son obligatorios'
            ]);
        }

        $id = $this->model->crearReserva(
            $id_cliente,
            $id_evento,
            $mesas_reservadas,
            $personas,
            $total
        );

        if (!$id) {
            $this->json(['status' => 'error']);
        }

        $this->json([
            'status' => 'ok',
            'id_reserva' => $id
        ]);
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
