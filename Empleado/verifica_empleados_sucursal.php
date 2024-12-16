<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Empleados por Sucursal</title>
    <!-- Opciones de estilos avanzados -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
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
        .error {
            text-align: center;
            color: red;
            font-weight: bold;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin: 10px auto;
            width: 80%;
        }
        .redirect-button {
            display: inline-block;
            margin: 10px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }
        .redirect-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Verificar Empleados por Sucursal</h1>

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

    // Procesar el formulario de solicitud de ID de sucursal
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_sucursal'])) {
        $idSucursal = $_POST['id_sucursal'];

        // Llamar a la función PL/SQL
        $query = 'BEGIN :cur_empleados := FN_EMPLEADOS_POR_SUCURSAL(:id_sucursal); END;';
        $stid = oci_parse($conn, $query);

        // Crear un cursor para almacenar el resultado
        $curEmpleados = oci_new_cursor($conn);
        oci_bind_by_name($stid, ":id_sucursal", $idSucursal);
        oci_bind_by_name($stid, ":cur_empleados", $curEmpleados, -1, OCI_B_CURSOR);

        // Ejecutar el procedimiento almacenado
        if (oci_execute($stid) && oci_execute($curEmpleados)) {
            echo "<table border='1' style='width: 80%; margin: 20px auto; border-collapse: collapse; font-family: Arial;'>";
            echo "<tr style='background-color: #f2f2f2; text-align: left;'>
                    <th>ID Empleado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                  </tr>";

            while ($row = oci_fetch_assoc($curEmpleados)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ID_EMPLEADO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
                echo "<td>" . htmlspecialchars($row['APELLIDO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al ejecutar la consulta: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_free_statement($curEmpleados);
    }

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Formulario para ingresar ID de sucursal -->
    <div style="text-align: center; margin-top: 20px;">
        <form method="POST">
            <label for="id_sucursal">Ingrese ID de la Sucursal:</label>
            <input type="number" name="id_sucursal" id="id_sucursal" required>
            <input type="submit" value="Buscar Empleados">
        </form>
    </div>

    <!-- Botones de redirección -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="mostrar_sucursal.php" class="redirect-button">Volver a sucursales</a>
    </div>
</body>
</html>
