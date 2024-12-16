<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Proveedores</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            text-align: center;
        }
        .btn-update {
            background-color: #4CAF50;
        }
        .btn-update:hover {
            background-color: #45a049;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-delete:hover {
            background-color: #e53935;
        }
        .total-proveedores {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: blue; /* Ajusta el color según sea necesario */
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Lista de Proveedores</h1>

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

    // Obtener la lista de proveedores
    $query = 'BEGIN SP_GET_PROVEEDORES(:cursor); END;';
    $stid = oci_parse($conn, $query);

    // Crear un cursor para los resultados
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stid, ":cursor", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento
    if (oci_execute($stid) && oci_execute($cursor)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Contacto</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th></tr>";

        // Recorrer los resultados
        while ($row = oci_fetch_assoc($cursor)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ID_PROVEEDOR']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['CONTACTO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DIRECCION']) . "</td>";
            echo "<td class='actions'>";
            echo "<a href='actualizar_proveedor.php?id_proveedor=" . urlencode($row['ID_PROVEEDOR']) . "' class='btn btn-update'>Actualizar</a>";
            echo "<a href='eliminar_proveedor.php?id_proveedor=" . urlencode($row['ID_PROVEEDOR']) . "' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro de eliminar este proveedor?\");'>Eliminar</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Obtener el total de proveedores
        $query_total_proveedores = 'SELECT FN_TOTAL_PROVEEDORES() AS TOTAL_PROVEEDORES FROM DUAL';
        $stid_total = oci_parse($conn, $query_total_proveedores);
        oci_execute($stid_total);
        $row_total = oci_fetch_assoc($stid_total);
        $total_proveedores = $row_total['TOTAL_PROVEEDORES'];

        echo "<p class='total-proveedores'>Total de proveedores: " . htmlspecialchars($total_proveedores) . "</p>";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al obtener la lista de proveedores: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recursos
    oci_free_statement($stid);
    oci_free_statement($cursor);

    // Cerrar la conexión
    oci_close($conn);
    ?>
</body>
</html>
