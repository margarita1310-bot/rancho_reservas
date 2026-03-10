<?php

require_once __DIR__ . '/Conexion.php';

class Reserva {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAll() {
        $stmt = $this->db->query(
            "SELECT 
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

            ORDER BY r.id_reserva DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_cliente, $id_evento, $mesas_reservadas, $personas, $total, $estado) {

        $sql = "INSERT INTO reservas 
                (id_cliente, id_evento, mesas_reservadas, personas, total, estado, fecha_reserva)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$id_cliente, $id_evento, $mesas_reservadas, $personas, $total, $estado])) {
            return (int)$this->db->lastInsertId();
        }

        return false;
    }

    public function getById($id) {

        $stmt = $this->db->prepare(
            "SELECT 
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

            WHERE r.id_reserva = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $mesas_reservadas, $personas, $total, $estado) {

        $sql = "UPDATE reservas 
                SET mesas_reservadas = ?, personas = ?, total = ?, estado = ?
                WHERE id_reserva = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$mesas_reservadas, $personas, $total, $estado, $id]);
    }

    public function delete($id) {

        $stmt = $this->db->prepare(
            "DELETE FROM reservas WHERE id_reserva = ?"
        );

        return $stmt->execute([$id]);
    }
}