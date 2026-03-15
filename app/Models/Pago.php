<?php

require_once __DIR__ . '/Conexion.php';

class Pago {
    
    private $db;
    
    public function __construct() {
        $this->db = Conexion::conectar();
    }
        
    public function getByOrderId($paypal_order_id) {
        
        $sql = "SELECT * FROM pagos WHERE paypal_order_id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paypal_order_id]);
        
        return $stmt->fetch();
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