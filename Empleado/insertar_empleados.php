<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Empleado</title>
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
    </style>
</head>
<body>

    <h1 style="text-align: center;">Insertar Empleado</h1>

    <?php
// Obtener la conexión a la base de datos

// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521'; // Cambia si usas un puerto diferente
$sid = 'ORCL'; // SID de la base de datos Oracle
$usuario = 'c##selbor'; // Usuario de la base de datos
$contraseña = '12345'; // Contraseña del usuario

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if ($conn) {
    echo "<p class='success'>Conexión a la base de datos realizada con éxito.</p>";
} else {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $id_sucursal = $_POST['id_sucursal'];

        // Preparar la llamada al procedimiento almacenado
        $query = 'BEGIN sp_create_empleado(:nombre, :apellido, :telefono, :id_sucursal); END;';
        $stid = oci_parse($conn, $query);

        // Enlazar los valores a los parámetros de la consulta
        oci_bind_by_name($stid, ":nombre", $nombre);
        oci_bind_by_name($stid, ":apellido", $apellido);
        oci_bind_by_name($stid, ":telefono", $telefono);
        oci_bind_by_name($stid, ":id_sucursal", $id_sucursal);

        // Ejecutar la consulta
        $result = oci_execute($stid);

        // Verificar si la inserción fue exitosa
        if ($result) {
            echo "<p class='message'>Empleado insertado con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p>Error al insertar el empleado: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar el recurso de la consulta
        oci_free_statement($stid);
    }

    // Cerrar la conexión
    
    ?>

    <!-- Formulario HTML para ingresar los datos del empleado -->
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <label for="id_sucursal">ID Sucursal:</label>
        <input type="number" id="id_sucursal" name="id_sucursal" required>

        <input type="submit" value="Insertar Empleado">
    </form>

</body>
</html>
