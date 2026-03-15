<?php

require_once __DIR__ . '/../Models/Evento.php';

class EventoController {

    private $model;
    private $uploadDir;
    private $allowedExtensions = ['jpg', 'png'];

    public function __construct() {
        $this->model = new Evento();
        $this->uploadDir = __DIR__ . '/../../public/images/evento/';
        header('Content-Type: application/json; charset=utf-8');
    }

    private function json($data, $code = 200) {
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
        $this->model->actualizarEventosPasados();
        $evento = $this->model->getAll();
        
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
        $estado = $_POST['estado'] ?? '';

        if (!$nombre || !$fecha || !$hora || !$hora_fin || !$estado) {
            $this->json(['status' => 'error', 'msg' => 'Faltan campos'], 400);
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['status' => 'error', 'msg' => 'Imagen requerida'], 400);
        }

        $id = $this->model->create($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado);
        
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
        
        $evento = $this->model->getById($id);

        if (!$evento) {
            $this->json(['status' => 'error'], 404);
        }

        $evento['imagen'] = $this->obtenerImagen($id);

        $this->json($evento);
    }

    public function actualizar() {
        
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }

        $ok = $this->model->update(
            $id,
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['fecha'],
            $_POST['hora'],
            $_POST['hora_fin'],
            $_POST['mesas_disponibles'],
            $_POST['precio_mesa'],
            $_POST['estado']
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

        if (!$this->model->delete($id)) {
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

if (isset($_GET['action'])) {
    $controller = new EventoController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    }
}
