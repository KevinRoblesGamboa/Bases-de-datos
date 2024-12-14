<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Último Cliente Ingresado</title>
    <!-- Estilos básicos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Último Cliente Ingresado</h1>

    <?php
    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $puerto = '1521';
    $sid = 'ORCL';
    $usuario = 'c##ANDERSON'; // Cambiar por tu usuario
    $contraseña = '12345'; // Cambiar por tu contraseña

    // Conectar a la base de datos
    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) {
        $e = oci_error();
        echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
        exit;
    }

    // Variables para almacenar los resultados de las funciones
    $ultimoNombre = '';
    $ultimaDireccion = '';

    // Llamar a la función FN_ULTIMO_NOMBRE_CLIENTE
    $queryNombre = 'BEGIN :resultado := FN_ULTIMO_NOMBRE_CLIENTE(); END;';
    $stidNombre = oci_parse($conn, $queryNombre);
    oci_bind_by_name($stidNombre, ':resultado', $ultimoNombre, 100);

    // Ejecutar y validar la llamada
    if (!oci_execute($stidNombre)) {
        $e = oci_error($stidNombre);
        echo "<p class='error'>Error al obtener el nombre del último cliente: " . htmlentities($e['message']) . "</p>";
    }

    // Llamar a la función FN_ULTIMA_DIRECCION_CLIENTE
    $queryDireccion = 'BEGIN :resultado := FN_ULTIMA_DIRECCION_CLIENTE(); END;';
    $stidDireccion = oci_parse($conn, $queryDireccion);
    oci_bind_by_name($stidDireccion, ':resultado', $ultimaDireccion, 200);

    // Ejecutar y validar la llamada
    if (!oci_execute($stidDireccion)) {
        $e = oci_error($stidDireccion);
        echo "<p class='error'>Error al obtener la dirección del último cliente: " . htmlentities($e['message']) . "</p>";
    }

    // Mostrar los resultados en una tabla
    if ($ultimoNombre && $ultimaDireccion) {
        echo "<table>";
        echo "<tr><th>Nombre Completo</th><th>Dirección</th></tr>";
        echo "<tr><td>" . htmlspecialchars($ultimoNombre) . "</td><td>" . htmlspecialchars($ultimaDireccion) . "</td></tr>";
        echo "</table>";
    } else {
        echo "<p class='error'>No se encontraron registros de clientes.</p>";
    }

    // Liberar recursos
    oci_free_statement($stidNombre);
    oci_free_statement($stidDireccion);
    oci_close($conn);

    
    ?>

    <!-- Botón de redirección -->
<div style="text-align: center; margin-top: 20px;">
    <a href="mostrar_ultimo_cliente.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Volver a la lista de clientes</a>
</div>
</body>
</html>
