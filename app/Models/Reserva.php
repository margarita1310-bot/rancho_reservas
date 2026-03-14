<?php

require_once __DIR__ . '/Conexion.php';

class Reserva {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAll() {

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
                ORDER BY r.id_reserva DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function getById($id) {
    
        $sql = "SELECT 
                    r.*,
                    c.nombre AS cliente,
                    c.email,
                    c.telefono,
                    e.nombre AS evento,
                    e.fecha,
                    e.hora,
                    e.hora_fin,
                    p.paypal_order_id,
                    p.paypal_transaction_id,
                    p.monto,
                    p.moneda,
                    p.estado AS estado_pago
                FROM reservas r
                JOIN clientes c ON r.id_cliente = c.id_cliente
                JOIN eventos e ON r.id_evento = e.id_evento
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                WHERE r.id_reserva = ?
                LIMIT 1";
    
        $stmt = $this->db->prepare($sql);
    
        $stmt->execute([$id]);
    
        return $stmt->fetch();
    }

    public function create($id_cliente, $id_evento, $mesas_reservadas, $personas, $total, $estado) {

        $sql = "INSERT INTO reservas
                (id_cliente, id_evento, mesas_reservadas, personas, total, estado, fecha_reserva)
                VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute([
            $id_cliente,
            $id_evento,
            $mesas_reservadas,
            $personas,
            $total
        ])) {
            return false;
        }
        return (int) $this->db->lastInsertId();
    }
}
