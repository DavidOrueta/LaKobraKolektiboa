<?php
require_once 'config/db.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generación obligatoria Sprint 1
    $qr_token = bin2hex(random_bytes(16)); 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Consulta adaptada a tu tabla 'usuarios'
    $sql = "INSERT INTO usuarios (nombre, dni, email, password, qr_token, direccion) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $_POST['nombre'], $_POST['dni'], $_POST['email'], $password, $qr_token, $_POST['direccion']);

    try {
        if ($stmt->execute()) {
            $mensaje = "<div class='mensaje' style='color:#39ff14'>REGISTRO OK. <a href='login.php' style='color:#fff'>LOGUEATE</a></div>";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $mensaje = "<div class='mensaje' style='color:#ff00ff'>EL DNI O EMAIL YA EXISTE</div>";
        } else {
            $mensaje = "<div class='mensaje' style='color:#ff00ff'>ERROR: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>LAKOBRA - REGISTRO</title>
</head>
<body>
    <div class="container">
        <h2>Nuevo Socio</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="NOMBRE COMPLETO" required>
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="email" name="email" placeholder="EMAIL" required>
            <input type="password" name="password" placeholder="PASSWORD" required>
            <input type="text" name="direccion" placeholder="DIRECCIÓN">
            <button type="submit">DARSE DE ALTA</button>
        </form>
    </div>
</body>
</html>