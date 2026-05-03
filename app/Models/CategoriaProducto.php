<?php

require_once __DIR__ . '/Conexion.php';

class CategoriaProducto {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }
    
    public function getByIdCategoriaProducto($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM categorias WHERE id_categoria = ? LIMIT 1"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function getAllCategoriasProductos() {
        $sql = "SELECT id_categoria, nombre
                FROM categorias
                ORDER BY id_categoria DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crearCategoriaProducto($nombre) {
        $stmt = $this->db->prepare(
            "INSERT INTO categorias (nombre) VALUES (?)"
        );

        if (!$stmt->execute([
            $nombre
        ])) {
            return false;
        }
        return (int) $this->db->lastInsertId();
    }

    public function borrarCategoriaProducto($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM categorias WHERE id_categoria=?"
        );
        
        return $stmt->execute([$id]);
    }
}
