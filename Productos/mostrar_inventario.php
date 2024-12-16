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
    <title>Mostrar Sucursales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Opciones de estilos avanzados -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
        }
        .user-info {
            font-size: 14px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        h2 {
            color: #007bff; /* Color de los títulos */
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            text-align: center;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            color: white;
            cursor: pointer;
            margin: 2px;
            border-radius: 4px;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-update {
            background-color: #3498db;
        }
        .btn-update:hover {
            background-color: #2980b9;
        }
        .redirect-button {
            display: inline-block;
            margin: 10px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }
        .redirect-button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            width: 60%;
            margin: 10px auto;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .message.warning {
            background-color: #fff3cd; /* Amarillo claro */
            color: #856404; /* Color del texto */
            border: 1px solid #ffeeba; /* Borde amarillo suave */
            padding: 10px; /* Espaciado interno */
            margin: 10px auto; /* Centrado horizontal */
            border-radius: 5px; /* Bordes redondeados */
            font-family: Arial, sans-serif; /* Fuente opcional */
            width: 50%; /* Ancho del mensaje */
            text-align: center; /* Centrar el texto */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Opcional: sombra */
        }
        .navbar-brand {
    color: #28a745;
}
    </style>
</head>

<body>

<!-- Navbar con menú y submenú -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://www.instagram.com/gamba.store/?hl=es-la">Gamba Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/sistema_clientes.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/bases-de-datos/Productos/mostrar_inventario.php">Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="http://localhost/bases-de-datos/Sucusal/mostrar_sucursal.php">Sucursales </a>
        </li>
        
      </ul>
    </div>

    <div class="d-flex align-items-center">
      <!-- Información de usuario -->
      <span class="user-info me-3"><?php echo "Correo: $usuario"; ?></span>
    </div>
  </div>

</nav>
</body>

<h1>Lista de productos</h1>

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

// Verificar si se ha pasado el ID_INVENTARIO para eliminar
if (isset($_POST['eliminar'])) {
    $id_inventario = $_POST['id_inventario'];

    // Preparar la consulta de eliminación
    $query = "BEGIN SP_DELETE_INVENTARIO(:id_inventario); END;";
    $stid = oci_parse($conn, $query);

    // Enlazar el parámetro
    oci_bind_by_name($stid, ':id_inventario', $id_inventario);

    // Ejecutar la consulta
    $result = oci_execute($stid);

    if ($result) {
        echo "<p>El registro con ID Inventario $id_inventario ha sido eliminado correctamente.</p>";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al eliminar el registro: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar el recurso
    oci_free_statement($stid);
}

// Preparar el procedimiento almacenado
$query = 'BEGIN sp_get_all_inventario(:p_cursor); END;';
$stid = oci_parse($conn, $query);

// Declarar un cursor de salida
$p_cursor = oci_new_cursor($conn);

// Enlazar el cursor al parámetro de salida
oci_bind_by_name($stid, ':p_cursor', $p_cursor, -1, OCI_B_CURSOR);

// Ejecutar el procedimiento almacenado
if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<p class='error'>Error al ejecutar el procedimiento almacenado: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Ejecutar el cursor
if (!oci_execute($p_cursor)) {
    $e = oci_error($p_cursor);
    echo "<p class='error'>Error al ejecutar el cursor: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Mostrar los resultados en una tabla
echo "<table>
        <tr>
            <th>ID Inventario</th>
            <th>Nombre de Sucursal</th>
            <th>ID Producto</th>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
        </tr>";

// Recorrer los registros y mostrarlos en la tabla
while ($row = oci_fetch_assoc($p_cursor)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ID_INVENTARIO']) . "</td>
            <td>" . htmlspecialchars($row['NOMBRE_SUCURSAL']) . "</td>
            <td>" . htmlspecialchars($row['ID_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['NOMBRE_PRODUCTO']) . "</td>
            <td>" . htmlspecialchars($row['CANTIDAD']) . "</td>
            <td>" . htmlspecialchars($row['ULTIMA_ACTUALIZACION']) . "</td>
            <td>
                <!-- Botón de Eliminar -->
                <form method='POST' action=''>
                    <input type='hidden' name='id_inventario' value='" . htmlspecialchars($row['ID_INVENTARIO']) . "'>
                    <input type='submit' name='eliminar' value='Eliminar' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este registro?\")'>
                </form>
                <!-- Botón de Actualizar -->
                <form method='GET' action='actualizar_producto.php'>
                    <input type='hidden' name='id_producto' value='" . htmlspecialchars($row['ID_PRODUCTO']) . "'>
                    <input type='submit' value='Actualizar'>
                </form>
            </td>
          </tr>";
}

echo "</table>";

// Botón para ver sucursales con productos
echo "<form method='GET' action='mostrar_sucursales_productos.php'>
        <input type='submit' value='Mostrar Sucursales con Productos'>
      </form>";

// Liberar recursos
oci_free_statement($stid);
oci_free_statement($p_cursor);

// Cerrar la conexión
oci_close($conn);
?>