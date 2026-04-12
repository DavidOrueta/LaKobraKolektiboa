<?php
<<<<<<< HEAD
$host = "localhost";
$db   = "lakobra";
$user = "root";
$pass = "";
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
=======
function conectarDB() {
    $host = "localhost";
    $db = "lakobra";
    $user = "root";
    $pass = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
>>>>>>> 8fce333ebbb3df65a2a618a6740f3c0b19d0cdd2
}
 

function conectarDB() {
    global $conn;
    return $conn;
}
?>
 