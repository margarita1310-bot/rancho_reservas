<?php

require_once __DIR__ . '/Conexion.php';

class Pago {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function create($id_reserva, $paypal_order_id, $monto, $moneda, $estado, $respuesta_api) {
        
        $sql = "INSERT INTO pagos
                (id_reserva, paypal_order_id, monto, moneda, estado, respuesta_api, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $id_reserva,
            $paypal_order_id,
            $monto,
            $moneda,
            $estado,
            $respuesta_api
        ]);
    }

    public function update($paypal_order_id, $paypal_transaction_id, $estado, $respuesta_api) {

        $sql = "UPDATE pagos
                SET paypal_transaction_id=?, estado=?, respuesta_api=?, fecha_actualizacion=NOW()
                WHERE paypal_order_id=?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $paypal_transaction_id,
            $estado,
            $respuesta_api,
            $paypal_order_id
        ]);
    }
}