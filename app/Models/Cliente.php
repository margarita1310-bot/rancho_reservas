<?php

require_once __DIR__ . '/Conexion.php';

class Cliente {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    //Obtener cliente por su correo
    public function getByEmailCliente($email) {
        $stmt = $this->db->prepare(
            "SELECT * FROM clientes WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    //Transacción al crear un cliente
    public function crearCliente($nombre, $email, $telefono) {
        try {
            $this->db->beginTransaction();
            
            $stmt = $this->db->prepare(
                "INSERT INTO clientes (nombre, email, telefono, created_at)
                VALUES (?, ?, ?, NOW())"
            );
    
            $stmt->execute([$nombre, $email, $telefono]);

            $id = $this->db->lastInsertId();
            $this->db->commit();

            return $id;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function actualizarCliente($id, $nombre, $telefono) {
        $stmt = $this->db->prepare(
            "UPDATE clientes SET nombre = ?, telefono = ? WHERE id_cliente = ?"
        );

        return $stmt->execute([$nombre, $telefono, $id]);
    }

    //Obtener reservas del cliente
    public function getReservasCliente($id) {
        $sql = "SELECT
                    r.id_reserva,
                    e.nombre AS evento,
                    e.fecha AS fecha_evento,
                    e.hora,
                    e.hora_fin,
                    r.mesas_reservadas,
                    r.personas,
                    r.total,
                    r.estado AS estado_reserva,
                    p.id_pago,
                    p.monto,
                    p.moneda,
                    p.estado AS estado_pago,
                    p.fecha_creacion AS fecha_pago
                FROM reservas r
                JOIN eventos e ON r.id_evento = e.id_evento
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                    AND p.id_pago = (SELECT MAX(id_pago)
                                    FROM pagos
                                    WHERE id_reserva = r.id_reserva)
                WHERE r.id_cliente = ?
                ORDER BY e.fecha DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }
}