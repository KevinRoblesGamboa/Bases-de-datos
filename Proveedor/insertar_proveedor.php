<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <style>
        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Registrar Proveedor</h1>

    <?php
    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $puerto = '1521'; // Cambia si usas un puerto diferente
    $sid = 'ORCL'; // SID de la base de datos Oracle
    $usuario = 'c##ANDERSON'; // Usuario de la base de datos
    $contraseña = '12345'; // Contraseña del usuario

    // Crear la conexión
    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) {
        $e = oci_error();
        echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
        exit;
    }

    // Verificar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $nombre = $_POST['nombre'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        // Preparar la llamada al procedimiento almacenado
        $query = 'BEGIN SP_CREATE_PROVEEDOR(:nombre, :contacto, :telefono, :direccion); END;';
        $stid = oci_parse($conn, $query);

        if (!$stid) {
            $e = oci_error($conn);
            echo "<p class='error'>Error al preparar la consulta: " . htmlentities($e['message']) . "</p>";
            exit;
        }

        // Enlazar parámetros a la consulta
        oci_bind_by_name($stid, ":nombre", $nombre);
        oci_bind_by_name($stid, ":contacto", $contacto);
        oci_bind_by_name($stid, ":telefono", $telefono);
        oci_bind_by_name($stid, ":direccion", $direccion);

        // Ejecutar consulta
        $result = oci_execute($stid);

        if ($result) {
            echo "<p class='message'>Proveedor registrado con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al registrar el proveedor: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar recursos
        oci_free_statement($stid);
    }

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Formulario HTML -->
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto">

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion"></textarea>

        <input type="submit" value="Registrar Proveedor">
    </form>

</body>
</html>