<?php

require_once __DIR__ . '/../Models/Pago.php';
require_once __DIR__ . '/../Models/Reserva.php';
require_once __DIR__ . '/../Models/Evento.php';
require_once __DIR__ . '/../libraries/PayPal/PayPalService.php';

class PagoController {

    private $pagoModel;
    private $reservaModel;
    private $eventoModel;
    private $paypal;

    public function __construct() {
        $this->pagoModel = new Pago();
        $this->reservaModel = new Reserva();
        $this->eventoModel = new Evento();
        $this->paypal = new PayPalService();
    }
        
    private function json($data, $code=200) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    public function crearOrden() {

        $id_reserva = $_POST['id_reserva'] ?? null;

        if (!$id_reserva) {
            $this->json(["status" => "error", "msg" => "Reserva no válida"], 400);
        }

        $reserva = $this->reservaModel->getByIdReserva($id_reserva);

        if (!$reserva) {
            $this->json(["status" => "error", "msg" => "Reserva no encontrada"], 404);
        }

        if ($reserva['estado'] === 'confirmada') {
            $this->json(["status" => "error", "msg" => "La reserva ya fue pagada"], 400);
        }

        $evento = $this->eventoModel->getByIdEvento($reserva['id_evento']);

        if ($evento['mesas_disponibles'] <= 0) {
            $this->json(["status" => "error", "msg" => "Ya no hay mesas disponibles"], 400);
        }

        $monto = $reserva['total'];

        $orden = $this->paypal->createOrder($monto);

        if (!isset($orden['id'])) {
            $this->json(["status" => "error", "msg" => "Error creando orden PayPal"], 500);
        }

        $this->pagoModel->crearPago(
            $id_reserva,
            $orden['id'],
            $monto,
            'MXN',
            'CREATED',
            json_encode($orden)
        );

        $this->json([
            "status" => "ok",
            "orderID" => $orden['id']
        ]);        
    }

    public function capturar() {
        
        $paypal_order_id = $_POST['orderID'] ?? null;
        $id_reserva = $_POST['id_reserva'] ?? null;

        if (!$paypal_order_id) {
            $this->json(["status" => "error", "msg" => "orderID requerido"], 400);
        }

        $pago = $this->pagoModel->getByOrderIdPago($paypal_order_id);

        if (!$pago) {
            $this->json(["status" => "error", "msg" => "Pago no encontrado"], 404);
        }

        if ($pago['estado'] === "COMPLETED") {
            $this->json(["status" => "ok", "msg" => "Pago ya procesado"], 200);
        }

        $resultado = $this->paypal->captureOrder($paypal_order_id);

        if (!isset($resultado['status']) || $resultado['status'] !== "COMPLETED") {
            $this->json(["status" => "error", "respuesta" => $resultado], 500);
        }
        
        $paypal_transaction_id = 
        $resultado['purchase_units'][0]['payments']['captures'][0]['id'];

        $this->pagoModel->actualizarPago(
            $paypal_order_id,
            $paypal_transaction_id,
            "COMPLETED",
            json_encode($resultado)
        );

        $reserva = $this->reservaModel->getByIdReserva($id_reserva);

        if ($reserva && $reserva['estado'] !== 'confirmada') {
            $this->reservaModel->actualizarEstado($id_reserva, "confirmada");
            $this->eventoModel->restarMesas($reserva['id_evento'], 1);
        }
        
        $this->json([
            "status" => "ok",
            "paypal_transaction_id" => $paypal_transaction_id
        ]);
    }
}

