<?php

require_once ROOT_PATH . '/app/models/CategoriaProducto.php';

class CategoriaProductoController {

    private $model;

    public function __construct() {
        $this->model = new CategoriaProducto();
    }
        
    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function index() {
        $categoria = $this->model->getAllCategoriasProductos();
        $this->json($categoria);
    }

    public function guardar() {
        $nombre = trim($_POST['nombre'] ?? '');

        if (!$nombre) {
            $this->json([
                'status' => 'error',
                'msg' => 'Los campos son obligatorios'
            ]);
        }

        $id = $this->model->crearCategoriaProducto($nombre);
        
        if (!$id) {
            $this->json(['status' => 'error']);
        }

        $this->json([
            'status' => 'ok',
            'id_categoria' => $id
        ]);
    }

    public function eliminar() {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->json([
                'status' => 'error',
                'msg' => 'ID requerido'
            ]);
        }

        if (!$this->model->borrarCategoriaProducto($id)) {
            $this->json(['status' => 'error']);
        }
        
        $this->json(['status' => 'ok']);
    }
}
