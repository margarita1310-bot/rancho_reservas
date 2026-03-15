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

    public function dashboard() {
        $promociones = $this->promocionModel->getAll();
        $eventos = $this->eventoModel->getAll();
        $reservas = $this->reservaModel->getAll();

        $vista = __DIR__ . '/../Views/admin/inicio.php';
        $this->render($vista);
    }

    public function inicio() {
        $vista = __DIR__ . '/../Views/admin/inicio.php';
        $this->render($vista);
    }
    
    public function promocion() {
        $promociones = $this->promocionModel->getAll();

        $vista =  __DIR__ . '/../Views/admin/promocion.php';
        $this->render($vista, [
            'promociones' => $promociones
        ]);
    }
    
    public function evento() {
        $eventos = $this->eventoModel->getAll();

        $vista = __DIR__ . '/../Views/admin/evento.php';
        $this->render($vista, [
            'eventos' => $eventos
        ]);
    }

    public function reserva() {
        $reservas = $this->reservaModel->getAll();

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
