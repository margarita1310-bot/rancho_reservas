<?php

class Conexion {
    
    private static $conexion = null;

    public static function conectar() {
        if (self::$conexion === null) {
            try {
                $host = 'localhost';
                //$puerto = '3006';
                $usuario = 'user_rancho';
                $contraseña = '12345678';
                $base_de_datos = 'rancho_reservas';

                self::$conexion = new PDO(
                    "mysql:host=$host;dbname=$base_de_datos;charset=utf8",
                    $usuario,
                    $contraseña
                );
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}