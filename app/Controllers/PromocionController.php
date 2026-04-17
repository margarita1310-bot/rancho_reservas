<?php

require_once ROOT_PATH . '/app/models/Promocion.php';

class PromocionController {

    private $model;
    private $uploadDir;
    private $allowedExtensions = ['jpg', 'jpeg', 'png'];

    public function __construct() {
        $this->model = new Promocion();
        $this->uploadDir = ROOT_PATH . '/public_html/images/promocion/';
    }
        
    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
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
        $promocion = $this->model->getAllPromociones();

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

        if (!$titulo || !$descripcion || !$fecha_inicio || !$fecha_fin) {
            $this->json([
                'status' => 'error',
                'msg' => 'Todos los campos son obligatorios'
            ]);
        }

        $inicio = strtotime(str_replace('/', '-', $fecha_inicio));
        $fin = strtotime(str_replace('/', '-', $fecha_fin));

        if ($fin < $inicio) {
            $this->json([
                'status' => 'error',
                'msg' => 'La fecha de fin no puede ser menor a la fecha de inicio'
            ]);
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $this->json([
                'status' => 'error',
                'msg' => 'Imagen requerida'
            ]);
        }

        $id = $this->model->crearPromocion($titulo, $descripcion, $fecha_inicio, $fecha_fin);
        
        if (!$id) {
            $this->json(['status' => 'error']);
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
            $this->json(['status' => 'error']);
        }
        
        $promocion = $this->model->getByIdPromocion($id);
        
        if (!$promocion) {
            $this->json(['status' => 'error']);
        }

        $promocion['imagen'] = $this->obtenerImagen($id);

        $this->json($promocion);
    }

    public function actualizar() {

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }

        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        $inicio = strtotime(str_replace('/', '-', $fecha_inicio));
        $fin = strtotime(str_replace('/', '-', $fecha_fin));

        if ($fin < $inicio) {
            $this->json([
                'status' => 'error',
                'msg' => 'La fecha de fin no puede ser menor a la fecha de inicio'
            ]);
        }

        $ok = $this->model->actualizarPromocion(
            $id,
            $_POST['titulo'],
            $_POST['descripcion'],
            $_POST['fecha_inicio'],
            $_POST['fecha_fin']
        );

        if (!$ok) {
            $this->json(['status' => 'error']);
        }

        $this->guardarImagen($id);
        
        $this->json(['status' => 'ok']);
    }

    public function eliminar() {

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json([
                'status' => 'error',
                'msg' => 'ID requerido'
            ]);
        }

        if (!$this->model->borrarPromocion($id)) {
            $this->json(['status' => 'error']);
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
