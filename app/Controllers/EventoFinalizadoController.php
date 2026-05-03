<?php

require_once ROOT_PATH . '/app/models/EventoFinalizado.php';

class EventoFinalizadoController {
    private $model;

    public function __construct() {
        $this->model = new EventoFinalizado();
    }

    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function subirImagenesEvento() {
        $id = $_POST['id'] ?? null;

        if (!$id || empty($_FILES['imagenes'])) {
            $this->json([
                'status' => 'error',
                'msg' => 'Datos inválidos'
            ]);
        }

        $ruta = ROOT_PATH . "/public/images/eventoFinalizado/$id/";

        if (!is_dir($ruta)) {
            mkdir($ruta, 0777, true);
        }

        $total = count($_FILES['imagenes']['name']);

        if ($total > 4) {
            $this->json([
                'status' => 'error',
                'msg' => 'Máximo 4 imágenes'
            ]);
        }

        for ($i = 0; $i < $total; $i++) {
            $nombre = time() . '_' . $_FILES['imagenes']['name'][$i];
            $tmp = $_FILES['imagenes']['tmp_name'][$i];

            if (move_uploaded_file($tmp, $ruta . $nombre)) {
                $this->model->guardarImagenEvento($id, $nombre);
            }
        }

        $this->json(['status' => 'ok']);
    }

    public function eliminarImagenesEvento() {
        $id = $_POST['id'] ?? null;
        $evento = $_POST['evento'] ?? null;
        
        if (!$id || !$evento) {
            $this->json(['status' => 'error']);
            return;
        }
    
        $imagen = $this->model->getImagenById($id);
        
        if (!$imagen) {
            $this->json(['status' => 'error']);
            return;
        }
        
        $ruta = ROOT_PATH . "/public/images/eventoFinalizado/$evento/" . $imagen['nombre_imagen'];
        
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        
        $this->model->borrarImagen($id);
        $this->json(['status' => 'ok']);
    }

}