<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT qr_token FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$token = $res['qr_token'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>LAKOBRA - PANEL</title>
</head>
<body>
    <div class="container" style="text-align: center;">
        <h2>Hola, <?php echo $_SESSION['nombre']; ?></h2>
        <p>Rol: <strong><?php echo $_SESSION['rol']; ?></strong></p>

        <div style="background: white; padding: 10px; display: inline-block; margin: 10px 0;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $token; ?>" alt="QR Socio">
        </div>

        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <div style="color: #ff00ff; border: 1px dashed #ff00ff; padding: 10px; margin-top: 10px;">
                MODO ADMINISTRADOR ACTIVO
            </div>
        <?php endif; ?>
        
        <br><br>
        <button onclick="location.href='logout.php'">CERRAR SESIÓN</button>
    </div>
</body>
</html>