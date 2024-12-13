<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tienda</title>
</head>
<body>
    <h1>Bienvenido al sistema de gestión de tienda, <?php echo htmlspecialchars($_SESSION['usuario']); ?>.</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
