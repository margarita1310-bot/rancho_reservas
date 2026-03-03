<?php

class AdminController
{
    public function dashboard()
    {
        require_once __DIR__ . '/../Models/Promocion.php';
        require_once __DIR__ . '/../Models/Evento.php';
        require_once __DIR__ . '/../Models/Reserva.php';

        $promocion = (new Promocion())->getAll();
        $evento = (new Evento())->getAll();
        //$reserva = (new Reserva())->getAll();

        $vista = __DIR__ . '/../Views/admin/inicio.php';
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function inicio()
    {
        $vista = __DIR__ . '/../Views/admin/inicio.php';
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }
    
    public function promocion()
    {
        require_once __DIR__ . '/../Models/Promocion.php';
        $promocion = (new Promocion())->getAll();

        $vista =  __DIR__ . '/../Views/admin/promocion.php';
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }
    
    public function evento()
    {
        require_once __DIR__ . '/../Models/Evento.php';
        $evento = (new Evento())->getAll();

        $vista = __DIR__ . '/../Views/admin/evento.php';
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function reserva()
    {
        require_once __DIR__ . '/../Models/reserva.php';
        //$reserva = (new Reserva())->getAll();

        $vista = __DIR__ . '/../Views/admin/reserva.php';
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
