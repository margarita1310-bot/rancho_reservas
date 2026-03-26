<?php

require_once __DIR__ . '/../Models/Promocion.php';
require_once __DIR__ . '/../Models/Evento.php';
require_once __DIR__ . '/../Models/Reserva.php';

class AdminController {

    private $promocionModel;
    private $eventoModel;
    private $reservaModel;

    public function __construct() {
        $this->promocionModel = new Promocion();
        $this->eventoModel = new Evento();
        $this->reservaModel = new Reserva();
    }

    private function render($vista, $data = []) {
        extract($data);

        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function inicio() {
        $reservasHoy = $this->reservaModel->getReservasHoy();
        $eventosActivos = $this->eventoModel->getEventosActivos();
        $promocionesActivas = $this->promocionModel->getPromocionesActivas();
        $eventosProximos = $this->eventoModel->getEventosProximos();

        $mesasEventos = $this->eventoModel->getMesasDisponiblesEventos();

        $eventos = $this->eventoModel->getEventosInicio();
        $reservas = $this->reservaModel->getReservasInicio();

        $vista = __DIR__ . '/../Views/admin/inicio.php';
        $this->render($vista, [
            'reservasHoy' => $reservasHoy,
            'eventosActivos' => $eventosActivos,
            'promocionesActivas' => $promocionesActivas,
            'eventosProximos' => $eventosProximos,
            'mesasEventos' => $mesasEventos,
            'eventos' => $eventos,
            'reservas' => $reservas
        ]);
    }
    
    public function promocion() {
        $promociones = $this->promocionModel->getAllPromociones();

        $vista =  __DIR__ . '/../Views/admin/promocion.php';
        $this->render($vista, [
            'promociones' => $promociones
        ]);
    }
    
    public function evento() {
        $eventos = $this->eventoModel->getAllEventos();

        $vista = __DIR__ . '/../Views/admin/evento.php';
        $this->render($vista, [
            'eventos' => $eventos
        ]);
    }

    public function reserva() {
        $reservas = $this->reservaModel->getAllReservas();

        $vista = __DIR__ . '/../Views/admin/reserva.php';
        $this->render($vista, [
            'reservas' => $reservas
        ]);
    }

    public function logout() {
        session_unset();
        session_destroy();
        
        header("Location: index.php?action=login");
        exit;
    }
}
