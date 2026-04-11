<?php
require_once 'config/db.php';

/* =========================
   CORS FIX
========================= */
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

/* Preflight OPTIONS */
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

/* =========================
   RESPONSE
========================= */
$response = ["success" => false, "message" => ""];

/* =========================
   INPUT JSON (IMPORTANTE)
========================= */
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $qr_token = bin2hex(random_bytes(16));
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, dni, email, password, qr_token, direccion)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssss",
        $data['nombre'],
        $data['dni'],
        $data['email'],
        $password,
        $qr_token,
        $data['direccion']
    );

    try {
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Registro OK";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $response["message"] = "DNI o email ya existe";
        } else {
            $response["message"] = "Error: " . $e->getMessage();
        }
    }
}

echo json_encode($response);