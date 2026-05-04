<?php

require_once ROOT_PATH . '/app/models/Admin.php';

class LoginController {
    private $model;

    public function __construct() {
        $this->model = new Admin();
    }

    public function login() {
        $error = '';
        require_once ROOT_PATH . '/app/views/admin/login.php';
    }

    public function autenticar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email no válido.";
            require_once ROOT_PATH . '/app/views/admin/login.php';
            return;
        }

        if (!$email || !$password) {
            $error = "Debes ingresar email y contraseña.";
            require_once ROOT_PATH . '/app/views/admin/login.php';
            return;
        }

        $admin = $this->model->verificarAdmin($email, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin;

            header("Location: " . BASE_URL . "admin?action=inicio");
            exit;
        }
        
        $error = "Usuario o contraseña incorrectos.";
        require_once ROOT_PATH . '/app/views/admin/login.php';
    }

    public function getPerfil() {
        if (!isset($_SESSION['admin'])) {
            echo json_encode(['error' => 'No autorizado']);
            return;
        }

        $adminId = $_SESSION['admin']['id_admin'];
        $admin = $this->model->getById($adminId);

        if ($admin) {
            echo json_encode([
                'email' => $admin['email'],
                'password' => $admin['password']
            ]);
        } else {
            echo json_encode(['error' => 'Admin no encontrado']);
        }
    }

    public function actualizarPerfil() {
        if (!isset($_SESSION['admin'])) {
            echo json_encode(['error' => 'No autorizado']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        if (!$email || !$password) {
            echo json_encode(['error' => 'Campos obligatorios']);
            return;
        }

        $adminId = $_SESSION['admin']['id_admin'];
        
        $result = $this->model->actualizarPerfil($adminId, $email, $password);

        if ($result) {
            $_SESSION['admin']['email'] = $email;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al actualizar']);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        
        header("Location: ". BASE_URL . "admin?action=login");
        exit;
    }
}
