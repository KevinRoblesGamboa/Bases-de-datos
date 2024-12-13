<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clientes</title>
</head>
<body>
    <h1>Bienvenido al sistema de clientes, <?php echo htmlspecialchars($_SESSION['usuario']); ?>.</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
