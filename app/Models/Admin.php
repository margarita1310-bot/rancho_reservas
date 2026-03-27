<?php

require_once __DIR__ . '/Conexion.php';

class Admin {

    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    //Obtener administrador por email
    public function getByEmailAdmin($email) {
        $stmt = $this->db->prepare(
            "SELECT * FROM administrador WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }
    
    //Verificar admin
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
