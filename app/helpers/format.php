<?php

function formatearHora($hora) {
    return date("g:i A", strtotime($hora));
}

function formatearFecha($fecha) {

    $meses = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo',
        4 => 'abril', 5 => 'mayo', 6 => 'junio',
        7 => 'julio', 8 => 'agosto', 9 => 'septiembre',
        10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    ];

    $timestamp = strtotime($fecha);

    $dia = date('d', $timestamp);
    $mes = $meses[(int)date('m', $timestamp)];
    $anio = date('Y', $timestamp);

    return "$dia de $mes de $anio";
}

function formatearFechaCompleta($fecha) {
    if (!$fecha) return '';

    try {
        return (new DateTime($fecha))->format('d/m/y');
    } catch (Exception $e) {
        return '';
    }
}