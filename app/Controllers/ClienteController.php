<?php

require_once ROOT_PATH . '/app/models/Promocion.php';
require_once ROOT_PATH . '/app/models/Evento.php';
require_once ROOT_PATH . '/app/models/Cliente.php';

class ClienteController {

    private $promocionModel;
    private $eventoModel;
    private $clienteModel;
    private $uploadDirEvento;
    private $uploadDirPromocion;

    public function __construct() {
        $this->promocionModel = new Promocion();
        $this->eventoModel = new Evento();
        $this->clienteModel = new Cliente();

        $this->uploadDirEvento = ROOT_PATH . '/public_html/images/evento/';
        $this->uploadDirPromocion = ROOT_PATH . '/public_html/images/promocion/';
    }

    private function asignarImagen(&$items, $dir, $idField) {
        foreach ($items as &$item) {
            $item['imagen'] = null;

            foreach (['jpg', 'png'] as $ext) {
                $ruta = $dir . $item[$idField] . '.' . $ext;

                if(is_file($ruta)) {
                    $item['imagen'] = $item[$idField] . '.' . $ext;
                    break;
                }
            }
        }
    }

    public function index() {
        $eventos = $this->eventoModel->getEventosDisponibles();
        $this->asignarImagen($eventos, $this->uploadDirEvento, 'id_evento');
        
        $promociones = $this->promocionModel->getPromocionesDisponibles();
        $this->asignarImagen($promociones, $this->uploadDirPromocion, 'id_promocion');

        require_once ROOT_PATH . '/app/views/cliente/dashboard.php';
    }

    public function obtenerReservas() {
        if (!isset($_SESSION['cliente_id'])) {
            return [];
        }

        $id_cliente = $_SESSION['cliente_id'];
        $reservas = $this->clienteModel->getReservasCliente($id_cliente);

        foreach ($reservas as &$r) {
            $r['puede_pagar'] = (in_array($r['estado_pago'], ['CREATED', 'FAILED']) || is_null($r['estado_pago']))
            && $r['estado_reserva'] === 'pendiente';
            $r['puede_cancelar'] = $r['estado_reserva'] === 'pendiente';
        }

        return $reservas;
    }
}