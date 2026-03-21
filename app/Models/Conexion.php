<?php

require_once __DIR__ . '/../config/env.php';

class Conexion {
    
    private static $conexion = null;

    public static function conectar() {

        if (self::$conexion === null) {

            try {

                $host = $_ENV['DATABASE_HOST'];
                $db = $_ENV['DATABASE_NAME'];
                $user = $_ENV['DATABASE_USER'];
                $pass = $_ENV['DATABASE_PASSWORD'];

                $dns = "mysql:host=$host;dbname=$db;charset=utf8mb4";

                self::$conexion = new PDO($dns, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
                
                self::$conexion->exec("SET time_zone = '-06:00'");
                
            } catch (PDOException $e) {

                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}