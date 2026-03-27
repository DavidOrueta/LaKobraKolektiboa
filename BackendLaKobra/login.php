<?php
session_start();
require_once 'config/db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $stmt = $conn->prepare("SELECT id, password, rol, nombre FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['nombre'] = $user['nombre'];
        header("Location: index.php");
        exit;
    } else {
        $error = "DATOS INVÁLIDOS";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>LaKobra Login</title>
</head>
<body>
    <div class="container">
        <h2>Acceso</h2>
        <?php if($error) echo "<div class='mensaje' style='color:#ff00ff'>$error</div>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="EMAIL" required>
            <input type="password" name="password" placeholder="PASSWORD" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>