<?php

require_once __DIR__ . '/Conexion.php';

class Evento {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAll() {

        $sql = "SELECT id_evento, nombre, descripcion, fecha, hora, hora_fin, mesas_disponibles, precio_mesa,
                (SELECT COUNT(*)
                FROM reservas r
                WHERE r.id_evento = eventos.id_evento) AS tiene_reservas,
                CASE 
                    WHEN NOW() < TIMESTAMP(fecha, hora) THEN 'proximo'
                    WHEN NOW() BETWEEN TIMESTAMP(fecha, hora) AND
                        (CASE
                            WHEN hora_fin < hora
                            THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                            ELSE TIMESTAMP(fecha, hora_fin)
                        END)
                    THEN 'activo'
                    ELSE 'finalizado'
                END AS estado
                FROM eventos
                ORDER BY id_evento DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    public function getById($id) {

        $stmt = $this->db->prepare(
            "SELECT * FROM eventos WHERE id_evento = ? LIMIT 1"
        );
    
        $stmt->execute([$id]);
    
        return $stmt->fetch();
    }

    public function getEventosDisponibles() {

        $sql = "SELECT id_evento, nombre, descripcion, fecha, hora, hora_fin, mesas_disponibles, precio_mesa,
                (SELECT COUNT(*)
                FROM reservas r
                WHERE r.id_evento = eventos.id_evento) AS tiene_reservas,
                CASE
                    WHEN NOW() < TIMESTAMP(fecha, hora) THEN 'proximo'
                    WHEN NOW() BETWEEN TIMESTAMP(fecha, hora) AND
                        (CASE
                            WHEN hora_fin < hora
                            THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                            ELSE TIMESTAMP(fecha, hora_fin)
                        END)
                    THEN 'activo'
                    ELSE 'finalizado'
                END AS estado
                FROM eventos
                WHERE
                    NOW() < TIMESTAMP(fecha, hora)
                    OR NOW() BETWEEN TIMESTAMP (fecha, hora) AND
                        (CASE
                            WHEN hora_fin < hora
                            THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                            ELSE TIMESTAMP (fecha, hora_fin)
                        END)
                    ORDER BY
                        CASE
                            WHEN NOW() BETWEEN TIMESTAMP(fecha, hora) AND
                                (CASE
                                    WHEN hora_fin < hora
                                    THEN DATE_ADD(TIMESTAMP(fecha, hora_fin), INTERVAL 1 DAY)
                                    ELSE TIMESTAMP(fecha, hora_fin)
                                END)
                            THEN 1
                            WHEN NOW()
                            THEN 2
                        END,
                        fecha ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getEventosInicio() {

        $sql = "SELECT nombre, fecha, hora
                FROM eventos
                WHERE NOW() < TIMESTAMP(fecha, hora)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

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

    public function getEventosProximos() {

        $sql = "SELECT COUNT(*) AS total
                FROM eventos
                WHERE NOW() < TIMESTAMP(fecha, hora)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

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

    public function create($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa) {

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


    public function update($id, $nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa) {

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

    public function delete($id) {

        $stmt = $this->db->prepare(
            "DELETE FROM eventos WHERE id_evento=?"
        );

        return $stmt->execute([$id]);
    }

    public function tieneReservas($id_evento) {
        
        $sql = "SELECT COUNT(*) as total FROM reservas WHERE id_evento = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_evento]);

        $result = $stmt->fetch();

        return $result['total'] > 0;
    }

    public function restarMesas($id_evento, $cantidad = 1) {

        $sql = "UPDATE eventos
                SET mesas_disponibles = mesas_disponibles - ?
                WHERE id_evento = ?
                AND mesas_disponibles >= ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cantidad, $id_evento, $cantidad]);

        return $stmt->rowCount() > 0;
    }
}
