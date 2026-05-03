<?php

require_once ROOT_PATH . '/app/models/Producto.php';

class ProductoController {

    private $model;

    public function __construct() {
        $this->model = new Producto();
    }
        
    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function index() {
        $producto = $this->model->getAllProductos();
        $this->json($producto);
    }

    public function guardar() {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = (float) ($_POST['precio'] ?? '');
        $id_categoria = $_POST['id_categoria'] ?? '';

        if (!$nombre || !$descripcion || !$precio || !$id_categoria) {
            $this->json([
                'status' => 'error',
                'msg' => 'Todos los campos son obligatorios'
            ]);
        }

        $id = $this->model->crearProducto($nombre, $descripcion, $precio, $id_categoria);
        
        if (!$id) {
            $this->json(['status' => 'error']);
        }

        $this->json([
            'status' => 'ok',
            'id_producto' => $id
        ]);
    }

    public function obtener() {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error']);
        }
        
        $producto = $this->model->getByIdProducto($id);
        
        if (!$producto) {
            $this->json(['status' => 'error']);
        }

        $this->json($producto);
    }

    public function actualizar() {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json(['status' => 'error'], 400);
        }

        $ok = $this->model->actualizarProducto(
            $id,
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $_POST['id_categoria']
        );

        if (!$ok) {
            $this->json(['status' => 'error']);
        }

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

        if (!$this->model->borrarProducto($id)) {
            $this->json(['status' => 'error']);
        }
        
        $this->json(['status' => 'ok']);
    }
}
