<?php

require_once __DIR__ . '/../Models/Promocion.php';

class PromocionController
{
    private $model;
    private $uploadDir;

    public function __construct()
    {
        $this->model = new Promocion();
        $this->uploadDir = __DIR__ . '/../../public/images/promocion/';
    }

    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        $promocion = $this->model->getAll();

        foreach ($promocion as &$p) {
            $p['imagen'] = null;
            foreach (['jpg', 'png'] as $ext) {
                if (is_file($this->uploadDir . $p['id_promocion'] . '.' . $ext)) {
                    $p['imagen'] = $p['id_promocion'] . '.' . $ext;
                    break;
                }
            }
        }

        echo json_encode($promocion);
    }

    public function guardar()
    {
        header('Content-Type: application/json; charset=utf-8');
        
        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if (!$titulo || !$fecha_inicio || !$fecha_fin) {
            http_response_code(400);
            echo json_encode(['status' => 'error']);
            exit;
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'msg' => 'Debes seleccionar una imagen para la promoción'
            ]);
            exit;
        }

        $id = $this->model->create($titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado);
        
        if (!$id) {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
            exit;
        }

        $this->guardarImagen($id);
        echo json_encode(['status' => 'ok', 'id_promocion' => $id]);
        exit;
    }

    public function obtener()
    {
        header('Content-Type: application/json; charset=utf-8');
        
        $id = $_POST['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            return;
        }
        
        $promocion = $this->model->getById($id);
        
        if (!$promocion) {
            http_response_code(404);
            return;
        }

        foreach (['jpg', 'png'] as $ext) {
            if (is_file($this->uploadDir . $id . '.' . $ext)) {
                $promocion['imagen'] = $id . '.' . $ext;
                break;
            }
        }

        echo json_encode($promocion);
        exit;
    }

    public function actualizar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            return;
        }

        $ok = $this->model->update(
            $id,
            $_POST['titulo'],
            $_POST['descripcion'],
            $_POST['fecha_inicio'],
            $_POST['fecha_fin'],
            $_POST['estado']
        );

        if ($ok) {
            $this->guardarImagen($id);
            echo json_encode(['status' => 'ok']);
            exit;
        }

        http_response_code(500);
        echo json_encode(['status' => 'error']);
        exit;
}

    public function eliminar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'msg' => 'ID no proporcionado']);
            exit;
        }

        if ($this->model->delete($id)) {
            foreach (['jpg', 'png'] as $ext) {
                @unlink($this->uploadDir . $id . '.' . $ext);
            }
            echo json_encode(['status' => 'ok']);
            exit;
        }

        http_response_code(500);
        echo json_encode(['status' => 'error']);
        exit;
    }

    private function guardarImagen($id) 
    {
        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            return;
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), ['jpg', 'png'])) return;

        foreach (['jpg', 'png'] as $ext) {
            @unlink($this->uploadDir . $id . '.' . $ext);
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
        exit;
    }
}
