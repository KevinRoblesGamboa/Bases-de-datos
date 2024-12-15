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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clientes</title>
</head>
<body>
    <h1>Bienvenido al sistema de clientes, <?php echo htmlspecialchars($_SESSION['usuario']); ?>.</h1>
    <a  class="btn btn-danger btn-lg" href="logout.php">
        Cerrar sesión
    </a>
</body>
</html>
