<?php

require_once ROOT_PATH . '/app/models/Producto.php';
require_once ROOT_PATH . '/app/models/CategoriaProducto.php';
require_once ROOT_PATH . '/app/models/Evento.php';
require_once ROOT_PATH . '/app/models/EventoFinalizado.php';
require_once ROOT_PATH . '/app/models/Promocion.php';
require_once ROOT_PATH . '/app/models/Cliente.php';

class ClienteController {

    private $productoModel;
    private $categoriaProductoModel;
    private $eventoModel;
    private $eventoFinalizadoModel;
    private $promocionModel;
    private $clienteModel;
    private $uploadDirEvento;
    private $uploadDirPromocion;

    public function __construct() {
        $this->productoModel = new Producto();
        $this->categoriaProductoModel = new CategoriaProducto();
        $this->eventoModel = new Evento();
        $this->eventoFinalizadoModel = new EventoFinalizado();
        $this->promocionModel = new Promocion();
        $this->clienteModel = new Cliente();

        $this->uploadDirEvento = ROOT_PATH . '/public_html/images/evento/';
        $this->uploadDirPromocion = ROOT_PATH . '/public_html/images/promocion/';
    }

    private function asignarImagen(&$items, $dir, $idField) {
        foreach ($items as &$item) {
            $item['imagen'] = null;

            foreach (['jpg', 'jpeg', 'png'] as $ext) {
                $ruta = $dir . $item[$idField] . '.' . $ext;

                if(is_file($ruta)) {
                    $item['imagen'] = $item[$idField] . '.' . $ext;
                    break;
                }
            }
        }
    }

    public function index() {
        $productos = $this->productoModel->getAllProductos();
        $categoriasProductos = $this->categoriaProductoModel->getAllCategoriasProductos();

        $eventos = $this->eventoModel->getEventosDisponibles();
        $this->asignarImagen($eventos, $this->uploadDirEvento, 'id_evento');
        
        $eventosFinalizados = $this->eventoFinalizadoModel->getAllEventosFinalizados();

        foreach ($eventosFinalizados as $index => $ef) {
            $imagenes = $this->eventoFinalizadoModel
            ->getImagenesEvento($ef['id_evento']);
        
            $eventosFinalizados[$index]['imagenes'] = [];
            if (!empty($imagenes)) {
                foreach ($imagenes as $img) {
                    $eventosFinalizados[$index]['imagenes'][] = [
                        'url' => BASE_URL . "/public/images/eventoFinalizado/{$ef['id_evento']}/" . $img['nombre_imagen']
                    ];
                }
            }
        }

        $promociones = $this->promocionModel->getPromocionesDisponibles();
        $this->asignarImagen($promociones, $this->uploadDirPromocion, 'id_promocion');

        require_once ROOT_PATH . '/app/views/cliente/dashboard.php';
    }

    public function obtenerReservas() {
        if (!isset($_SESSION['cliente'])) {
            return [];
        }

        $id_cliente = $_SESSION['cliente'];
        $reservas = $this->clienteModel->getReservasCliente($id_cliente);

        foreach ($reservas as &$r) {
            $r['puede_pagar'] = (in_array($r['estado_pago'], ['CREATED', 'FAILED']) || is_null($r['estado_pago']))
            && $r['estado_reserva'] === 'pendiente';
            $r['puede_cancelar'] = $r['estado_reserva'] === 'pendiente';
        }

        return $reservas;
    }
}