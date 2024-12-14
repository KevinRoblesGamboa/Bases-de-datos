<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##ANDERSON';
$contraseña = '12345';

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Incluir estilos CSS
echo "<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>";

// Mostrar los totales por sucursal
echo "<h2>Totales por Sucursal (ID 1 - 30)</h2>";
echo "<table>
        <tr>
            <th>ID Sucursal</th>
            <th>Total de Productos</th>
        </tr>";

// Iterar sobre los ID de las sucursales del 1 al 30
for ($id_sucursal = 1; $id_sucursal <= 30; $id_sucursal++) {
    // Preparar la llamada a la función
    $sql_total = "BEGIN :total := FN_TOTAL_INVENTARIO_SUCURSAL(:id_sucursal); END;";
    $stmt_total = oci_parse($conn, $sql_total);

    // Declarar variables
    oci_bind_by_name($stmt_total, ':id_sucursal', $id_sucursal);
    oci_bind_by_name($stmt_total, ':total', $total_productos, 32);

    // Ejecutar la función
    if (oci_execute($stmt_total)) {
        echo "<tr>
                <td>" . htmlspecialchars($id_sucursal) . "</td>
                <td>" . htmlspecialchars($total_productos) . "</td>
              </tr>";
    } else {
        $e = oci_error($stmt_total);
        echo "<tr>
                <td>" . htmlspecialchars($id_sucursal) . "</td>
                <td class='error'>Error: " . htmlentities($e['message']) . "</td>
              </tr>";
    }

    // Liberar recursos de la declaración
    oci_free_statement($stmt_total);
}

echo "</table>";

// Botón para ver sucursales con productos
echo "<form method='GET' action='mostrar_inventario.php'>
        <input type='submit' value='Mostrar Inventario'>
      </form>";

// Cerrar la conexión
oci_close($conn);
?>