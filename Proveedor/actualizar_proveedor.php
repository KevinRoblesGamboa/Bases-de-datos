<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>

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

// Obtener el ID del proveedor a editar
if (isset($_GET['id_proveedor'])) {
    $id_proveedor = $_GET['id_proveedor'];

    // Obtener los detalles del proveedor
    $query = 'BEGIN SP_GET_DETALLES_PROVEEDOR(:id_proveedor, :nombre, :contacto, :telefono, :direccion); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_proveedor", $id_proveedor);
    oci_bind_by_name($stid, ":nombre", $nombre, 100);
    oci_bind_by_name($stid, ":contacto", $contacto, 100);
    oci_bind_by_name($stid, ":telefono", $telefono, 20);
    oci_bind_by_name($stid, ":direccion", $direccion, 200);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        // Mostrar los datos actuales en las cajas de texto
        ?>
        <form method="POST">
            <input type="hidden" name="id_proveedor" value="<?php echo $id_proveedor; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="contacto">Contacto:</label>
            <input type="text" id="contacto" name="contacto" value="<?php echo htmlspecialchars($contacto); ?>">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <label for="direccion">Dirección:</label>
            <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($direccion); ?></textarea>

            <input type="submit" name="action" value="Actualizar">
        </form>
        <?php
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al obtener los detalles del proveedor: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
} else {
    echo "<p class='error'>ID del proveedor no proporcionado.</p>";
}

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "Actualizar") {
    $id_proveedor = $_POST['id_proveedor'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Actualizar proveedor
    $query = 'BEGIN SP_UPDATE_PROVEEDOR(:id_proveedor, :nombre, :contacto, :telefono, :direccion); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_proveedor", $id_proveedor);
    oci_bind_by_name($stid, ":nombre", $nombre);
    oci_bind_by_name($stid, ":contacto", $contacto);
    oci_bind_by_name($stid, ":telefono", $telefono);
    oci_bind_by_name($stid, ":direccion", $direccion);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        // Redirigir a la página de mostrar
        header("Location: mostrar_proveedor.php");
        exit;
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al actualizar el proveedor: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
}

// Cerrar conexión
oci_close($conn);
?>

<!-- Opciones de estilos básicos -->
<style>
    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], textarea {
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