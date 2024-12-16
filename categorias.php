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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Insertar Categoría</title>
    <style>
         body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        
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
        .btn-delete {
            background-color: #e74c3c; /* Rojo original */
            color: #fff; /* Color del texto */
            border: none; /* Sin bordes */
            padding: 8px 12px;
            cursor: pointer; /* Cursor de mano */
            transition: background-color 0.2s ease; /* Suaviza el cambio de color */
        }

        .btn-delete:active {
            background-color: #f08070; /* Rojo más claro al presionar */
        }

    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://www.instagram.com/gamba.store/?hl=es-la">Gamba Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/sistema_gestion_tienda.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/categorias.php">Categorias</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Productos
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/insertar_productos.php">Agregar productos</a></li>
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/mostrar_inventario.php">Mostrar inventario</a></li>
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/actualizar_producto.php">Actualizar producto</a></li>
        </ul>
    </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sucursales
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Agregar Sucursales</a></li>
            <li><a class="dropdown-item" href="#">Mostrar Sucursales</a></li>
            <li><a class="dropdown-item" href="#">Actualizar Sucursales</a></li>
          </ul>
          </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Clientes
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/actualizar_cliente.php">Actualizar clientes</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/mostrar_clientes.php">Mostrar clientes</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/insertar_clientes.php">Insertar clientesliente</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Empleados
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/actualizar_empleado.php">Actualizar empleados</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/mostrar_empleados.php">Mostrar empleados</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/insertar_empleados.php">Insertar empleados</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Proveedores
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/actualizar_proveedor.php">Actualizar proveedor</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/mostrar_proveedor.php">Mostrar proveedor</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/insertar_proveedor.php">Insertar proveedor</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sucursales
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/actualizar_sucursal.php">Actualizar sucursal</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/mostrar_sucursal.php">Mostrar sucursal</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/insertar_sucursal.php">Insertar sucursal</a></li>
            </ul>
        </li>
</ul>
    </div>
    <div class="d-flex align-items-center">
      <!-- Información de usuario -->
      <span class="user-info me-3"><?php echo "Correo: $usuario"; ?></span>
      <!-- Botón de salir -->
      <a href="logout.php" class="btn logout-btn">Salir</a>
    </div>
  </div>
</nav>

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

    $host = 'localhost';
    $puerto = '1521'; // Cambia si usas un puerto diferente
    $sid = 'ORCL'; // SID de la base de datos Oracle
    $usuario = 'PROYECTOSC504'; // Usuario de la base de datos
    $contraseña = '1234567'; // Contraseña del usuario

    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) {
        $e = oci_error();
        echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
        exit;
    }

// Eliminar una categoría si se presionó el botón Eliminar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_categoria'])) 
    {
        $id_categoria = $_POST['id_categoria'];
        // Llamada al procedimiento almacenado para eliminar la categoría
        $query = 'BEGIN SP_DELETE_CATEGORIA(:id_categoria); END;';
        $stid = oci_parse($conn, $query);
        
        // Enlazar el parámetro
        oci_bind_by_name($stid, ':id_categoria', $id_categoria);

        // Ejecutar la consulta
        if (oci_execute($stid))
        {
            echo "<p class='message'>La categoría con ID $id_categoria fue eliminada con éxito.</p>";
        } 
        else 
        {
             
            $e = oci_error($stid);
            echo "<p class='error'>Error al eliminar la categoría: " . htmlentities($e['message']) . "</p>";
        }
            
        oci_free_statement($stid);
    }    

    // Obtener la lista de categorías
    $query = "SELECT ID_CATEGORIA, NOMBRE_CATEGORIA, DESCRIPCION FROM CATEGORIAS";
    $stid = oci_parse($conn, $query);

    // Ejecutar la consulta
    if (oci_execute($stid)) 
    {
        echo "<br/>";
        echo "<br/>"; 
        echo "<h1>Lista de Categorías</h1>";
        
    
        echo "<table border='1' cellspacing='0' cellpadding='10'>";
        echo "<tr><th>ID Categoría</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr>";

        

        
        while ($row = oci_fetch_assoc($stid)) 
        {
                
        
            echo "<tr>";             
            echo "<td>" . htmlspecialchars($row['ID_CATEGORIA']) . "</td>";
                    
            echo "<td>" . htmlspecialchars($row['NOMBRE_CATEGORIA']) . "</td>";    
            echo "<td>" . htmlspecialchars($row['DESCRIPCION']) . "</td>";
                // Agregar botones de acción (eliminar y actualizar)
            echo "<td>";
            echo "<form method='POST' style='display: inline;'>";  
            echo "<input type='hidden' name='id_categoria' value='" . htmlspecialchars($row['ID_CATEGORIA']) . "'>";
            echo "<button type='submit' class='btn btn-delete' name='eliminar_categoria' onclick='return confirm(\"¿Seguro que quieres eliminar esta categoría?\");' class='btn btn-delete'>Eliminar</button>";
            echo "</form>";
            echo "</td>";        
            echo "</tr>";
        }
        echo "</table>";
    } 
    else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al obtener las categorías: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recursos y cerrar la conexión
    oci_free_statement($stid);
    oci_close($conn);



    ?>
    <!-- Bootstrap Bundle con Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>