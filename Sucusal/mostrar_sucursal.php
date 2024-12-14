<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Sucursales</title>
    <!-- Opciones de estilos avanzados -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
        .actions {
            text-align: center;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            color: white;
            cursor: pointer;
            margin: 2px;
            border-radius: 4px;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-update {
            background-color: #3498db;
        }
        .btn-update:hover {
            background-color: #2980b9;
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
        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            width: 60%;
            margin: 10px auto;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Lista de Sucursales</h1>

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
        echo "<div class='message error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</div>";
        exit;
    }

    // Manejar eliminación de una sucursal
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sucursal'])) {
        $id_sucursal = $_POST['id_sucursal'];

        $delete_stid = oci_parse($conn, 'BEGIN SP_DELETE_SUCURSAL(:id_sucursal); END;');
        oci_bind_by_name($delete_stid, ':id_sucursal', $id_sucursal);

        if (oci_execute($delete_stid)) {
            echo "<div class='message success'>Sucursal con ID $id_sucursal eliminada correctamente.</div>";
        } else {
            $e = oci_error($delete_stid);
            echo "<div class='message error'>Error al eliminar la sucursal: " . htmlentities($e['message']) . "</div>";
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
        echo "<div class='message error'>Error al obtener la lista de sucursales: " . htmlentities($e['message']) . "</div>";
    }

    // Liberar recursos
    oci_free_statement($stid);
    oci_free_statement($cursor);

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Botones de redirección -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="verifica_empleados_sucursal.php" class="redirect-button">Verificar empleados por sucursal</a>
        
    </div>
</body>
</html>
