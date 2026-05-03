<?php

require_once __DIR__ . '/Conexion.php';

class EventoFinalizado {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getAllEventosFinalizados() {
        $sql = "SELECT
                    e.id_evento,
                    e.nombre,
                    e.descripcion,
                    obtener_estado_evento(e.fecha, e.hora, e.hora_fin) AS estado
                FROM eventos e
                WHERE obtener_estado_evento(e.fecha, e.hora, e.hora_fin) IN ('finalizado')
                GROUP BY e.id_evento
                ORDER BY id_evento DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getImagenById($id) {
        $stmt = $this->db->prepare(
            "SELECT nombre_imagen FROM evento_imagenes WHERE id = ?"
        );
    
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function guardarImagenEvento($id_evento, $nombre) {
        $sql = "INSERT INTO evento_imagenes
                (id_evento, nombre_imagen)
                VALUES (?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_evento, $nombre]);
    }

    public function getImagenesEvento($id_evento) {
        $stmt = $this->db->prepare(
            "SELECT id, nombre_imagen FROM evento_imagenes WHERE id_evento = ?"
        );
        
        $stmt->execute([$id_evento]);

        return $stmt->fetchAll();
    }
    
    public function borrarImagen($id) {
        $sql = "DELETE FROM evento_imagenes WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}