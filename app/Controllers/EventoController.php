<?php

require_once __DIR__ . '/../Models/Evento.php';

class EventoController
{
    private $model;
    private $uploadDir;

    public function __construct()
    {
        $this->model = new Evento();
        $this->uploadDir = __DIR__ . '/../../public/images/evento/';
    }

    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');
        
        $evento = $this->model->getAll();
        
        foreach ($evento as &$e) {
            $e['imagen'] = null;
            foreach (['jpg', 'png'] as $ext) {
                if (is_file($this->uploadDir . $e['id_evento'] . '.' . $ext)) {
                    $e['imagen'] = $e['id_evento'] . '.' . $ext;
                    break;
                }
            }
        }
        
        echo json_encode($evento);
    }

    public function guardar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $hora_fin = $_POST['hora_fin'] ?? '';
        $mesas_disponibles = $_POST['mesas_disponibles'] ?? 0;
        $precio_mesa = $_POST['precio_mesa'] ?? 0;
        $estado = $_POST['estado'] ?? '';

        if (!$nombre || !$fecha || !$hora || !$hora_fin || !$estado) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'msg' => 'Faltan campos requeridos']);
            exit;
        }

        if (empty($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'msg' => 'Debes seleccionar una imagen para el evento'
            ]);
            exit;
        }

        $id = $this->model->create($nombre, $descripcion, $fecha, $hora, $hora_fin, $mesas_disponibles, $precio_mesa, $estado);
        
        if (!$id) {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
            exit;
        }

        $this->guardarImagen($id);
        echo json_encode(['status' => 'ok', 'id_evento' => $id]);
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
        
        $evento = $this->model->getById($id);

        if (!$evento) {
            http_response_code(404);
            return;
        }

        foreach (['jpg', 'png'] as $ext) {
            if (is_file($this->uploadDir . $id . '.' . $ext)) {
                $evento['imagen'] = $id . '.' . $ext;
                break;
            }
        }

        echo json_encode($evento);
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
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['fecha'],
            $_POST['hora'],
            $_POST['hora_fin'],
            $_POST['mesas_disponibles'],
            $_POST['precio_mesa'],
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

if(isset($_GET['action'])) {
    $controller = new EventoController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
        exit;
    }
}
