<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##selbor';
$contraseña = '12345';

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
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
        .btn-carrito {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }
        .btn-carrito:hover {
            background-color: #218838;
        }
    </style>";

// Mostrar los resultados en una tabla
echo "<table>
        <tr>
            <th>ID Producto</th> <!-- Nueva columna para ID_PRODUCTO -->
            <th>Nombre de Sucursal</th>
            <th>Nombre del Producto</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
        </tr>";

// Recorrer los registros y mostrarlos en la tabla
while ($row = oci_fetch_assoc($p_cursor)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ID_PRODUCTO']) . "</td> <!-- Mostrar el ID_PRODUCTO -->
            <td>" . htmlspecialchars($row['NOMBRE_SUCURSAL']) . "</td>
            <td>" . htmlspecialchars($row['NOMBRE_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['ULTIMA_ACTUALIZACION']) . "</td>
            <td>
                <!-- Botón de Añadir al Carrito -->
                <form method='POST' action='carrito.php'>
                    <input type='hidden' name='nombre_producto' value='" . htmlspecialchars($row['NOMBRE_PRODUCTO']) . "'>
                    <input type='hidden' name='id_producto' value='" . htmlspecialchars($row['ID_PRODUCTO']) . "'> <!-- Agregado el ID_PRODUCTO -->
                    <!-- Aquí agregamos un campo para la cantidad (por ejemplo, predeterminada en 1) -->
                    <label for='cantidad'>Cantidad:</label>
                    <input type='number' name='cantidad' value='1' min='1' class='cantidad-input'>
                    <input type='submit' class='btn-carrito' value='Añadir al Carrito'>
                </form>
            </td>
          </tr>";
}

echo "</table>";

// Liberar recursos
oci_free_statement($stid);
oci_free_statement($p_cursor);

// Cerrar la conexión
oci_close($conn);

?>
