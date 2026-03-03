<?php

require_once __DIR__ . '/../Models/Evento.php';
require_once __DIR__ . '/../Models/Promocion.php';

class ClienteController
{
    private $eventoModel;
    private $promocionModel;
    private $uploadDirEvento;
    private $uploadDirPromocion;

    public function __construct()
    {
        $this->eventoModel = new Evento();
        $this->promocionModel = new Promocion();
        $this->uploadDirEvento = __DIR__ . '/../../public/images/evento/';
        $this->uploadDirPromocion = __DIR__ . '/../../public/images/promocion/';
    }

    public function index()
    {
        $eventos = $this->eventoModel->getAll();

        foreach ($eventos as &$e) {
            $e['imagen'] = null;

            foreach (['jpg', 'png'] as $ext) {
                if (is_file($this->uploadDirEvento . $e['id_evento'] . '.' . $ext)) {
                    $e['imagen'] = $e['id_evento'] . '.' . $ext;
                    break;
                }
            }
        }

        $promociones = $this->promocionModel->getAll();

        foreach ($promociones as &$p) {
            $p['imagen'] = null;

            foreach (['jpg', 'png'] as $ext) {
                if (is_file($this->uploadDirPromocion . $p['id_promocion'] . '.' . $ext)) {
                    $p['imagen'] = $p['id_promocion'] . '.' . $ext;
                    break;
                }
            }
        }

        require_once __DIR__ . '/../Views/cliente/dashboard.php';
    }
}