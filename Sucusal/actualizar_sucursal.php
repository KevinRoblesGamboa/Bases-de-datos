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
    <form method="POST">
        <input type="hidden" name="id_sucursal" value="<?php echo $id_sucursal; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($direccion); ?></textarea>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

        <input type="submit" name="action" value="Actualizar">
    </form>
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
        echo "<p class='error'>Error al actualizar la sucursal.</p>";
    }

    oci_free_statement($stid);
}

oci_close($conn);
?>

<style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .mensaje {
            text-align: center;
            font-size: 18px;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            color: green;
        }
        .error {
            text-align: center;
            font-size: 18px;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            color: red;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>