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
?>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID Empleado</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>ID Sucursal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar los datos de la tabla EMPLEADOS
            $query = 'SELECT ID_EMPLEADO, NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL FROM EMPLEADOS';
            $stid = oci_parse($conn, $query);

            if (!oci_execute($stid)) {
                $e = oci_error($stid);
                echo "<tr><td colspan='5'>Error en la consulta: " . htmlentities($e['message']) . "</td></tr>";
                oci_close($conn);
                exit;
            }

            // Iterar sobre los resultados
            while ($row = oci_fetch_assoc($stid)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ID_EMPLEADO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
                echo "<td>" . htmlspecialchars($row['APELLIDO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ID_SUCURSAL']) . "</td>";
                echo "</tr>";
            }

            // Liberar recursos y cerrar conexión
            oci_free_statement($stid);
            oci_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>