<?php

require_once __DIR__ . '/Conexion.php';

class Promocion {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    //Obtener promocion por su id
    public function getByIdPromocion($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM promociones WHERE id_promocion = ? LIMIT 1"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    //Obtener todas las promociones se hace uso de la funcion obtener_estado_promocion
    public function getAllPromociones() {
        $sql = "SELECT id_promocion, titulo, descripcion, fecha_inicio, fecha_fin,
                obtener_estado_promocion(fecha_inicio, fecha_fin) AS estado
                FROM promociones
                ORDER BY id_promocion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Obtener solo las promociones disponibles se hace uso de la funcion obtener_estado_promocion
    public function getPromocionesDisponibles() {
        $sql = "SELECT id_promocion, titulo, descripcion, fecha_inicio, fecha_fin,
                obtener_estado_promocion(fecha_inicio, fecha_fin) AS estado
                FROM promociones
                WHERE CURDATE() <= fecha_fin
                ORDER BY
                    CASE
                        WHEN CURDATE() BETWEEN fecha_inicio AND fecha_fin THEN 1
                        WHEN CURDATE() < fecha_inicio THEN 2
                    END,
                    fecha_inicio ASC";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Obtener promociones que estan activas
    public function getPromocionesActivas() {

        $sql = "SELECT COUNT(*) AS total
                FROM promociones
                WHERE CURDATE() BETWEEN fecha_inicio AND fecha_fin";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    //Creacion de una promocion
    public function crearPrommocion($titulo, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "INSERT INTO promociones
                (titulo, descripcion, fecha_inicio, fecha_fin)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute([
            $titulo,
            $descripcion,
            $fecha_inicio,
            $fecha_fin
        ])) {
            return false;
        }
        return (int) $this->db->lastInsertId();
    }

    //Actualizar una promocion
    public function actualizarPromocion($id, $titulo, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "UPDATE promociones
                SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?
                WHERE id_promocion=?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $titulo,
            $descripcion,
            $fecha_inicio,
            $fecha_fin,
            $id
        ]);
    }

    //Borrar una promocion
    public function borrarPromocion($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM promociones WHERE id_promocion=?"
        );
        
        return $stmt->execute([$id]);
    }
}
