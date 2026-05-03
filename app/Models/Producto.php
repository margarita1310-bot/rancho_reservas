<?php

require_once __DIR__ . '/Conexion.php';

class Producto {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getByIdProducto($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM productos WHERE id_producto = ? LIMIT 1"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function getAllProductos() {
        $sql = "SELECT
                    p.id_producto,
                    p.nombre AS producto,
                    p.descripcion,
                    p.precio,
                    c.nombre AS categoria,
                    c.id_categoria
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id_categoria    
                ORDER BY id_producto DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function crearProducto($nombre, $descripcion, $precio, $id_categoria) {
        $sql = "INSERT INTO productos
                (nombre, descripcion, precio, id_categoria)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute([
            $nombre,
            $descripcion,
            $precio,
            $id_categoria
        ])) {
            return false;
        }
        return (int) $this->db->lastInsertId();
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio, $id_categoria) {
        $sql = "UPDATE productos
                SET nombre=?, descripcion=?, precio=?, id_categoria=?
                WHERE id_producto=?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nombre,
            $descripcion,
            $precio,
            $id_categoria,
            $id
        ]);
    }

    public function borrarProducto($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM productos WHERE id_producto=?"
        );
        
        return $stmt->execute([$id]);
    }
}
