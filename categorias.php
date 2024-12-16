<!-- <?php
session_start();

$usuario = $_SESSION['usuario'];
$rol=$_SESSION['rol'];

?> -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Categoría</title>
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
        input, textarea {
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
    <h1 style="text-align: center;">Insertar Categoría</h1>
    <form method="POST" action="">
        <label for="id_categoria">ID Categoría:</label>
        <input type="number" id="id_categoria" name="id_categoria" required>

        <label for="nombre_categoria">Nombre de la Categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <button type="submit" name="submit">Insertar Categoría</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
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


        // Recibir datos del formulario
        $id_categoria = $_POST['id_categoria'];
        $nombre_categoria = $_POST['nombre_categoria'];
        $descripcion = $_POST['descripcion'];

        //validacion de la cateogoria
        $check_query = "SELECT COUNT(*) AS TOTAL FROM CATEGORIAS WHERE NOMBRE_CATEGORIA = :nombre_categoria";
        $stid_check = oci_parse($conn, $check_query);
        // Enlazar el parámetro
        oci_bind_by_name($stid_check, ':nombre_categoria', $nombre_categoria);

        // Ejecutar la consulta
        oci_execute($stid_check);

        $row = oci_fetch_assoc($stid_check);
        $total = $row['TOTAL'];
        if ($total > 0) {
            // Si la categoría ya existe
            

            echo "<p class='error'>Error: La categoría '$nombre_categoria' ya existe en la base de datos.</p>";
        }
        else 
        {



            // Llamada al procedimiento almacenado para insertar la categoría
            $query = 'BEGIN sp_insert_categoria(:id_categoria, :nombre_categoria, :descripcion); END;';
            $stid = oci_parse($conn, $query);

            // Enlazar los parámetros
            oci_bind_by_name($stid, ':id_categoria', $id_categoria);
            oci_bind_by_name($stid, ':nombre_categoria', $nombre_categoria);
            oci_bind_by_name($stid, ':descripcion', $descripcion);

            // Ejecutar el procedimiento
            $result = oci_execute($stid);

            if ($result) {
                echo "<p class='message'>Categoría insertada con éxito.</p>";
            } else {
                $e = oci_error($stid);
                echo "<p class='error'>Error al insertar la categoría: " . htmlentities($e['message']) . "</p>";
            }
            oci_free_statement($stid);

        }
        oci_free_statement($stid_check);
        oci_close($conn);
    }
    ?>
</body>
</html>