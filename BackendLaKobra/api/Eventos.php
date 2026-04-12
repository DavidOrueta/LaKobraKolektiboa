<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
 
session_start();
require_once '../config/db.php';
 
$method = $_SERVER['REQUEST_METHOD'];
 
// Solo admin puede crear, editar y borrar
function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}
 
switch ($method) {
 
    // GET /eventos.php          → todos los eventos públicos
    // GET /eventos.php?todos=1  → todos (solo admin)
    case 'GET':
        if (isset($_GET['todos']) && esAdmin()) {
            $stmt = $conn->query("SELECT * FROM eventos ORDER BY fecha_evento DESC");
        } else {
            $stmt = $conn->query("SELECT * FROM eventos WHERE visible_publico = 1 ORDER BY fecha_evento DESC");
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
 
    // POST /eventos.php → crear evento (admin)
    case 'POST':
        if (!esAdmin()) { http_response_code(403); echo json_encode(['error' => 'Sin permisos']); exit; }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['titulo'], $data['fecha_evento'])) {
            http_response_code(400); echo json_encode(['error' => 'Faltan campos']); exit;
        }
        $stmt = $conn->prepare("INSERT INTO eventos (titulo, fecha_evento, hora_inicio, aforo_max, estado, visible_publico)
                                VALUES (:titulo, :fecha_evento, :hora_inicio, :aforo_max, :estado, :visible_publico)");
        $stmt->execute([
            ':titulo'          => $data['titulo'],
            ':fecha_evento'    => $data['fecha_evento'],
            ':hora_inicio'     => $data['hora_inicio']     ?? null,
            ':aforo_max'       => $data['aforo_max']       ?? 120,
            ':estado'          => $data['estado']          ?? 'pendiente',
            ':visible_publico' => $data['visible_publico'] ?? 0,
        ]);
        echo json_encode(['success' => true, 'id' => $conn->lastInsertId()]);
        break;
 
    // PUT /eventos.php?id=X → editar evento (admin)
    case 'PUT':
        if (!esAdmin()) { http_response_code(403); echo json_encode(['error' => 'Sin permisos']); exit; }
        $id   = (int)($_GET['id'] ?? 0);
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$id) { http_response_code(400); echo json_encode(['error' => 'ID requerido']); exit; }
        $stmt = $conn->prepare("UPDATE eventos SET
            titulo          = :titulo,
            fecha_evento    = :fecha_evento,
            hora_inicio     = :hora_inicio,
            aforo_max       = :aforo_max,
            estado          = :estado,
            visible_publico = :visible_publico
            WHERE id = :id");
        $stmt->execute([
            ':titulo'          => $data['titulo'],
            ':fecha_evento'    => $data['fecha_evento'],
            ':hora_inicio'     => $data['hora_inicio']     ?? null,
            ':aforo_max'       => $data['aforo_max']       ?? 120,
            ':estado'          => $data['estado']          ?? 'pendiente',
            ':visible_publico' => $data['visible_publico'] ?? 0,
            ':id'              => $id,
        ]);
        echo json_encode(['success' => true]);
        break;
 
    // DELETE /eventos.php?id=X → borrar evento (admin)
    case 'DELETE':
        if (!esAdmin()) { http_response_code(403); echo json_encode(['error' => 'Sin permisos']); exit; }
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) { http_response_code(400); echo json_encode(['error' => 'ID requerido']); exit; }
        $conn->prepare("DELETE FROM eventos WHERE id = :id")->execute([':id' => $id]);
        echo json_encode(['success' => true]);
        break;
 
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
 