<?php

require_once __DIR__ . '/Conexion.php';

class Cliente {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function buscarPorEmail($email) {

        $stmt = $this->db->prepare(
            "SELECT * FROM clientes WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function create($email, $nombre = null) {

        $stmt = $this->db->prepare(
            "INSERT INTO clientes (nombre, email, created_at)
             VALUES (?, ?, NOW())"
        );

        $stmt->execute([$email, $nombre]);

        return $this->db->lastInsertId();
    }

    public function actualizarDatos($id, $nombre, $telefono) {

        $stmt = $this->db->prepare(
            "UPDATE clientes
             SET nombre = ?, telefono = ?
             WHERE id_cliente = ?"
        );

        return $stmt->execute([$nombre, $telefono, $id]);
    }
}