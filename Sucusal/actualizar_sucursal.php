<?php
include_once('../config.php'); // Configuración
include_once($_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/navbar.php'); // Navbar
?>


<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##ANDERSON';
$contraseña = '12345';

$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    echo "<p class='error'>Error al conectar con la base de datos.</p>";
    exit;
}

// Obtener detalles de la sucursal
if (isset($_GET['id_sucursal'])) {
    $id_sucursal = $_GET['id_sucursal'];

    $query = 'BEGIN SP_GET_DETALLES_SUCURSAL(:id_sucursal, :nombre, :direccion, :telefono); END;';
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":id_sucursal", $id_sucursal);
    oci_bind_by_name($stid, ":nombre", $nombre, 100);
    oci_bind_by_name($stid, ":direccion", $direccion, 200);
    oci_bind_by_name($stid, ":telefono", $telefono, 15);

    oci_execute($stid);

    ?>
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="id_sucursal" value="<?php echo $id_sucursal; ?>">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($direccion); ?></textarea>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            </div>

            <div class="form-group action-buttons">
                <input type="submit" name="action" value="Actualizar" class="btn btn-primary">
                <a href="mostrar_sucursal.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    <?php

    oci_free_statement($stid);
} else {
    echo "<p class='error'>ID de sucursal no proporcionado.</p>";
}

// Procesar el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "Actualizar") {
    $id_sucursal = $_POST['id_sucursal'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $query = 'BEGIN SP_UPDATE_SUCURSAL(:id_sucursal, :nombre, :direccion, :telefono); END;';
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":id_sucursal", $id_sucursal);
    oci_bind_by_name($stid, ":nombre", $nombre);
    oci_bind_by_name($stid, ":direccion", $direccion);
    oci_bind_by_name($stid, ":telefono", $telefono);

    $result = oci_execute($stid);

    if ($result) {
        echo "<p class='message'>Sucursal actualizada con éxito.</p>";
        echo "<script>window.location.href='mostrar_sucursal.php';</script>";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al actualizar la sucursal: " . htmlentities($e['message']) . "</p>";
    }

    oci_free_statement($stid);
}

oci_close($conn);
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 300px;
        max-width: 90%;
        margin: 20px auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
        outline: none;
    }
    textarea {
        resize: vertical;
    }
    .action-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }
    .btn {
        padding: 10px 15px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
    }
    .btn-primary {
        background-color: #007bff;
        color: #ffffff;
        border: none;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: #ffffff;
        border: none;
    }
    .message, .error {
        text-align: center;
        font-size: 16px;
        margin-top: 15px;
        padding: 10px;
        border-radius: 5px;
    }
    .message {
        background-color: #d4edda;
        color: #155724;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
