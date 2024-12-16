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
    </div>
  </div>
</nav>
    <?php
    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $puerto = '1521';
    $sid = 'ORCL';
    $usuario = 'PROYECTOSC504';
    $contraseña = '1234567';

    // Crear la conexión
    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");
    if (!$conn) {
        $e = oci_error();
        die("Error al conectar con la base de datos: " . htmlentities($e['message']));
    }

    // Función para cargar datos desde procedimientos almacenados
    function cargarOpciones($conn, $sp_name, $id_field, $name_field) 
    {
        $query = "BEGIN $sp_name(:cursor); END;";
        $stid = oci_parse($conn, $query);

        // Definir el cursor de salida
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stid, ":cursor", $cursor, -1, OCI_B_CURSOR);

        // Ejecutar el procedimiento
        oci_execute($stid);
        oci_execute($cursor);

        // Inicializar la variable para las opciones
        $options = "";
        
        // Verificar si el cursor tiene resultados
        if ($cursor)
         {
            // Recorrer los resultados y crear las opciones
            while ($row = oci_fetch_assoc($cursor)) {
                $options .= "<option value='" . htmlspecialchars($row[$id_field]) . "'>" . htmlspecialchars($row[$name_field]) . "</option>";
            }
        } else {
            $options = "<option disabled>No se encontraron resultados</option>";
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_free_statement($cursor);
        return $options;
    }

    // Cargar opciones para cada dropdown
    $categorias = cargarOpciones($conn, 'sp_get_categorias', 'ID_CATEGORIA', 'NOMBRE_CATEGORIA');
    $proveedores = cargarOpciones($conn, 'sp_get_proveedores', 'ID_PROVEEDOR', 'NOMBRE');
    $sucursales = cargarOpciones($conn, 'sp_get_sucursales', 'ID_SUCURSAL', 'NOMBRE');

    // Cerrar conexión
    oci_close($conn);
    ?>

<body>
    <h1 style="text-align: center;">Insertar Producto</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="id_categoria">Categoría:</label>
        <select id="id_categoria" name="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php echo $categorias; ?>
        </select>

        <label for="id_proveedor">Proveedor:</label>
        <select id="id_proveedor" name="id_proveedor" required>
            <option value="">Seleccione un proveedor</option>
            <?php echo $proveedores; ?>
        </select>

        <label for="id_sucursal">Sucursal:</label>
        <select id="id_sucursal" name="id_sucursal" required>
            <option value="">Seleccione una sucursal</option>
            <?php echo $sucursales; ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <button type="submit" name="submit">Insertar Producto</button>
    </form>

    <?php
    // Procesamiento del formulario (igual que antes)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");
        if (!$conn) {
            $e = oci_error();
            echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
            exit;
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_sucursal = $_POST['id_sucursal'];
        $cantidad = $_POST['cantidad'];

        $query = 'BEGIN sp_add_producto(:nombre, :descripcion, :precio, :id_categoria, :id_proveedor, :id_sucursal, :cantidad); END;';
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ':nombre', $nombre);
        oci_bind_by_name($stid, ':descripcion', $descripcion);
        oci_bind_by_name($stid, ':precio', $precio);
        oci_bind_by_name($stid, ':id_categoria', $id_categoria);
        oci_bind_by_name($stid, ':id_proveedor', $id_proveedor);
        oci_bind_by_name($stid, ':id_sucursal', $id_sucursal);
        oci_bind_by_name($stid, ':cantidad', $cantidad);

        $result = oci_execute($stid);

        if ($result) {
            echo "<p class='message'>Producto insertado con éxito.</p>";
        } else {
            $e = oci_error($stid);
            echo "<p class='error'>Error al insertar el producto: " . htmlentities($e['message']) . "</p>";
        }

        oci_free_statement($stid);
        oci_close($conn);
    }
    ?>
</body>



    <!-- <h1 style="text-align: center;">Insertar Producto</h1>
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
    
     Bootstrap Bundle con Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html>
