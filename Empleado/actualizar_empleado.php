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

// Obtener el ID del empleado a editar
if (isset($_GET['id_empleado'])) {
    $id_empleado = $_GET['id_empleado'];

    // Obtener los detalles del empleado
    $query = 'BEGIN SP_GET_DETALLES_EMPLEADO(:id_empleado, :nombre, :apellido, :telefono, :id_sucursal); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_empleado", $id_empleado);
    oci_bind_by_name($stid, ":nombre", $nombre, 100);
    oci_bind_by_name($stid, ":apellido", $apellido, 100);
    oci_bind_by_name($stid, ":telefono", $telefono, 20);
    oci_bind_by_name($stid, ":id_sucursal", $id_sucursal, 10);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        // Mostrar los datos actuales en las cajas de texto
        ?>
        <form method="POST">
            <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <label for="id_sucursal">ID Sucursal:</label>
            <input type="number" id="id_sucursal" name="id_sucursal" value="<?php echo htmlspecialchars($id_sucursal); ?>" required>

            <input type="submit" name="action" value="Actualizar">
        </form>
        <?php
    } else {
        $e = oci_error($stid);
        echo "<p>Error al obtener los detalles del empleado: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
} else {
    echo "<p class='error'>ID del empleado no proporcionado.</p>";
}

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "Actualizar") {
    $id_empleado = $_POST['id_empleado'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $id_sucursal = $_POST['id_sucursal'];

    // Actualizar empleado
    $query = 'BEGIN SP_UPDATE_EMPLEADO(:id_empleado, :nombre, :apellido, :telefono, :id_sucursal); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_empleado", $id_empleado);
    oci_bind_by_name($stid, ":nombre", $nombre);
    oci_bind_by_name($stid, ":apellido", $apellido);
    oci_bind_by_name($stid, ":telefono", $telefono);
    oci_bind_by_name($stid, ":id_sucursal", $id_sucursal);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        echo "<p class='message'>Empleado actualizado con éxito.</p>";
    } else {
        $e = oci_error($stid);
        echo "<p>Error al actualizar el empleado: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
}

// Cerrar la conexión\oci_close($conn);
?>

<!-- Opciones de estilos básicos -->
<style>
    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="number"], textarea {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .message {
        color: green;
        font-weight: bold;
        text-align: center;
    }

    .error {
        color: red;
        font-weight: bold;
        text-align: center;
    }
</style>
