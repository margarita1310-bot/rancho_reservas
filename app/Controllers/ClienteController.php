<?php

require_once __DIR__ . '/../Models/Evento.php';
require_once __DIR__ . '/../Models/Promocion.php';

class ClienteController {

    private $eventoModel;
    private $promocionModel;
    private $uploadDirEvento;
    private $uploadDirPromocion;

    public function __construct() {
        $this->eventoModel = new Evento();
        $this->promocionModel = new Promocion();

        $this->uploadDirEvento = __DIR__ . '/../../public/images/evento/';
        $this->uploadDirPromocion = __DIR__ . '/../../public/images/promocion/';
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
        $eventos = $this->eventoModel->getAll();
        $this->asignarImagen($eventos, $this->uploadDirEvento, 'id_evento');
        
        $promociones = $this->promocionModel->getAll();
        $this->asignarImagen($promociones, $this->uploadDirPromocion, 'id_promocion');

        require_once __DIR__ . '/../Views/cliente/dashboard.php';
    }
}