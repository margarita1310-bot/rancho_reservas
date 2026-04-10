<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT_PATH . '/app/config/env.php';
require_once ROOT_PATH . '/app/models/Cliente.php';
require_once ROOT_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once ROOT_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once ROOT_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

class AuthController {

    private $model;

    public function __construct() {
        $this->model = new Cliente();

    }
        
    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function googleLogin() {
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['token'])) {
            $this->json(['success' => false]);
        }

        $token = $data['token'];

        $response = file_get_contents(
            "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token
        );

        if (!$response) {
            $this->json(['success' => false]);
        }

        $user = json_decode($response);
        
        if (!isset($user->email)) {
            $this->json(['success' => false]);
        }

        $email = $user->email;
        $nombre = $user->name ?? null;

        $cliente = $this->model->getByEmailCliente($email);

        if ($cliente) {
            $_SESSION['cliente'] = $cliente['id_cliente'];

            return $this->json([
                'success' => true,
                'nuevo' => false,
                'cliente' => $cliente
            ]);
        }

        $_SESSION['google_email_temp'] = $email;
        $_SESSION['google_nombre_temp'] = $nombre;
        $_SESSION['codigo_verificado'] = true;

        $this->json([
            'success' => true,
            'nuevo' => true,
            'cliente' => [
                'nombre' => $nombre,
                'email' => $email,
                'telefono' => null
            ]
        ]);
    }
    
    public function enviarCodigo() {
        if (empty($_POST['email'])) {
            $this->json([
                'success' => false,
                'msg' => 'Correo electrónico requerido'
            ]);
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $this->json([
                'success' => false,
                'msg' => 'Correo electrónico inválido'
            ]);
        }
        
        $codigo = random_int(100000, 999999);
        
        $_SESSION['codigo_verificacion'] = $codigo;
        $_SESSION['email_verificacion'] = $email;
        $_SESSION['codigo_expira'] = time() + 600;
        
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $mail->Port = $_ENV['MAIL_PORT'];
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Rancho La Joya');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'Tu código de verificación';
            $mail->Body = "
                <h3>Tu código de verificación es: <b>$codigo</b></h3>
                <p>Válido por 10 minutos</p>
            ";
            
            $mail->send();
            
            $this->json(['success' => true]);

        } catch (Exception $e) {
            
            $this->json([
                'success' => false,
                'msg' => 'Error al enviar correo'
            ]);
        }
    }
    
    public function validarCodigo() {
        $codigoIngresado = $_POST['codigo'] ?? '';
        
        if (!isset($_SESSION['codigo_verificacion'], $_SESSION['codigo_expira'])) {
            $this->json([
                'success' => false,
                'msg' => 'No hay código activo'
            ]);
        }
        
        if (time() > $_SESSION['codigo_expira']) {
            $this->json([
                'success' => false,
                'msg' => 'Código expirado'
            ]);
        }
        
        if ($codigoIngresado != $_SESSION['codigo_verificacion']) {
            $this->json([
                'success' => false,
                'msg' => 'Código incorrecto'
            ]);
        }
        
        $email = $_SESSION['email_verificacion'];

        $cliente = $this->model->getByEmailCliente($email);
        
        if (!$cliente) {
            $cliente = [
                'id_cliente' => null,
                'nombre' => null,
                'email' => $email,
                'telefono' => null
            ];
        } else {
            $_SESSION['cliente'] = $cliente['id_cliente'];
        }
        
        $_SESSION['codigo_verificado'] = true;
        $_SESSION['email_temp'] = $email;
        
        unset(
            $_SESSION['codigo_verificacion'],
            $_SESSION['codigo_expira'],
            $_SESSION['email_verificacion']
        );

        $nuevo = !$cliente['id_cliente'] || !$cliente['telefono'];
        
        $this->json([
            'success' => true,
            'nuevo' => $nuevo,
            'cliente' => $cliente
        ]);
    }
   
    public function guardarDatosCliente() {
        if (!isset($_SESSION['codigo_verificado'])) {
            $this->json([
                'success' => false,
                'msg' => 'No verificado'
            ]);
        }
    
        $nombre = trim($_POST['nombre'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $email = $_SESSION['google_email_temp']
        ?? $_SESSION['email_temp'] ?? null;
        
        if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
            $this->json([
                'success' => false,
                'msg' => 'El nombre solo puede contener letras y espacios'
            ]);
        }

        if (!$nombre) {
            $this->json([
                'success' => false,
                'msg' => 'El nombre es obligatorio'
            ]);
        }

        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $this->json([
                'success' => false,
                'msg' => 'El teléfono debe contener 10 dígitos'
            ]);
        }

        if (!$telefono) {
            $this->json([
                'success' => false,
                'msg' => 'Teléfono es obligatorio'
            ]);
        }

        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'msg' => 'Correo electrónico inválido'
            ]);
        }

        if (!$email) {
            $this->json([
                'success' => false,
                'msg' => 'Correo electrónico es obligatorio'
            ]);
        }
        
        if (!$nombre && !$telefono && !$email) {
            $this->json([
                'success' => false,
                'msg' => 'Todos los campos son obligatorios'
            ]);
        }

        $id = $this->model->crearCliente($nombre, $email, $telefono);
            
        $_SESSION['cliente'] = $id;

        unset(
            $_SESSION['google_email_temp'],
            $_SESSION['google_nombre_temp'],
            $_SESSION['email_temp']
        );
        
        $this->json([
            'success' => true,
            'cliente' => [
                'id_cliente' => $id,
                'nombre' => $nombre,
                'email' => $email,
                'telefono' => $telefono
            ]
        ]);
    }

    public function actualizarDatosCliente() {
        if (!isset($_SESSION['cliente'])) {
            $this->json([
                'success' => false,
                'msg' => 'No autenticado'
            ]);
        }

        $id = $_SESSION['cliente'];
        $nombre = trim($_POST['nombre'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');

        if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
            $this->json([
                'success' => false,
                'msg' => 'El nombre solo puede contener letras y espacios'
            ]);
        }

        if (!$nombre) {
            $this->json([
                'success' => false,
                'msg' => 'El nombre es obligatorio'
            ]);
        }

        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $this->json([
                'success' => false,
                'msg' => 'El teléfono debe contener 10 dígitos'
            ]);
        }

        if (!$telefono) {
            $this->json([
                'success' => false,
                'msg' => 'Teléfono es obligatorio'
            ]);
        }

        if (!$nombre && !$telefono) {
            $this->json([
                'success' => false,
                'msg' => 'Todos los campos son obligatorios'
            ]);
        }

        $this->model->actualizarCliente($id, $nombre, $telefono);

        $this->json(['success' => true]);
    }
}