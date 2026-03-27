<?php

require_once __DIR__ . '/Conexion.php';

class Evento {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    //Obtener evento por su id
    public function getByIdEvento($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM eventos WHERE id_evento = ? LIMIT 1"
        );
    
        $stmt->execute([$id]);
    
        return $stmt->fetch();
    }

    //Obtener todos los eventos se hace uso de la funcion obtener_estado_evento
    public function getAllEventos() {
        $sql = "SELECT
                    e.id_evento,
                    e.nombre,
                    e.descripcion,
                    e.fecha,
                    e.hora,
                    e.hora_fin,
                    e.mesas_disponibles,
                    e.precio_mesa,
                    COUNT(r.id_reserva) AS tiene_reservas,
                    obtener_estado_evento(e.fecha, e.hora, e.hora_fin) AS estado
                FROM eventos e
                LEFT JOIN reservas r ON e.id_evento = r.id_evento
                GROUP BY e.id_evento
                ORDER BY id_evento DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Obtener eventos que esten disponibles se hace uso de la funcion obtener_estado_evento
    public function getEventosDisponibles() {
        $sql = "SELECT
                    e.id_evento,
                    e.nombre,
                    e.descripcion,
                    e.fecha,
                    e.hora,
                    e.hora_fin,
                    e.mesas_disponibles,
                    e.precio_mesa,
                    COUNT(r.id_reserva) AS tiene_reservas,
                    obtener_estado_evento(e.fecha, e.hora, e.hora_fin) AS estado
                FROM eventos e
                LEFT JOIN reservas r ON e.id_evento = r.id_evento
                WHERE NOW() < TIMESTAMP(e.fecha, e.hora)
                    OR NOW() BETWEEN TIMESTAMP (e.fecha, e.hora) AND
                        (CASE
                            WHEN e.hora_fin < e.hora
                            THEN DATE_ADD(TIMESTAMP(e.fecha, e.hora_fin), INTERVAL 1 DAY)
                            ELSE TIMESTAMP (e.fecha, e.hora_fin)
                        END)
                GROUP BY e.id_evento
                ORDER BY e.fecha ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Obtener eventos para el panel de inicio
    public function getEventosInicio() {
        $sql = "SELECT nombre, fecha, hora
                FROM eventos
                WHERE NOW() < TIMESTAMP(fecha, hora)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Obtener los eventos activos
    public function getEventosActivos() {
        $sql = "SELECT COUNT(*) AS total
                FROM eventos
                WHERE NOW() BETWEEN TIMESTAMP(fecha, hora)
                AND (
                    CASE
                        WHEN hora_fin < hora
                        THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                        ELSE TIMESTAMP(fecha, hora_fin)
                    END
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    //Obtener eventos proximos
    public function getEventosProximos() {
        $sql = "SELECT COUNT(*) AS total
                FROM eventos
                WHERE NOW() < TIMESTAMP(fecha, hora)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    //Obtener la cantidad de mesas disponibles de cada evento
    public function getMesasDisponiblesEventos() {
        $sql = "SELECT nombre, mesas_disponibles
                FROM eventos
                WHERE NOW() < (
                    CASE
                        WHEN hora_fin < hora
                        THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                        ELSE TIMESTAMP(fecha, hora_fin)
                    END
                )
                ORDER BY mesas_disponibles ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Creacion de un evento
    public function crearEvento($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa) {
        $sql = "INSERT INTO eventos
                (nombre, descripcion, fecha, hora, hora_fin, mesas_disponibles, precio_mesa)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute([
            $nombre,
            $descripcion,
            $fecha,
            $hora,
            $hora_fin,
            $mesas_disponibles,
            $precio_mesa
        ])) {
            return false;
        }
        return (int) $this->db->lastInsertId();
    }

    //Actualizar un evento
    public function actualizarEvento($id, $nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa) {
        $sql = "UPDATE eventos
                SET nombre=?, descripcion=?, fecha=?, hora=?, hora_fin=?, mesas_disponibles=?, precio_mesa=?
                WHERE id_evento=?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nombre,
            $descripcion,
            $fecha,
            $hora,
            $hora_fin,
            $mesas_disponibles,
            $precio_mesa,
            $id
        ]);
    }

    //Borrar un evento
    public function borrarEvento($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM eventos WHERE id_evento=?"
        );

        return $stmt->execute([$id]);
    }

    //Verificar si un evento tiene reservas
    public function tieneReservas($id_evento) {
        $sql = "SELECT COUNT(*) as total FROM reservas WHERE id_evento = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_evento]);

        $result = $stmt->fetch();

        return $result['total'] > 0;
    }
}
