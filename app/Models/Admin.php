<?php

require_once __DIR__ . '/Conexion.php';

class Admin {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public static function getByEmailAdmin($email) {

        $stmt = $this->db->prepare(
            "SELECT * FROM administrador WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }
    
    public static function verificarAdmin($email, $password) {

        $admin = $this->db->getByEmailAdmin($email);

        if (!$admin) {
            return false;
        }

        if ($admin['password'] !== $password) {
            return false;
        }

        return $admin;
    }
}
