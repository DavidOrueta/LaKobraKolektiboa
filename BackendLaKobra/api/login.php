<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
 
session_start();
require_once '../config/db.php';
 
$data = json_decode(file_get_contents('php://input'), true);
 
if (!isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos']);
    exit;
}
 
$stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = :email");
$stmt->execute([':email' => $data['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
 
if (!$user || !password_verify($data['password'], $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Email o contraseña incorrectos']);
    exit;
}
 
$_SESSION['user_id'] = $user['id'];
$_SESSION['nombre']  = $user['nombre'];
$_SESSION['rol']     = $user['rol'];
 
echo json_encode([
    'nombre' => $user['nombre'],
    'rol'    => $user['rol']
]);
 