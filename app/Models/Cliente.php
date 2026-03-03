<?php
require_once __DIR__ . '/Conexion.php';

class Cliente {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre = null, $email) {
        $stmt = $this->db->prepare(
            "INSERT INTO clientes (nombre, email, created_at)
             VALUES (?, ?, NOW())"
        );
        $stmt->execute([$nombre, $email]);

        return $this->db->lastInsertId();
    }

    public function actualizarDatos($id, $nombre, $telefono)
    {
        $sql = "UPDATE clientes SET nombre = ?, telefono = ? WHERE id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $telefono, $id]);
    }
}