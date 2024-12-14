<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##selbor';
$contraseña = '12345';

// Verificar si la sesión ya ha sido iniciada, y si no, iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Comprobar si se está añadiendo un producto al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar'])) {
        // Eliminar el producto del carrito
        $index = $_POST['eliminar'];
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
    } else {
        // Obtener los datos del producto
        $producto = $_POST['nombre_producto'];
        $cantidad = $_POST['cantidad'];  // Obtener la cantidad

        // Obtener el ID del producto desde la base de datos
        $query = "SELECT ID_PRODUCTO FROM productos WHERE NOMBRE_PRODUCTO = :producto";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, ":producto", $producto);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        $id_producto = $row['ID_PRODUCTO'];

        // Llamar al procedimiento almacenado para agregar el producto al carrito en la base de datos
        $query = "BEGIN sp_agregar_a_carrito(:p_id_carrito, :p_id_producto, :p_cantidad); END;";
        $stid = oci_parse($conn, $query);

        // Parámetros para el procedimiento almacenado
        oci_bind_by_name($stid, ":p_id_carrito", $_SESSION['id_carrito']);
        oci_bind_by_name($stid, ":p_id_producto", $id_producto);
        oci_bind_by_name($stid, ":p_cantidad", $cantidad);

        // Ejecutar el procedimiento almacenado
        oci_execute($stid);

        // Agregar el producto a la sesión
        $_SESSION['carrito'][] = [
            'producto' => $producto,
            'cantidad' => $cantidad,
            'id_producto' => $id_producto
        ];

        // Redirigir a la página de carrito o mostrar mensaje
        echo "<script>window.location.href = 'carrito.php';</script>";
    }
}

// Mostrar el carrito (esto se mantiene igual)
echo "<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-comprar {
            background-color: #28a745;
        }
        .btn-comprar:hover {
            background-color: #218838;
        }
        .btn-seguir {
            background-color: #007BFF;
        }
        .btn-seguir:hover {
            background-color: #0056b3;
        }
        .btn-eliminar {
            background-color: #dc3545;
        }
        .btn-eliminar:hover {
            background-color: #c82333;
        }
        .actions {
            text-align: center;
        }
        .empty-cart {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>";

// Mostrar el carrito
echo "<div class='container'>
        <h2>Tu Carrito de Compras</h2>";

if (count($_SESSION['carrito']) > 0) {
    echo "<table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>";

    foreach ($_SESSION['carrito'] as $index => $item) {
        echo "<tr>
                <td>" . htmlspecialchars($item['producto']) . "</td>
                <td>" . htmlspecialchars($item['cantidad']) . "</td>
                <td class='actions'>
                    <!-- Botón de Eliminar Producto -->
                    <form method='POST' action='carrito.php' style='display:inline;'>
                        <input type='hidden' name='eliminar' value='" . $index . "'>
                        <button type='submit' class='btn btn-eliminar'>Eliminar</button>
                    </form>
                </td>
              </tr>";
    }

    echo "<tr>
            <td colspan='3' style='text-align:center;'>
                <form action='realizar_compra.php' method='POST'>
                    <button type='submit' class='btn btn-comprar'>Realizar Compra</button>
                </form>
            </td>
          </tr>";

    echo "<tr>
            <td colspan='3' style='text-align:center;'>
                <form action='mostrar_inventario2.php' method='GET'>
                    <button type='submit' class='btn btn-seguir'>Seguir Comprando</button>
                </form>
            </td>
          </tr>";

    echo "</table>";
} else {
    echo "<div class='empty-cart'>No hay productos en el carrito. ¡Empieza a comprar!</div>";
}

echo "</div>";

// Cerrar la conexión
oci_close($conn);
?>
