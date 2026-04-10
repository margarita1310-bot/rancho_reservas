<?php

require_once ROOT_PATH . '/app/models/Admin.php';

class LoginController {

    public function login() {
        $error = '';
        require_once ROOT_PATH . '/app/views/admin/login.php';
    }

    public function autenticar() {
        $adminModel = new Admin();

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

        $admin = $adminModel->verificarAdmin($email, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin;

            header("Location: " . BASE_URL . "admin?action=inicio");
            exit;
        }
        
        $error = "Usuario o contraseña incorrectos.";
        require_once ROOT_PATH . '/app/views/admin/login.php';
    }
}
