<!-- <?php
session_start();

$admin = $_SESSION['admin'];
$rol=$_SESSION['rol'];

?> -->


<?php
  // Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521'; // Cambia si usas un puerto diferente
$sid = 'ORCL'; // SID de la base de datos Oracle
$usuario = 'PROYECTOSC504'; // Usuario de la base de datos
$contraseña = '1234567'; // Contraseña del usuario

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if ($conn) {
    echo "<p class='success'>Conexión a la base de datos realizada con éxito.</p>";
} else {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Obtener el ID del cliente a editar
if (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente'];

    // Obtener los detalles del cliente
    $query = 'BEGIN SP_GET_DETALLES_CLIENTE(:id_cliente, :nombre, :apellido, :email, :direccion, :telefono); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_cliente", $id_cliente);
    oci_bind_by_name($stid, ":nombre", $nombre, 100);
    oci_bind_by_name($stid, ":apellido", $apellido, 100);
    oci_bind_by_name($stid, ":email", $email, 100);
    oci_bind_by_name($stid, ":direccion", $direccion, 200);
    oci_bind_by_name($stid, ":telefono", $telefono, 20);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        // Mostrar los datos actuales en las cajas de texto
        ?>
        <form method="POST">
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="direccion">Dirección:</label>
            <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($direccion); ?></textarea>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <input type="submit" name="action" value="Actualizar">
        </form>
        <?php
    } else {
        $e = oci_error($stid);
        echo "<p>Error al obtener los detalles del cliente: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
} else {
    echo "<p class='error'>ID del cliente no proporcionado.</p>";
}

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "Actualizar") {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Actualizar cliente
    $query = 'BEGIN SP_UPDATE_CLIENTE(:id_cliente, :nombre, :apellido, :email, :direccion, :telefono); END;';
    $stid = oci_parse($conn, $query);

    // Enlazar los parámetros
    oci_bind_by_name($stid, ":id_cliente", $id_cliente);
    oci_bind_by_name($stid, ":nombre", $nombre);
    oci_bind_by_name($stid, ":apellido", $apellido);
    oci_bind_by_name($stid, ":email", $email);
    oci_bind_by_name($stid, ":direccion", $direccion);
    oci_bind_by_name($stid, ":telefono", $telefono);

    // Ejecutar consulta
    $result = oci_execute($stid);

    if ($result) {
        echo "<p class='message'>Cliente actualizado con éxito.</p>";
    } else {
        $e = oci_error($stid);
        echo "<p>Error al actualizar el cliente: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recurso
    oci_free_statement($stid);
}
?>

<!-- Opciones de estilos básicos -->
<style>
    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="email"], textarea {
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