<?php

require_once __DIR__ . '/../Models/Pago.php';
require_once __DIR__ . '/../Models/Reserva.php';
require_once __DIR__ . '/../libraries/PayPal/PayPalService.php';

class PagoController {

    private $pagoModel;
    private $reservaModel;
    private $paypal;

    public function __construct() {
        $this->pagoModel = new Pago();
        $this->reservaModel = new Reserva();
        $this->paypal = new PayPalService();

        header('Content-Type: application/json; charset=utf-8');
    }

    private function json($data, $code=200) {
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    public function crearOrden() {

        $id_reserva = $_POST['id_reserva'] ?? null;

        if (!$id_reserva) {
            $this->json(["status" => "error", "msg" => "Reserva no válida"], 400);
        }

        $reserva = $this->reservaModel->getById($id_reserva);

        if (!$reserva) {
            $this->json(["status" => "error", "msg" => "Reserva no encontrada"], 404);
        }

        $monto = $reserva['total'];

        $orden = $this->paypal->createOrder($monto);

        if (!isset($orden['id'])) {
            $this->json(["status" => "error", "msg" => "Error creando orden PayPal"], 500);
        }

        $this->pagoModel->create(
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

        $resultado = $this->paypal->captureOrder($paypal_order_id);

        if (isset($resultado['status']) && $resultado['status'] === "COMPLETED") {

            $paypal_transaction_id = 
            $resultado['purchase_units'][0]['payments']['captures'][0]['id'];

            $this->pagoModel->update(
                $paypal_order_id,
                $paypal_transaction_id,
                "COMPLETED",
                json_encode($resultado)
            );

            $this->json([
                "status" => "ok",
                "paypal_transaction_id" => $paypal_transaction_id
            ]);

        } else {

            $this->json([
                "status" => "error",
                "respuesta" => $resultado
            ], 500);
        }
    }
}

if (isset($_GET["action"])) {
    $controller = new PagoController();
    $action = $_GET["action"];

    if(method_exists($controller,$action)){
        $controller->$action();
    }
}
