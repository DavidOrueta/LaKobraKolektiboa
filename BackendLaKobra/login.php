<?php
session_start();
require_once '../config/db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT id, password, rol, nombre FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

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