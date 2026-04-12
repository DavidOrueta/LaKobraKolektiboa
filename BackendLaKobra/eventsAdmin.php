<?php
require_once __DIR__ . '/config/db.php';

/**
 * 🔐 EVENT ADMIN SERVICE
 * Aquí van todas las funciones de administración de eventos
 */

function create_event($nom, $desc, $artista, $fecha, $tipo)
{
    global $conn;

    $stmt = $conn->prepare("
        INSERT INTO EVENTOS 
        (NOM_EVENTO, DESC_EVENTO, ARTISTA, FECHA, TIPO)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        return [
            "success" => false,
            "error" => $conn->error
        ];
    }

    $stmt->bind_param("sssss", $nom, $desc, $artista, $fecha, $tipo);

    if ($stmt->execute()) {
        return [
            "success" => true,
            "id" => $conn->insert_id,
            "message" => "Event created successfully"
        ];
    } else {
        return [
            "success" => false,
            "error" => $stmt->error
        ];
    }
}

/**
 * 📋 (OPCIONAL PERO RECOMENDADO)
 * Obtener todos los eventos
 */
function get_events()
{
    global $conn;

    $sql = "SELECT * FROM EVENTOS ORDER BY FECHA DESC";
    $result = $conn->query($sql);

    if (!$result) {
        return [
            "success" => false,
            "error" => $conn->error
        ];
    }

    $events = [];

    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    return [
        "success" => true,
        "data" => $events
    ];
}

function delete_event($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM EVENTOS WHERE ID_EVENTO = ?");

    if (!$stmt) {
        return [
            "success" => false,
            "error" => $conn->error
        ];
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return [
            "success" => true,
            "message" => "Event deleted"
        ];
    } else {
        return [
            "success" => false,
            "error" => $stmt->error
        ];
    }
}