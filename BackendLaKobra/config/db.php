<?php
$host = "localhost";
$db   = "lakobra";
$user = "root";
$pass = "";
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
 
// Función también disponible por si otros archivos la usan
function conectarDB() {
    global $conn;
    return $conn;
}
?>
 