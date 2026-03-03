<?php

require_once __DIR__ . '/Conexion.php';

class Evento {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAll() {
        $stmt = $this->db->query(
            "SELECT * FROM eventos ORDER BY id_evento DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado) {
        $sql = "INSERT INTO eventos (nombre, descripcion, fecha, hora, hora_fin, mesas_disponibles, precio_mesa, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado])) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM eventos WHERE id_evento = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado) {
        $sql = "UPDATE eventos SET nombre=?, descripcion=?, fecha=?, hora=?, hora_fin=?, mesas_disponibles=?, precio_mesa=?, estado=?
                WHERE id_evento=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM eventos WHERE id_evento=?"
        );
        return $stmt->execute([$id]);
    }
}
