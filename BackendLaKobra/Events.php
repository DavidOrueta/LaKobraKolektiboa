<?php
require_once "<config>db.php";


function getEventos() {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* 🔹 Obtener evento por ID */
function getEventoById($id) {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* 🔹 Obtener eventos visibles */
function getEventosPublicos() {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE visible_publico = 1";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* 🔹 Obtener eventos por estado */
function getEventosPorEstado($estado) {
    $conexion = conectarDB();
    $sql = "SELECT * FROM eventos WHERE estado = :estado";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['estado' => $estado]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>