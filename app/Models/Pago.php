<?php

require_once __DIR__ . '/Conexion.php';

class Pago {
    
    private $db;
    
    public function __construct() {
        $this->db = Conexion::conectar();
    }
    
    //Obtener un pago por su id
    public function getByOrderIdPago($paypal_order_id) {
        $sql = "SELECT * FROM pagos WHERE paypal_order_id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paypal_order_id]);
        
        return $stmt->fetch();
    }
    
    //Creacion de un pago
    public function crearPago($id_reserva, $paypal_order_id, $monto, $moneda, $estado, $respuesta_api) { 
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

    //Transaccion para actualizar el pago
    public function actualizarPago($paypal_order_id, $paypal_transaction_id, $estado, $respuesta_api) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE pagos
                    SET paypal_transaction_id=?, estado=?, respuesta_api=?, fecha_actualizacion=NOW()
                    WHERE paypal_order_id=?";
    
            $stmt = $this->db->prepare($sql);

            $ok = $stmt->execute([
                $paypal_transaction_id,
                $estado,
                $respuesta_api,
                $paypal_order_id
            ]);

            if ($ok) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}