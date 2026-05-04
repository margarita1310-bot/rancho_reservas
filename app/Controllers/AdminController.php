<?php

require_once ROOT_PATH . '/app/models/Producto.php';
require_once ROOT_PATH . '/app/models/CategoriaProducto.php';
require_once ROOT_PATH . '/app/models/Evento.php';
require_once ROOT_PATH . '/app/models/EventoFinalizado.php';
require_once ROOT_PATH . '/app/models/Promocion.php';
require_once ROOT_PATH . '/app/models/Reserva.php';

class AdminController {

    private $productoModel;
    private $categoriaProductoModel;
    private $eventoModel;
    private $eventoFinalizadoModel;
    private $promocionModel;
    private $reservaModel;

    public function __construct() {
        $this->productoModel = new Producto();
        $this->categoriaProductoModel = new CategoriaProducto();
        $this->eventoModel = new Evento();
        $this->eventoFinalizadoModel = new EventoFinalizado();
        $this->promocionModel = new Promocion();
        $this->reservaModel = new Reserva();
    }

    private function render($vista, $data = []) {
        extract($data);

        require_once ROOT_PATH . '/app/views/admin/dashboard.php';
    }

    public function inicio() {
        $reservasHoy = $this->reservaModel->getReservasHoy();
        $eventosActivos = $this->eventoModel->getEventosActivos();
        $promocionesActivas = $this->promocionModel->getPromocionesActivas();
        $eventosProximos = $this->eventoModel->getEventosProximos();

        $mesasEventos = $this->eventoModel->getMesasDisponiblesEventos();

        $eventos = $this->eventoModel->getEventosInicio();
        $reservas = $this->reservaModel->getReservasInicio();

        $vista = ROOT_PATH . '/app/views/admin/inicio.php';
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
    
    public function producto() {
        $categoriasProductos = $this->categoriaProductoModel->getAllCategoriasProductos();
        $productos = $this->productoModel->getAllProductos();

        $vista = ROOT_PATH . '/app/views/admin/producto.php';
        $this->render($vista, [
            'categoriasProductos' => $categoriasProductos,
            'productos' => $productos
        ]);
    }

    public function categoriaProducto() {
        $categoriasProductos = $this->categoriaProductoModel->getAllCategoriasProductos();

        $vista = ROOT_PATH . '/app/views/admin/categoriaProducto.php';
        $this->render($vista, [
            'categoriasProductos' => $categoriasProductos
        ]);
    }
    
    public function evento() {
        $eventos = $this->eventoModel->getAllEventos();

        $vista = ROOT_PATH . '/app/views/admin/evento.php';
        $this->render($vista, [
            'eventos' => $eventos
        ]);
    }

    public function eventoFinalizado() {
        $eventosFinalizados = $this->eventoFinalizadoModel->getAllEventosFinalizados();

        foreach ($eventosFinalizados as &$ef) {
            $imagenes = $this->eventoFinalizadoModel
            ->getImagenesEvento($ef['id_evento']);
        
            $ef['imagenes'] = [];
            foreach ($imagenes as $img) {
                $ef['imagenes'][] = [
                    'id' => $img['id'],
                    'url' => BASE_URL . "/public/images/eventoFinalizado/{$ef['id_evento']}/" . $img['nombre_imagen'],
                    'nombre' => $img['nombre_imagen']
                ];
            }
        }

        $vista = ROOT_PATH . '/app/views/admin/eventoFinalizado.php';
        $this->render($vista, [
            'eventosFinalizados' => $eventosFinalizados
        ]);
    }

    public function promocion() {
        $promociones = $this->promocionModel->getAllPromociones();

        $vista =  ROOT_PATH . '/app/views/admin/promocion.php';
        $this->render($vista, [
            'promociones' => $promociones
        ]);
    }

    public function reserva() {
        $reservas = $this->reservaModel->getAllReservas();

        $vista = ROOT_PATH . '/app/views/admin/reserva.php';
        $this->render($vista, [
            'reservas' => $reservas
        ]);
    }
}
