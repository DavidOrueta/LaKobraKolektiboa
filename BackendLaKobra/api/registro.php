<?php
header('Content-Type: application/json');

session_start();
require_once '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['nombre'], $data['dni'], $data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos obligatorios']);
    exit;
}

$qr_token = bin2hex(random_bytes(16));
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, dni, email, password, qr_token, direccion)
        VALUES (:nombre, :dni, :email, :password, :qr_token, :direccion)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nombre'    => $data['nombre'],
        ':dni'       => $data['dni'],
        ':email'     => $data['email'],
        ':password'  => $password,
        ':qr_token'  => $qr_token,
        ':direccion' => $data['direccion'] ?? ''
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        http_response_code(409);
        echo json_encode(['error' => 'El DNI o email ya existe']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error interno: ' . $e->getMessage()]);
    }
}