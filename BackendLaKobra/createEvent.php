<?php
session_start();

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/eventAdmin.php';

// 🔐 SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "error" => "Unauthorized: Admin role required"
    ]);
    exit;
}

// 📥 INPUT JSON
$input = json_decode(file_get_contents('php://input'), true);

// 🔍 VALIDACIÓN
if (
    !$input ||
    empty($input['nom_evento']) ||
    empty($input['desc_evento']) ||
    empty($input['fecha'])
) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Invalid input"
    ]);
    exit;
}

// 🧾 VARIABLES
$nom = $input['nom_evento'];
$desc = $input['desc_evento'];
$artista = $input['artista'] ?? null;
$fecha = $input['fecha'];
$tipo = $input['tipo'] ?? null;

// 💾 CREAR EVENTO
$result = create_event($nom, $desc, $artista, $fecha, $tipo);

// 📤 RESPUESTA
if ($result['success']) {
    echo json_encode([
        "success" => true,
        "message" => "Event created successfully",
        "event_id" => $result['id']
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database error",
        "details" => $result['error']
    ]);
}