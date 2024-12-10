<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Producto</title>
    <style>
        form {
            width: 50%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            font-size: 18px;
            color: green;
        }
        .error {
            text-align: center;
            font-size: 18px;
            color: red;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Insertar Producto</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="id_categoria">ID Categoría:</label>
        <input type="number" id="id_categoria" name="id_categoria" required>

        <label for="id_proveedor">ID Proveedor:</label>
        <input type="number" id="id_proveedor" name="id_proveedor" required>

        <label for="id_sucursal">ID Sucursal:</label>
        <input type="number" id="id_sucursal" name="id_sucursal" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <button type="submit" name="submit">Insertar Producto</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        // Configuración de la conexión
        $host = 'localhost';
        $puerto = '1521';
        $sid = 'ORCL';
        $usuario = 'c##selbor';
        $contraseña = '12345';

        // Conexión a Oracle
        $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

        if (!$conn) {
            $e = oci_error();
            echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
            exit;
        }

        // Recibir datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_sucursal = $_POST['id_sucursal'];
        $cantidad = $_POST['cantidad'];

        // Llamada al procedimiento almacenado
        $query = 'BEGIN sp_add_producto(:nombre, :descripcion, :precio, :id_categoria, :id_proveedor, :id_sucursal, :cantidad); END;';
        $stid = oci_parse($conn, $query);

        // Enlazar parámetros
        oci_bind_by_name($stid, ':nombre', $nombre);
        oci_bind_by_name($stid, ':descripcion', $descripcion);
        oci_bind_by_name($stid, ':precio', $precio);
        oci_bind_by_name($stid, ':id_categoria', $id_categoria);
        oci_bind_by_name($stid, ':id_proveedor', $id_proveedor);
        oci_bind_by_name($stid, ':id_sucursal', $id_sucursal);
        oci_bind_by_name($stid, ':cantidad', $cantidad);

        // Ejecutar el procedimiento
        $result = oci_execute($stid);

        if ($result) {
            echo "<p class='message'>Producto insertado con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al insertar el producto: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar recursos y cerrar conexión
        oci_free_statement($stid);
        oci_close($conn);
    }
    ?>
</body>
</html>
