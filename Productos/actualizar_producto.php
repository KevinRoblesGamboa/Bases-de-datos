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
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Obtener el ID del producto a editar
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Obtener los detalles del producto
    $query = 'BEGIN sp_get_detalles_producto(:id_producto, :nombre, :descripcion, :precio, :id_categoria, :id_proveedor); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_producto", $id_producto);
    oci_bind_by_name($stid, ":nombre", $nombre, 100);
    oci_bind_by_name($stid, ":descripcion", $descripcion, 255);
    oci_bind_by_name($stid, ":precio", $precio, 10);
    oci_bind_by_name($stid, ":id_categoria", $id_categoria, 10);
    oci_bind_by_name($stid, ":id_proveedor", $id_proveedor, 10);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        // Mostrar los datos actuales en las cajas de texto
        ?>
        <form method="POST">
            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required step="0.01">

            <label for="id_categoria">ID Categoría:</label>
            <input type="number" id="id_categoria" name="id_categoria" value="<?php echo htmlspecialchars($id_categoria); ?>" required>

            <label for="id_proveedor">ID Proveedor:</label>
            <input type="number" id="id_proveedor" name="id_proveedor" value="<?php echo htmlspecialchars($id_proveedor); ?>" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>" required>

            <input type="submit" name="action" value="ActualizarProducto">
        </form>
        <?php
    } else {
        $e = oci_error($stid);
        echo "<p>Error al obtener los detalles del producto: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
} else {
    echo "<p class='error'>ID del producto no proporcionado.</p>";
}

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "ActualizarProducto") {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['id_categoria'];
    $id_proveedor = $_POST['id_proveedor'];
    $cantidad = $_POST['cantidad']; // nueva variable para la cantidad

    // Actualizar en la tabla PRODUCTOS
    $query_producto = 'BEGIN sp_update_producto(:id_producto, :nombre, :descripcion, :precio, :id_categoria, :id_proveedor); END;';
    $stid_producto = oci_parse($conn, $query_producto);

    // Enlazar los parámetros para el producto
    oci_bind_by_name($stid_producto, ":id_producto", $id_producto);
    oci_bind_by_name($stid_producto, ":nombre", $nombre);
    oci_bind_by_name($stid_producto, ":descripcion", $descripcion);
    oci_bind_by_name($stid_producto, ":precio", $precio);
    oci_bind_by_name($stid_producto, ":id_categoria", $id_categoria);
    oci_bind_by_name($stid_producto, ":id_proveedor", $id_proveedor);

    // Ejecutar consulta para producto
    $result_producto = oci_execute($stid_producto);

    if (!$result_producto) {
        $e = oci_error($stid_producto);
        echo "<p>Error al actualizar el producto: " . htmlentities($e['message']) . "</p>";
    } else {
        // Actualizar en la tabla INVENTARIO
        $query_inventario = 'BEGIN sp_update_inventario(:id_producto, :cantidad); END;';
        $stid_inventario = oci_parse($conn, $query_inventario);

        // Enlazar los parámetros para el inventario
        oci_bind_by_name($stid_inventario, ":id_producto", $id_producto);
        oci_bind_by_name($stid_inventario, ":cantidad", $cantidad);

        // Ejecutar consulta para inventario
        $result_inventario = oci_execute($stid_inventario);

        if ($result_inventario) {
            echo "<p class='message'>Producto y cantidad actualizados correctamente.</p>";
        } else {
            $e = oci_error($stid_inventario);
            echo "<p>Error al actualizar la cantidad en el inventario: " . htmlentities($e['message']) . "</p>";
        }
    }

    // Liberar recursos
    oci_free_statement($stid_producto);
    oci_free_statement($stid_inventario);
}
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
