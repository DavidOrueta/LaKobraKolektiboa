<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Vacío en XAMPP por defecto
$db   = 'lakobra';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>