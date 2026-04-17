<?php

require_once ROOT_PATH . '/app/models/Conexion.php';

try {
    $conexion = Conexion::conectar();

    $sql = "UPDATE reservas 
            SET estado = 'cancelada'
            WHERE estado = 'pendiente' 
            AND fecha_creacion <= NOW() - INTERVAL 30 MINUTE
            AND (estado_pago IS NULL OR estado_pago = 'CREATED')
            ";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    echo "Reservas pendientes canceladas correctamente.";
} catch (Exception $e) {
    echo "Error al cancelar reservas: " . $e->getMessage();
}