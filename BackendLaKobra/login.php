<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . "/config/db.php";

header("Content-Type: application/json");

$conn = conectarDB();

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password, rol, nombre FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['nombre'] = $user['nombre'];

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user['id'],
            "nombre" => $user['nombre'],
            "rol" => $user['rol']
        ]
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Datos inválidos"
    ]);
}