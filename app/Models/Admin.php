<?php

require_once __DIR__ . '/Conexion.php';

class Admin {

    private static function db() {
        return Conexion::conectar();
    }

    public static function findByEmail($email) {

        $stmt = self::db()->prepare(
            "SELECT * FROM administrador WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }
    
    public static function verificar($email, $password) {

        $admin = self::findByEmail($email);

        if (!$admin) {
            return false;
        }

        if (!password_verify($password, $admin['password'])) {
            return false;
        }

        return $admin;
    }
}
