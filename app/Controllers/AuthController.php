<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../Models/Cliente.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libraries/PHPMailer/src/SMTP.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new Cliente();
    }

    /* Login con google */

    public function googleLogin()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $token = $data['token'];

        $response = file_get_contents(
            "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token
        );

        $user = json_decode($response);

        if (!isset($user->email)) {
            echo json_encode(['success' => false]);
            exit;
        }

        $email = $user->email;
        $nombre = $user->name;

        $cliente = $this->model->buscarPorEmail($email);

        if (!$cliente) {
            $id = $this->model->create($nombre, $email);
        } else {
            $id = $cliente['id_cliente'];
        }

        $_SESSION['cliente_id'] = $id;

        echo json_encode(['success' => true]);
    }

 public function enviarCodigo()
{
    header('Content-Type: application/json');

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        echo json_encode(['success' => false, 'message' => 'Email requerido']);
        exit;
    }

    $email = $_POST['email'];
    $codigo = rand(100000, 999999);

    $_SESSION['codigo_verificacion'] = $codigo;
    $_SESSION['email_verificacion'] = $email;
    $_SESSION['codigo_expira'] = time() + 600; // 10 minutos

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom('teamerenmargarita@gmail.com', 'Rancho Gestión');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Tu código de verificación';
        $mail->Body = "
            <h3>Tu código de verificación es: <b>$codigo</b></h3>
            <p>Válido por 10 minutos</p>
        ";

        $mail->send();

        echo json_encode(['success' => true]);
        exit;

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al enviar correo'
        ]);
        exit;
    }
}

public function validarCodigo()
{
    header('Content-Type: application/json');

    $codigoIngresado = $_POST['codigo'] ?? '';

    if (!isset($_SESSION['codigo_verificacion'], $_SESSION['codigo_expira'])) {
        echo json_encode(['success' => false, 'message' => 'No hay código activo']);
        exit;
    }

    if (time() > $_SESSION['codigo_expira']) {
        echo json_encode(['success' => false, 'message' => 'Código expirado']);
        exit;
    }

    if ($codigoIngresado != $_SESSION['codigo_verificacion']) {
        echo json_encode(['success' => false, 'message' => 'Código incorrecto']);
        exit;
    }

    $email = $_SESSION['email_verificacion'];
    $cliente = $this->model->buscarPorEmail($email);

    if (!$cliente) {
        $id = $this->model->create(null, $email);
        $cliente = [
            'id_cliente' => $id,
            'email' => $email,
            'nombre' => null,
            'telefono' => null
        ];
    }

    $_SESSION['cliente_id'] = $cliente['id_cliente'];
    $_SESSION['codigo_verificado'] = true;

    unset($_SESSION['codigo_verificacion'], $_SESSION['codigo_expira']);

    echo json_encode([
        'success' => true,
        'cliente' => $cliente
    ]);
    exit;
}
   
    public function guardarDatosCliente()
    {
        if (!isset($_SESSION['cliente_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            return;
        }
    
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
    
        if (!$nombre || !$telefono) {
            echo json_encode(['success' => false]);
            return;
        }
    
        $this->model->actualizarDatos(
            $_SESSION['cliente_id'],
            $nombre,
            $telefono
        );
    
        echo json_encode(['success' => true]);
    }
}