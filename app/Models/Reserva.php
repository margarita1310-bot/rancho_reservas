<?php

require_once __DIR__ . '/Conexion.php';

class Reserva {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    //Obtener reserva por su id
    public function getByIdReserva($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM reservas WHERE id_reserva = ? LIMIT 1"
        );
    
        $stmt->execute([$id]);
    
        return $stmt->fetch();
    }

    //Obtener todas las reservas
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

    //Obtener las ultimas 5 reservas realizadas
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

    //Obtener las reservas del dia actual
    public function getReservasHoy() {
        $sql = "SELECT COUNT(*) AS total
                FROM reservas
                WHERE DATE(fecha_reserva) = CURDATE()";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    //Obtener las reservas que no se han pagado o pendientes
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

    //Transaccion para crear una reserva
    public function crearReserva($id_cliente, $id_evento, $mesas_reservadas, $personas, $total, $estado) {
        try {
            $this->db->beginTransaction();

            //Verificar mesas disponibles
            $stmt = $this->db->prepare(
                "SELECT mesas_disponibles
                FROM eventos
                WHERE id_evento = ?
                FOR UPDATE"
            );

            $stmt->execute([$id_evento]);
            $evento = $stmt->fetch();

            if (!$evento || $evento['mesas_disponibles'] < $mesas_reservadas) {
                $this->db->rollBack();
                return false;
            }

            //Insertar reserva
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

            //Confirmar
            $this->db->commit();

            return (int) $this->db->lastInsertId();
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    //Actualizar el estado de la reserva
    public function actualizarEstadoReserva($id_reserva, $estado) {
        $sql = "UPDATE reservas
                SET estado = ?
                WHERE id_reserva = ?";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$estado, $id_reserva]);
    }
}
