<?php
session_start();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Comprobar si el usuario es "admin"
    if (strtolower($usuario) === 'admin') {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = 'admin';
        header('Location: sistema_gestion_tienda.php'); // Redirigir al sistema de gestión
    } else {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = 'cliente';
        header('Location: sistema_clientes.php'); // Redirigir al sistema de clientes
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"], .btn-register {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        input[type="submit"]:hover, .btn-register:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Inicio de Sesión</h1>
    <form method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Iniciar Sesión">
        <a href="insertar_cliente.php" class="btn-register">Registrar</a>
    </form>
</body>
</html>
