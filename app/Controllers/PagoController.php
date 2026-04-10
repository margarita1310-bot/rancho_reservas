<?php

require_once ROOT_PATH . '/app/models/Pago.php';
require_once ROOT_PATH . '/app/models/Reserva.php';
require_once ROOT_PATH . '/app/models/Evento.php';
require_once ROOT_PATH . '/app/libraries/PayPal/PayPalService.php';

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
        
    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function crearOrden() {

        $id_reserva = $_POST['id_reserva'] ?? null;

        if (!$id_reserva) {
            $this->json([
                'status' => 'error',
                'msg' => 'Reserva no válida'
            ]);
        }

        $reserva = $this->reservaModel->getByIdReserva($id_reserva);

        if (!$reserva) {
            $this->json([
                'status' => 'error',
                'msg' => 'Reserva no encontrada'
            ]);
        }

        if ($reserva['estado'] === 'confirmada') {
            $this->json([
                'status' => 'error',
                'msg' => 'La reserva ya fue pagada'
            ]);
        }

        $evento = $this->eventoModel->getByIdEvento($reserva['id_evento']);

        if ($evento['mesas_disponibles'] <= 0) {
            $this->json([
                'status' => 'error',
                'msg' => 'Ya no hay mesas disponibles'
            ]);
        }

        $monto = $reserva['total'];

        $orden = $this->paypal->createOrder($monto);

        if (!isset($orden['id'])) {
            $this->json([
                'status' => 'error',
                'msg' => 'Error creando orden PayPal'
            ]);
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
            'status' => 'ok',
            'orderID' => $orden['id']
        ]);        
    }

    public function capturar() {
        
        $paypal_order_id = $_POST['orderID'] ?? null;

        if (!$paypal_order_id) {
            $this->json([
                'status' => 'error',
                'msg' => 'orderID requerido'
            ]);
        }

        $pago = $this->pagoModel->getByOrderIdPago($paypal_order_id);

        if (!$pago) {
            $this->json([
                'status' => 'error',
                'msg' => 'Pago no encontrado'
            ]);
        }

        if ($pago['estado'] === "COMPLETED") {
            $this->json([
                'status' => 'error',
                'msg' => 'Pago ya procesado'
            ]);
        }

        $resultado = $this->paypal->captureOrder($paypal_order_id);

        if (!isset($resultado['status']) || $resultado['status'] !== "COMPLETED") {
            $this->json([
                'status' => 'error',
                'respuesta' => $resultado
            ]);
        }
        
        $paypal_transaction_id = 
        $resultado['purchase_units'][0]['payments']['captures'][0]['id'];

        $this->pagoModel->actualizarPago(
            $paypal_order_id,
            $paypal_transaction_id,
            "COMPLETED",
            json_encode($resultado)
        );

        $this->json([
            'status' => 'ok',
            'paypal_transaction_id' => $paypal_transaction_id
        ]);
    }
}

