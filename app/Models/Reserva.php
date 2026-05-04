<?php

require_once __DIR__ . '/Conexion.php';

class Reserva {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getByIdReserva($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM reservas WHERE id_reserva = ? LIMIT 1"
        );
    
        $stmt->execute([$id]);
    
        return $stmt->fetch();
    }

    public function getAllReservas() {
        $sql = "SELECT 
                    r.id_reserva,
                    c.nombre AS cliente,
                    c.email,
                    c.telefono,
                    e.nombre AS evento,
                    e.fecha,
                    e.hora,
                    r.mesas_reservadas,
                    r.personas,
                    r.total,
                    r.estado,
                    r.fecha_reserva,
                    p.estado AS estado_pago
                FROM reservas r
                JOIN clientes c ON r.id_cliente = c.id_cliente
                JOIN eventos e ON r.id_evento = e.id_evento
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                AND p.id_pago = (
                    SELECT MAX(id_pago)
                    FROM pagos
                    WHERE id_reserva = r.id_reserva
                )
                ORDER BY r.id_reserva DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function getDetallesReserva($id) {
        $sql = "SELECT 
                    r.id_reserva,
                    c.nombre AS cliente,
                    c.email,
                    e.nombre AS evento,
                    e.fecha,
                    r.personas,
                    r.total,
                    p.fecha_actualizacion AS fecha_pago,
                    p.paypal_transaction_id,
                    p.estado AS estado_pago
                FROM reservas r
                JOIN clientes c ON r.id_cliente = c.id_cliente
                JOIN eventos e ON r.id_evento = e.id_evento
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                ORDER BY r.id_reserva DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetch();
    }

    public function getReservasInicio() {
        $sql = "SELECT
                    c.nombre AS cliente,
                    r.fecha_reserva,
                    r.personas
                FROM reservas r
                JOIN clientes c ON r.id_cliente = c.id_cliente
                ORDER BY r.fecha_reserva DESC
                LIMIT 5";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getReservasHoy() {
        $sql = "SELECT COUNT(*) AS total
                FROM reservas
                WHERE DATE(fecha_reserva) = CURDATE()";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getReservasSinPago() {
        $sql = "SELECT *
                FROM reservas r
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM pagos p
                    WHERE p.id_reserva = r.id_reserva
                    AND p.estado = 'COMPLETED'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crearReserva($id_cliente, $id_evento, $mesas_reservadas, $personas, $total) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                "SELECT mesas_disponibles
                FROM eventos
                WHERE id_evento = ?
                FOR UPDATE"
            );

            $stmt->execute([$id_evento]);
            $evento = $stmt->fetch();

            if (!$evento || (int)$evento['mesas_disponibles'] < (int)$mesas_reservadas) {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare(
                "INSERT INTO reservas
                (id_cliente, id_evento, mesas_reservadas, personas, total, estado, fecha_reserva)
                VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())"
            );
            
            $stmt->execute([
                $id_cliente,
                $id_evento,
                $mesas_reservadas,
                $personas,
                $total
            ]);

            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $id;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function cancelarReserva($id_reserva) {
        $stmt = $this->db->prepare(
            "UPDATE reservas
            SET estado = 'cancelada'
            WHERE id_reserva = ? AND estado = 'pendiente'"
        );

        return $stmt->execute([$id_reserva]);
    }
}
