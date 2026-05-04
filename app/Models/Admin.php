<?php

require_once __DIR__ . '/Conexion.php';

class Admin {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function getByEmailAdmin($email) {
        $stmt = $this->db->prepare(
            "SELECT * FROM administrador WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM administrador WHERE id_admin = ? LIMIT 1"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function actualizarPerfil($id, $email, $password) {
        $stmt = $this->db->prepare(
            "UPDATE administrador SET email = ?, password = ? WHERE id_admin = ?"
        );

        return $stmt->execute([$email, $password, $id]);
    }
    
    public function verificarAdmin($email, $password) {
        $admin = $this->getByEmailAdmin($email);

        if (!$admin) {
            return false;
        }

        if ($admin['password'] !== $password) {
            return false;
        }

        return $admin;
    }
}
