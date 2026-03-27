<?php

function badgeReserva($estado) {
    switch ($estado) {
        case 'pendiente': return 'bg-warning';
        case 'confirmada': return 'bg-success';
        case 'cancelada': return 'bg-danger';
        default: return 'bg-secondary';
    }   
}

function badgePago($estado) {
    switch ($estado) {
        case 'CREATED': return 'bg-warning';
        case 'COMPLETED': return 'bg-success';
        case 'FAILED': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function textoReserva($estado) {
    switch ($estado) {
        case 'pendiente': return 'Pendiente';
        case 'confirmada': return 'Confirmada';
        case 'cancelada': return 'Cancelada';
        default: return 'Desconocido';
    }
}

function textoPago($estado) {
    switch ($estado) {
        case 'CREATED': return 'Pendiente de pago';
        case 'COMPLETED': return 'Pagado';
        case 'FAILED': return 'Pago fallido';
        default: return 'Sin información';
    }
}