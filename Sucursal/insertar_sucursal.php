<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Sucursal</title>
    <style>
        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        input[type="text"], input[type="number"] {
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

    <h1 style="text-align: center;">Insertar Sucursal</h1>

    <?php
  // Configuración de la conexión a la base de datos
  $host = 'localhost';
  $puerto = '1521'; // Cambia si usas un puerto diferente
  $sid = 'ORCL'; // SID de la base de datos Oracle
  $usuario = 'PROYECTOSC504'; // Usuario de la base de datos
  $contraseña = '1234567'; // Contraseña del usuario
  
  // Crear la conexión
  $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) {
        $e = oci_error();
        echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
        exit;
    }

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        // Preparar la llamada al procedimiento almacenado
        $query = 'BEGIN SP_CREATE_SUCURSAL(:nombre, :direccion, :telefono); END;';
        $stid = oci_parse($conn, $query);

        // Enlazar los valores a los parámetros de la consulta
        oci_bind_by_name($stid, ":nombre", $nombre);
        oci_bind_by_name($stid, ":direccion", $direccion);
        oci_bind_by_name($stid, ":telefono", $telefono);

        // Ejecutar la consulta
        $result = oci_execute($stid);

        // Verificar si la inserción fue exitosa
        if ($result) {
            echo "<p class='message'>Sucursal insertada con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al insertar la sucursal: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar el recurso de la consulta
        oci_free_statement($stid);
    }

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Formulario HTML para ingresar los datos de la sucursal -->
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <input type="submit" value="Insertar Sucursal">
    </form>

</body>
</html>