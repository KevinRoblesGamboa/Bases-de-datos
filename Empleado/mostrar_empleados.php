<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Empleados</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .mensaje {
            text-align: center;
            font-size: 18px;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            color: green;
        }
        .error {
            text-align: center;
            font-size: 18px;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            color: red;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Lista de Empleados</h1>
    <div class="mensaje">
    <?php
    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $puerto = '1521'; // Cambia si usas un puerto diferente
    $sid = 'ORCL'; // SID de la base de datos Oracle
    $usuario = 'c##ANDERSON'; // Usuario de la base de datos
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

    // Manejar eliminación de empleado si se recibe un ID para borrar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_empleado']) && isset($_POST['action'])) {
        $id_empleado = $_POST['id_empleado'];
        $action = $_POST['action'];

        if ($action === 'delete') {
            // Llamar al procedimiento almacenado para eliminar empleado
            $stid = oci_parse($conn, 'BEGIN sp_delete_empleado(:id_empleado); END;');
            oci_bind_by_name($stid, ':id_empleado', $id_empleado);

            if (oci_execute($stid)) {
                echo "<p class='mensaje'>Empleado con ID $id_empleado eliminado correctamente.</p>";
            } else {
                $e = oci_error($stid);
                echo "<p class='error'>Error al eliminar el empleado: " . htmlentities($e['message']) . "</p>";
            }

            oci_free_statement($stid);
        }
    }

    // Consultar los datos de la tabla EMPLEADOS
    $query = 'SELECT ID_EMPLEADO, NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL FROM EMPLEADOS';
    $stid = oci_parse($conn, $query);

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        echo "<tr><td colspan='6'>Error en la consulta: " . htmlentities($e['message']) . "</td></tr>";
        oci_close($conn);
        exit;
    }

    echo "<table>";
    echo "<thead>
            <tr>
                <th>ID Empleado</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>ID Sucursal</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tbody>";

    // Iterar sobre los resultados
    while ($row = oci_fetch_assoc($stid)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID_EMPLEADO']) . "</td>";
        echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
        echo "<td>" . htmlspecialchars($row['APELLIDO']) . "</td>";
        echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ID_SUCURSAL']) . "</td>";
        echo "<td class='action-buttons'>";
        echo "<form method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='id_empleado' value='" . htmlspecialchars($row['ID_EMPLEADO']) . "'>";
        echo "<input type='hidden' name='action' value='delete'>";
        echo "<button type='submit'>Eliminar</button>";
        echo "</form>";
        echo "<form method='GET' action='actualizar_empleado.php' style='display:inline;'>";
        echo "<input type='hidden' name='id_empleado' value='" . htmlspecialchars($row['ID_EMPLEADO']) . "'>";
        echo "<button type='submit'>Actualizar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";

    // Obtener el total de empleados
    $query_total_empleados = 'SELECT FN_TOTAL_EMPLEADOS() AS TOTAL_EMPLEADOS FROM DUAL';
    $stid_total = oci_parse($conn, $query_total_empleados);
    oci_execute($stid_total);
    $row_total = oci_fetch_assoc($stid_total);
    $total_empleados = $row_total['TOTAL_EMPLEADOS'];

    echo "<p>Empleados totales = " . htmlspecialchars($total_empleados) . "</p>";

    // Liberar recursos y cerrar conexión
    oci_free_statement($stid);
    oci_free_statement($stid_total);
    oci_close($conn);
    ?>
    </div>
</body>
</html>
