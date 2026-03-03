<?php

require_once __DIR__ . '/Conexion.php';

class Promocion {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAll() {
        $stmt = $this->db->query(
            "SELECT * FROM promociones ORDER BY id_promocion DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado) {
        $sql = "INSERT INTO promociones (titulo, descripcion, fecha_inicio, fecha_fin, estado)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado])) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM promociones WHERE id_promocion = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado) {
        $sql = "UPDATE promociones SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?, estado=?
                WHERE id_promocion=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM promociones WHERE id_promocion=?"
        );
        return $stmt->execute([$id]);
    }
}
