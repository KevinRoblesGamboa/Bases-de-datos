<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Sucursales</title>
    <!-- Opciones de estilos básicos -->
<style>
    table {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    form {
        display: inline;
    }
    input[type="submit"] {
        padding: 5px 10px;
        margin: 2px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .success {
        text-align: center;
        color: green;
        font-weight: bold;
    }
    .error {
        text-align: center;
        color: red;
        font-weight: bold;
    }
</style>

    </style>
</head>
<body>
    <h1 style="text-align: center;">Lista de Sucursales</h1>

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

    // Manejar eliminación de una sucursal
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sucursal'])) {
        $id_sucursal = $_POST['id_sucursal'];

        $delete_stid = oci_parse($conn, 'BEGIN SP_DELETE_SUCURSAL(:id_sucursal); END;');
        oci_bind_by_name($delete_stid, ':id_sucursal', $id_sucursal);

        if (oci_execute($delete_stid)) {
            echo "<p style='color: green; text-align: center;'>Sucursal con ID $id_sucursal eliminada correctamente.</p>";
        } else {
            $e = oci_error($delete_stid);
            echo "<p style='color: red; text-align: center;'>Error al eliminar la sucursal: " . htmlentities($e['message']) . "</p>";
        }

        oci_free_statement($delete_stid);
    }

    // Obtener la lista de sucursales
    $query = 'BEGIN SP_GET_SUCURSAL(:cursor); END;';
    $stid = oci_parse($conn, $query);

    // Crear un cursor para los resultados
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stid, ":cursor", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento
    if (oci_execute($stid) && oci_execute($cursor)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>";

        // Recorrer los resultados
        while ($row = oci_fetch_assoc($cursor)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ID_SUCURSAL']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DIRECCION']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";
            echo "<td class='actions'>";
            echo "<form method='POST' style='display: inline;'>";
            echo "<input type='hidden' name='id_sucursal' value='" . htmlspecialchars($row['ID_SUCURSAL']) . "'>";
            echo "<button type='submit' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro de eliminar esta sucursal?\");'>Eliminar</button>";
            echo "</form>";
            echo "<a href='actualizar_sucursal.php?id_sucursal=" . urlencode($row['ID_SUCURSAL']) . "' class='btn btn-update'>Actualizar</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al obtener la lista de sucursales: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recursos
    oci_free_statement($stid);
    oci_free_statement($cursor);

    // Cerrar la conexión
    oci_close($conn);
    ?>

    
</body>
</html>