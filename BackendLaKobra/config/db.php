<?php

function conectarDB() {
    $host = "localhost";
    $db = "lakobra";
    $user = "root";
    $pass = "";

    try {
        $conexion = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8",
            $user,
            $pass
        );

        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;

    } catch (PDOException $e) {
        die(json_encode([
            "success" => false,
            "message" => "Error de conexión",
            "debug" => $e->getMessage()
        ]));
    }
}