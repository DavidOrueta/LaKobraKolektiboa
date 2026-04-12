<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}



require_once __DIR__ . "/config/db.php";
$conexion = conectarDB();
$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

/* =========================
   🔵 GET
========================= */
if ($method === "GET") {

    if ($id) {
        $sql = "SELECT * FROM eventos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($resultado ?: ["mensaje" => "No encontrado"]);
    } else {
        $sql = "SELECT * FROM eventos";
        $stmt = $conexion->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    exit;
}

/* =========================
   🟢 POST (crear evento)
========================= */
if ($method === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "INSERT INTO eventos 
    (titulo, fecha_evento, hora_inicio, aforo_max, estado, visible_publico)
    VALUES 
    (:titulo, :fecha_evento, :hora_inicio, :aforo_max, :estado, :visible_publico)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        "titulo" => $data["titulo"],
        "fecha_evento" => $data["fecha_evento"],
        "hora_inicio" => $data["hora_inicio"],
        "aforo_max" => $data["aforo_max"],
        "estado" => $data["estado"],
        "visible_publico" => $data["visible_publico"]
    ]);

    echo json_encode([
        "mensaje" => "Evento creado",
        "id" => $conexion->lastInsertId()
    ]);

    exit;
}

/* =========================
   🟡 PUT (actualizar)
========================= */
if ($method === "PUT") {

    if (!$id) {
        echo json_encode(["error" => "Falta ID"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "UPDATE eventos 
            SET titulo = :titulo,
                fecha_evento = :fecha_evento,
                hora_inicio = :hora_inicio,
                aforo_max = :aforo_max,
                estado = :estado,
                visible_publico = :visible_publico
            WHERE id = :id";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        "id" => $id,
        "titulo" => $data["titulo"],
        "fecha_evento" => $data["fecha_evento"],
        "hora_inicio" => $data["hora_inicio"],
        "aforo_max" => $data["aforo_max"],
        "estado" => $data["estado"],
        "visible_publico" => $data["visible_publico"]
    ]);

    echo json_encode(["mensaje" => "Evento actualizado"]);

    exit;
}

/* =========================
   🔴 DELETE
========================= */
if ($method === "DELETE") {

    if (!$id) {
        echo json_encode(["error" => "Falta ID"]);
        exit;
    }

    $sql = "DELETE FROM eventos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['id' => $id]);

    echo json_encode(["mensaje" => "Evento eliminado"]);

    exit;
}

/* =========================
   ❌ Método no permitido
========================= */
echo json_encode(["error" => "Método no permitido"]);