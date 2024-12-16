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
<body>
    <h1>Lista de Sucursales</h1>

    <?php
    
    
    // Configuración de la conexión a la base de datos
    
    
    $host = 'localhost';
    $puerto = '1521'; // Cambia si usas un puerto diferente
    $sid = 'ORCL'; // SID de la base de datos Oracle
    $usuario = 'PROYECTOSC504'; // Usuario de la base de datos
    $contraseña = '1234567'; // Contraseña del usuario

    $user2 =$_SESSION['usuario'] ;
    $rol2=$_SESSION['rol'];

    // Crear la conexión
    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) {
        $e = oci_error();
        echo "<div class='message error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</div>";
        exit;
    }

    // Manejar eliminación de una sucursal
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sucursal'])) {
        $id_sucursal = $_POST['id_sucursal'];

        // Preparar la consulta para verificar si la sucursal tiene empleados
        $query = "SELECT COUNT(*) AS total FROM Empleados WHERE ID_SUCURSAL = :id_sucursal";
        $stmt_total = oci_parse($conn, $query);

        oci_bind_by_name($stmt_total, ':id_sucursal', $id_sucursal);

        // Ejecutar la consulta
        if (oci_execute($stmt_total)) 
        {
            // Recuperar el resultado
            $row = oci_fetch_assoc($stmt_total);
            $total_empleados = $row['TOTAL'];

            // Validar si hay empleados en la sucursal
            if ($total_empleados > 0) 
            {
                echo "<div class='message warning'>Sucursal con ID $id_sucursal tiene empleados asignados: $total_empleados.</div>";
                //echo "La sucursal :" . htmlspecialchars($name_sucursal) . " tiene empleados asignados: " . $total_empleados . "<br>";
            }
            else 
            {
                $delete_stid = oci_parse($conn, 'BEGIN SP_DELETE_SUCURSAL(:id_sucursal); END;');
                oci_bind_by_name($delete_stid, ':id_sucursal', $id_sucursal);
        
                if (oci_execute($delete_stid)) 
                {
                    echo "<div class='message success'>Sucursal con ID $id_sucursal eliminada correctamente.</div>";
                } 
                else 
                {
                    $e = oci_error($delete_stid);
                    echo "<div class='message error'>Error al eliminar la sucursal: " . htmlentities($e['message']) . "</div>";
                }    
                oci_free_statement($delete_stid);
            }
        } 
        else 
        {
            // Manejar errores en la consulta
            $e = oci_error($stmt_total);
            echo "Error al ejecutar la consulta: " . htmlentities($e['message']);
        }

        // Liberar recursos
        oci_free_statement($stmt_total);

    }


    // Obtener la lista de sucursales
    $query = 'BEGIN SP_GET_SUCURSAL(:cursor); END;';
    $stid = oci_parse($conn, $query);

    // Crear un cursor para los resultados
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stid, ":cursor", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento
    if (oci_execute($stid) && oci_execute($cursor)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>";


        while ($row = oci_fetch_assoc($cursor)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ID_SUCURSAL']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NOMBRE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DIRECCION']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TELEFONO']) . "</td>";

            // Validación de roles antes de mostrar los botones
            if ($rol2 == 'admin') {
                echo "<td class='actions'>";
                // Mostrar el botón de Eliminar para el rol admin
                echo "<form method='POST' style='display: inline;'>";
                echo "<input type='hidden' name='id_sucursal' value='" . htmlspecialchars($row['ID_SUCURSAL']) . "'>";
                echo "<button type='submit' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro de eliminar esta sucursal?\");'>Eliminar</button>";
                echo "</form>";
        
                // Mostrar el botón de Actualizar para el rol admin
                echo "<a href='actualizar_sucursal.php?id_sucursal=" . urlencode($row['ID_SUCURSAL']) . "' class='btn btn-update'>Actualizar</a>";
            } elseif ($rol2 == 'cliente') {
             
            }
        
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
    }
    else 
    {
        $e = oci_error($stid);
        echo "<div class='message error'>Error al obtener la lista de sucursales: " . htmlentities($e['message']) . "</div>";
    }

    // Liberar recursos
    oci_free_statement($stid);
    oci_free_statement($cursor);

    // Cerrar la conexión
    oci_close($conn);
    ?>

    <!-- Botones de redirección -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="verifica_empleados_sucursal.php" class="redirect-button">Verificar empleados por sucursal</a>
        
    </div>
</body>
</html>
