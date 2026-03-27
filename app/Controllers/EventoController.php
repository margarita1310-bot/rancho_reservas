<?php

require_once __DIR__ . '/../Models/Evento.php';

class EventoController {

    private $model;
    private $uploadDir;
    private $allowedExtensions = ['jpg', 'png'];

    public function __construct() {
        $this->model = new Evento();
        $this->uploadDir = __DIR__ . '/../../public/images/evento/';
    }
        
    private function json($data, $code = 200) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    private function obtenerImagen($id) {
        foreach ($this->allowedExtensions as $ext) {
            if (is_file($this->uploadDir . $id . '.' . $ext)) {
                return $id . '.' . $ext;
            }
        }
        return null;
    }

    public function index() {
        $evento = $this->model->getAllEventos();
        
        foreach ($evento as &$e) {
            $e['imagen'] = $this->obtenerImagen($e['id_evento']);
        }
        
        $this->json($evento);
    }

    public function guardar() {
        
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $hora_fin = $_POST['hora_fin'] ?? '';
        $mesas_disponibles = $_POST['mesas_disponibles'] ?? 0;
        $precio_mesa = $_POST['precio_mesa'] ?? 0;

        if (!$nombre || !$fecha || !$hora || !$hora_fin) {
            $this->json(['status' => 'error', 'msg' => 'Faltan campos'], 400);
        }

        $inicio = strtotime($hora);
        $fin = strtotime($hora_fin);

        if ($fin <= $inicio) {
            $fin = strtotime($hora_fin) + 86400;

            if ($fin <= $inicio) {
                $this->json(['status' => 'error', 'msg' => 'La hora de fin no puede ser menor a la hora de inicio'], 400);
            }
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['status' => 'error', 'msg' => 'Imagen requerida'], 400);
        }

        $id = $this->model->crearEvento($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa);
        
        if (!$id) {
            $this->json(['status' => 'error'], 500);
        }

        $this->guardarImagen($id);
        
        $this->json([
            'status' => 'ok',
            'id_evento' => $id
        ]);
    }

    public function obtener() {
        
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }
        
        $evento = $this->model->getByIdEvento($id);

        if (!$evento) {
            $this->json(['status' => 'error'], 404);
        }

        $evento['tiene_reservas'] = $this->model->tieneReservas($id);

        $evento['imagen'] = $this->obtenerImagen($id);

        $this->json($evento);
    }

    public function actualizar() {
        
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }

        if ($this->model->tieneReservas($id)) {
            $this->json(['status' => 'error', 'msg' => 'No se puede modificar, el evento ya tiene reservas'], 400);
            return;
        }

        $hora = $_POST['hora'] ?? '';
        $hora_fin = $_POST['hora_fin'] ?? '';

        $inicio = strtotime($hora);
        $fin = strtotime($hora_fin);

        if ($fin <= $inicio) {
            $fin = strtotime($hora_fin) + 86400;

            if ($fin <= $inicio) {
                $this->json(['status' => 'error', 'msg' => 'La hora de fin no puede ser menor a la hora de inicio'], 400);
            }
        }

        $ok = $this->model->actualizarEvento(
            $id,
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['fecha'],
            $_POST['hora'],
            $_POST['hora_fin'],
            $_POST['mesas_disponibles'],
            $_POST['precio_mesa']
        );

        if (!$ok) {
            $this->json(['status' => 'error'], 500);
        }

        $this->guardarImagen($id);
        
        $this->json(['status' => 'ok']);
    }

    public function eliminar() {
        
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error', 'msg' => 'ID requerido'], 400);
        }

        if ($this->model->tieneReservas($id)) {
            $this->json(['status' => 'error', 'msg' => 'No se puede borrar, el evento ya tiene reservas'], 400);
            return;
        }

        if (!$this->model->borrarEvento($id)) {
            $this->json(['status' => 'error'], 500);
        }

        foreach ($this->allowedExtensions as $ext) {
            @unlink($this->uploadDir . $id . '.' . $ext);
        }
        
        $this->json(['status' => 'ok']);
    }
    
    private function guardarImagen($id) {

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            return;
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $this->allowedExtensions)) {
            return;
        }

        foreach ($this->allowedExtensions as $e) {
            @unlink($this->uploadDir . $id . '.' . $e);
        }

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            $this->uploadDir . $id . '.' . $ext
        );
    }
}
