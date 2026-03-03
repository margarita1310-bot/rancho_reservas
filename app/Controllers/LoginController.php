<?php

require_once __DIR__ . '/../Models/Admin.php';

class LoginController
{
    public function login()
    {
        $error = '';
        require_once __DIR__ . '/../Views/admin/login.php';
    }

    public function autenticar()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $admin = Admin::verificar($email, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin;

            header("Location: index.php?action=dashboard");
            exit;
        }
            $error = "Usuario o contraseña incorrectos.";
            require_once __DIR__ . '/../Views/admin/login.php';
    }
}