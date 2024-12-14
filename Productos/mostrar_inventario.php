<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##ANDERSON';
$contraseña = '12345';

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Verificar si se ha pasado el ID_INVENTARIO para eliminar
if (isset($_POST['eliminar'])) {
    $id_inventario = $_POST['id_inventario'];

    // Preparar la consulta de eliminación
    $query = "BEGIN SP_DELETE_INVENTARIO(:id_inventario); END;";
    $stid = oci_parse($conn, $query);

    // Enlazar el parámetro
    oci_bind_by_name($stid, ':id_inventario', $id_inventario);

    // Ejecutar la consulta
    $result = oci_execute($stid);

    if ($result) {
        echo "<p>El registro con ID Inventario $id_inventario ha sido eliminado correctamente.</p>";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al eliminar el registro: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar el recurso
    oci_free_statement($stid);
}

// Preparar el procedimiento almacenado
$query = 'BEGIN sp_get_all_inventario(:p_cursor); END;';
$stid = oci_parse($conn, $query);

// Declarar un cursor de salida
$p_cursor = oci_new_cursor($conn);

// Enlazar el cursor al parámetro de salida
oci_bind_by_name($stid, ':p_cursor', $p_cursor, -1, OCI_B_CURSOR);

// Ejecutar el procedimiento almacenado
if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<p class='error'>Error al ejecutar el procedimiento almacenado: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Ejecutar el cursor
if (!oci_execute($p_cursor)) {
    $e = oci_error($p_cursor);
    echo "<p class='error'>Error al ejecutar el cursor: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Incluir estilos CSS
echo "<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>";

// Mostrar los resultados en una tabla
echo "<table>
        <tr>
            <th>ID Inventario</th>
            <th>Nombre de Sucursal</th>
            <th>ID Producto</th>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
        </tr>";

// Recorrer los registros y mostrarlos en la tabla
while ($row = oci_fetch_assoc($p_cursor)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ID_INVENTARIO']) . "</td>
            <td>" . htmlspecialchars($row['NOMBRE_SUCURSAL']) . "</td>
            <td>" . htmlspecialchars($row['ID_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['NOMBRE_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['CANTIDAD']) . "</td>
            <td>" . htmlspecialchars($row['ULTIMA_ACTUALIZACION']) . "</td>
            <td>
                <!-- Botón de Eliminar -->
                <form method='POST' action=''>
                    <input type='hidden' name='id_inventario' value='" . htmlspecialchars($row['ID_INVENTARIO']) . "'>
                    <input type='submit' name='eliminar' value='Eliminar' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este registro?\")'>
                </form>
                <!-- Botón de Actualizar -->
                <form method='GET' action='actualizar_producto.php'>
                    <input type='hidden' name='id_producto' value='" . htmlspecialchars($row['ID_PRODUCTO']) . "'>
                    <input type='submit' value='Actualizar'>
                </form>
            </td>
          </tr>";
}

echo "</table>";

// Botón para ver sucursales con productos
echo "<form method='GET' action='mostrar_sucursales_productos.php'>
        <input type='submit' value='Mostrar Sucursales con Productos'>
      </form>";

// Liberar recursos
oci_free_statement($stid);
oci_free_statement($p_cursor);

// Cerrar la conexión
oci_close($conn);
?>