<!-- <?php
session_start();

$admin = $_SESSION['admin'];
$rol=$_SESSION['rol'];

?> -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
    <style>
        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
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
</head>
<body>

    <h1 style="text-align: center;">Registrar Cliente</h1>

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
    
    // Verificar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        // Preparar la llamada al procedimiento almacenado
        $query = 'BEGIN SP_CREATE_CLIENTE(:nombre, :apellido, :email, :direccion, :telefono); END;';
        $stid = oci_parse($conn, $query);

        if (!$stid) {
            $e = oci_error($conn);
            echo "<p class='error'>Error al preparar la consulta: " . htmlentities($e['message']) . "</p>";
            exit;
        }

        // Enlazar parámetros a la consulta
        oci_bind_by_name($stid, ":nombre", $nombre);
        oci_bind_by_name($stid, ":apellido", $apellido);
        oci_bind_by_name($stid, ":email", $email);
        oci_bind_by_name($stid, ":direccion", $direccion);
        oci_bind_by_name($stid, ":telefono", $telefono);

        // Ejecutar consulta
        $result = oci_execute($stid);

        if ($result) {
            echo "<p class='message'>Cliente registrado con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al registrar el cliente: " . htmlentities($e['message']) . "</p>";
        }

        // Liberar recursos
        oci_free_statement($stid);
    }

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Formulario HTML -->
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion"></textarea>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <input type="submit" value="Registrar Cliente">
    </form>

</body>
</html>