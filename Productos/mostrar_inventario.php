<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521'; // Cambia si usas un puerto diferente
$sid = 'ORCL'; // SID de la base de datos Oracle
$usuario = 'c##selbor'; // Usuario de la base de datos
$contraseña = '12345'; // Contraseña del usuario

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Consulta para obtener todos los registros del inventario
$query = "SELECT ID_INVENTARIO, ID_SUCURSAL, ID_PRODUCTO, CANTIDAD, ULTIMA_ACTUALIZACION
          FROM INVENTARIO";
$stid = oci_parse($conn, $query);

// Ejecutar la consulta
oci_execute($stid);

// Mostrar los resultados
echo "<table border='1'>
        <tr>
            <th>ID Inventario</th>
            <th>ID Sucursal</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Última Actualización</th>
        </tr>";

// Recorrer los registros y mostrarlos en la tabla
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ID_INVENTARIO']) . "</td>
            <td>" . htmlspecialchars($row['ID_SUCURSAL']) . "</td>
            <td>" . htmlspecialchars($row['ID_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['CANTIDAD']) . "</td>
            <td>" . htmlspecialchars($row['ULTIMA_ACTUALIZACION']) . "</td>
          </tr>";
}

echo "</table>";

// Liberar recursos
oci_free_statement($stid);
oci_close($conn);
?>
