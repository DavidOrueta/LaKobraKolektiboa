<?php
session_start();
header('Content-Type: application/json');
require_once '../Service/eventService.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: Admin role required"]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['nom_evento']) || empty($input['desc_evento']) || empty($input['fecha'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input. Name, Description and Date are required."]);
    exit;
}

$nom = $input['nom_evento'];
$desc = $input['desc_evento'];
$artista = $input['artista'] ?? null;
$fecha = $input['fecha'];
$tipo = $input['tipo'] ?? null;

$result = create_event($nom, $desc, $artista, $fecha, $tipo);

if ($result['success']) {
    echo json_encode([
        "message" => "Event created successfully",
        "event_id" => $result['id']
    ]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create event", "details" => $result['error']]);
}
?>