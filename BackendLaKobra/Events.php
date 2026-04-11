<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
 
require_once '../config/db.php';
 
function getEventos() {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
function getEventoById($id) {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
 
function getEventosPublicos() {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE visible_publico = 1";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
function getEventosPorEstado($estado) {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE estado = :estado";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['estado' => $estado]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
// Endpoint directo: GET /Events.php?tipo=publicos|todos|estado=confirmado
$tipo = $_GET['tipo'] ?? 'publicos';
 
switch ($tipo) {
    case 'todos':
        echo json_encode(getEventos());
        break;
    case 'estado':
        $estado = $_GET['estado'] ?? 'confirmado';
        echo json_encode(getEventosPorEstado($estado));
        break;
    case 'id':
        $id = (int)($_GET['id'] ?? 0);
        echo json_encode(getEventoById($id));
        break;
    default:
        echo json_encode(getEventosPublicos());
        break;
}