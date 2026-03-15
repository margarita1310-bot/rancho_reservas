<?php

require_once __DIR__ . '/../Models/Promocion.php';

class PromocionController {

    private $model;
    private $uploadDir;
    private $allowedExtensions = ['jpg', 'png'];

    public function __construct() {
        $this->model = new Promocion();
        $this->uploadDir = __DIR__ . '/../../public/images/promocion/';
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
        $this->model->actualizarPromocionesVencidas();
        $promocion = $this->model->getAll();

        foreach ($promocion as &$p) {
            $p['imagen'] = $this->obtenerImagen($p['id_promocion']);
        }

        $this->json($promocion);
    }

    public function guardar() {

        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if (!$titulo || !$fecha_inicio || !$fecha_fin) {
            $this->json(['status' => 'error', 'msg' => 'Faltan campos'], 400);
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['status' => 'error', 'msg' => 'Imagen requerida'], 400);
        }

        $id = $this->model->create($titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado);
        
        if (!$id) {
            $this->json(['status' => 'error'], 500);
        }

        $this->guardarImagen($id);
        
        $this->json([
            'status' => 'ok',
            'id_promocion' => $id
        ]);
    }

    public function obtener() {

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }
        
        $promocion = $this->model->getById($id);
        
        if (!$promocion) {
            $this->json(['status' => 'error'], 404);
        }

        $promocion['imagen'] = $this->obtenerImagen($id);

        $this->json($promocion);
    }

    public function actualizar() {

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }

        $ok = $this->model->update(
            $id,
            $_POST['titulo'],
            $_POST['descripcion'],
            $_POST['fecha_inicio'],
            $_POST['fecha_fin'],
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

    private function guardarImagen($id) 
    {
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
    $controller = new PromocionController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    }
}
