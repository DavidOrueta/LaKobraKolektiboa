<?php
require_once __DIR__ . '/../config/db.php';

function create_event($nom, $desc, $artista, $fecha, $tipo) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO EVENTOS (NOM_EVENTO, DESC_EVENTO, ARTISTA, FECHA, TIPO) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $desc, $artista, $fecha, $tipo);
    
    if ($stmt->execute()) {
        return ["success" => true, "id" => $conn->insert_id];
    } else {
        return ["success" => false, "error" => $stmt->error];
    }
}
?>