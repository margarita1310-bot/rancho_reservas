<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../Models/Cliente.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/SMTP.php';

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

        $cliente = $this->model->buscarPorEmail($email);

        if (!$cliente) {
            $id = $this->model->create($nombre, $email);
        } else {
            $id = $cliente['id_cliente'];
        }

        $_SESSION['cliente_id'] = $id;

        $this->json([
            'success' => true,
            'cliente' => [
                'id_cliente' => $id,
                'nombre' => $nombre,
                'email' => $email
            ]
        ]);
    }
    
    public function enviarCodigo() {

        if (empty($_POST['email'])) {
            $this->json([
                'success' => false,
                'message' => 'Email requerido'
            ]);
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $this->json([
                'success' => false,
                'message' => 'Email inválido'
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
                'message' => 'Error al enviar correo'
            ]);
        }
    }
    
    public function validarCodigo() {

        $codigoIngresado = $_POST['codigo'] ?? '';
        
        if (!isset($_SESSION['codigo_verificacion'], $_SESSION['codigo_expira'])) {
            $this->json([
                'success' => false,
                'message' => 'No hay código activo'
            ]);
        }
        
        if (time() > $_SESSION['codigo_expira']) {
            $this->json([
                'success' => false,
                'message' => 'Código expirado'
            ]);
        }
        
        if ($codigoIngresado != $_SESSION['codigo_verificacion']) {
            $this->json([
                'success' => false,
                'message' => 'Código incorrecto'
            ]);
        }
        
        $email = $_SESSION['email_verificacion'];

        $cliente = $this->model->buscarPorEmail($email);
        
        if (!$cliente) {
            $id = $this->model->create(null, $email);

            $cliente = [
                'id_cliente' => $id,
                'nombre' => null,
                'email' => $email,
                'telefono' => null
            ];
        }
        
        $_SESSION['cliente_id'] = $cliente['id_cliente'];
        $_SESSION['codigo_verificado'] = true;
        
        unset(
            $_SESSION['codigo_verificacion'],
            $_SESSION['codigo_expira'],
            $_SESSION['email_verificacion']
        );
        
        $this->json([
            'success' => true,
            'cliente' => $cliente
        ]);
    }
   
    public function guardarDatosCliente() {

        if (!isset($_SESSION['cliente_id'])) {
            $this->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ]);
        }
    
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
    
        if (!$nombre || !$telefono) {
            $this->json(['success' => false]);
        }
    
        $this->model->actualizarDatos(
            $_SESSION['cliente_id'],
            $nombre,
            $telefono
        );
        
        $this->json(['success' => true]);
    }
}