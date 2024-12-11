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

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "Actualizar") {
    $id_sucursal = $_POST['id_sucursal'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $ultima_actualizacion = $_POST['ultima_actualizacion'];

    // Llamar al procedimiento para actualizar el inventario
    $query = 'BEGIN sp_update_inventario(:id_sucursal, :id_producto, :cantidad, :ultima_actualizacion); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_sucursal", $id_sucursal);
    oci_bind_by_name($stid, ":id_producto", $id_producto);
    oci_bind_by_name($stid, ":cantidad", $cantidad);
    oci_bind_by_name($stid, ":ultima_actualizacion", $ultima_actualizacion);

    // Ejecutar la actualización
    $result = oci_execute($stid);

    if ($result) {
        echo "<p class='message'>Inventario actualizado con éxito.</p>";
    } else {
        $e = oci_error($stid);
        echo "<p>Error al actualizar el inventario: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
}
?>

<!-- Formulario para actualizar el inventario -->
<form method="POST">
    <label for="id_sucursal">ID Sucursal:</label>
    <input type="number" id="id_sucursal" name="id_sucursal" required>

    <label for="id_producto">ID Producto:</label>
    <input type="number" id="id_producto" name="id_producto" required>

    <label for="cantidad">Cantidad:</label>
    <input type="number" id="cantidad" name="cantidad" required>

    <label for="ultima_actualizacion">Última Actualización:</label>
    <input type="text" id="ultima_actualizacion" name="ultima_actualizacion" required>

    <input type="submit" name="action" value="Actualizar">
</form>

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
