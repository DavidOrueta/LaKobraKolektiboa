<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'config/db.php';

/* Preflight */
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

/* Solo POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
    exit;
}

/* INPUT JSON */
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data)) {
    echo json_encode([
        "success" => false,
        "message" => "JSON inválido o vacío"
    ]);
    exit;
}

/* VALIDACIÓN CAMPOS */
$campos = ['nombre', 'dni', 'email', 'password', 'direccion'];

foreach ($campos as $c) {
    if (empty($data[$c])) {
        echo json_encode([
            "success" => false,
            "message" => "Falta el campo: $c"
        ]);
        exit;
    }
}

try {

    $conn = conectarDB();

    $qr_token = bin2hex(random_bytes(16));
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, dni, email, password, qr_token, direccion)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $data['nombre'],
        $data['dni'],
        $data['email'],
        $password,
        $qr_token,
        $data['direccion']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Registro OK"
    ]);

} catch (Throwable $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error servidor",
        "debug" => $e->getMessage()
    ]);
}