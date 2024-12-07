<?php
// Conexión a la base de datos

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

// Leer clientes
$query = 'BEGIN SP_GET_CLIENTES(:cursor_out); END;';
$stid = oci_parse($conn, $query);

// Crear un cursor para almacenar el resultado
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stid, ":cursor_out", $cursor, -1, OCI_B_CURSOR);

// Ejecutar el procedimiento almacenado
if (oci_execute($stid) && oci_execute($cursor)) {
    echo "<table border='1' style='width: 80%; margin: 20px auto; border-collapse: collapse; font-family: Arial;'>";
    echo "<tr style='background-color: #f2f2f2; text-align: left;'>
            <th>ID Cliente</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>";

    while ($row = oci_fetch_assoc($cursor)) {
        echo "<tr>";
        echo "<td>" . $row['ID_CLIENTE'] . "</td>";
        echo "<td>" . $row['NOMBRE'] . "</td>";
        echo "<td>" . $row['APELLIDO'] . "</td>";
        echo "<td>" . $row['EMAIL'] . "</td>";
        echo "<td>" . $row['DIRECCION'] . "</td>";
        echo "<td>" . $row['TELEFONO'] . "</td>";
        echo "<td>
                <form method='POST' style='display: inline;'>
                    <input type='hidden' name='id_cliente' value='" . $row['ID_CLIENTE'] . "'>
                    <input type='submit' name='action' value='Actualizar'>
                </form>
                <form method='POST' style='display: inline;'>
                    <input type='hidden' name='id_cliente' value='" . $row['ID_CLIENTE'] . "'>
                    <input type='submit' name='action' value='Eliminar'>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    $e = oci_error($stid);
    echo "Error al recuperar los clientes: " . htmlentities($e['message']);
}

// Procesar acción de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $id_cliente = $_POST['id_cliente'];

    if ($_POST['action'] == 'Actualizar') {
        // Redirigir a la página de actualización con el ID del cliente
        header("Location: actualizar_cliente.php?id_cliente=$id_cliente");
        exit;
    } elseif ($_POST['action'] == 'Eliminar') {
        // Llamar al procedimiento almacenado para eliminar cliente
        $query = 'BEGIN SP_DELETE_CLIENTE(:id_cliente); END;';
        $stid = oci_parse($conn, $query);

        // Enlazar el ID del cliente
        oci_bind_by_name($stid, ":id_cliente", $id_cliente);

        // Ejecutar consulta
        if (oci_execute($stid)) {
            echo "<p class='message'>Cliente eliminado con éxito.</p>";
            // Volver a cargar la lista de clientes
            header("Refresh:0");
        } else {
            $e = oci_error($stid);
            echo "<p>Error al eliminar el cliente: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar recursos
        oci_free_statement($stid);
    }
}

// Liberar recursos
oci_free_statement($stid);
oci_free_statement($cursor);

?>

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
</style>