<?php

require_once __DIR__ . '/Conexion.php';

class Cliente {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function buscarPorEmail($email) {

        $stmt = $this->db->prepare(
            "SELECT * FROM clientes WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function create($nombre, $email) {

        $stmt = $this->db->prepare(
            "INSERT INTO clientes (nombre, email, created_at)
             VALUES (?, ?, NOW())"
        );

        $stmt->execute([$nombre, $email]);

        return $this->db->lastInsertId();
    }

    public function actualizarDatos($id, $nombre, $telefono) {

        $stmt = $this->db->prepare(
            "UPDATE clientes
             SET nombre = ?, telefono = ?
             WHERE id_cliente = ?"
        );

        return $stmt->execute([$nombre, $telefono, $id]);
    }

    public function getReservas($id) {

        $sql = "SELECT
                    r.*,
                    e.nombre AS evento,
                    e.fecha,
                    e.hora, e.hora_fin,
                    p.monto,
                    p.moneda,
                    p.estado AS estado_pago
                FROM reservas r
                JOIN eventos e ON r.id_evento = e.id_evento
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                WHERE r.id_cliente = ?
                ORDER BY e.fecha ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }
}