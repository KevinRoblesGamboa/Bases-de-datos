function createOrden($id_cliente, $id_empleado, $fecha, $total) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO ORDENES (ID_CLIENTE, ID_EMPLEADO, FECHA, TOTAL) VALUES (:id_cliente, :id_empleado, :fecha, :total)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':total', $total);

        $stmt->execute();
        echo "Orden creada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getOrden($id_orden) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT ID_CLIENTE, ID_EMPLEADO, FECHA, TOTAL FROM ORDENES WHERE ID_ORDEN = :id_orden";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_orden', $id_orden);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos de la orden
        } else {
            return null; // No se encontró la orden
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateOrden($id_orden, $id_cliente, $id_empleado, $fecha, $total) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE ORDENES SET ID_CLIENTE = :id_cliente, ID_EMPLEADO = :id_empleado, FECHA = :fecha, TOTAL = :total WHERE ID_ORDEN = :id_orden";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_orden', $id_orden);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':total', $total);

        $stmt->execute();
        echo "Orden actualizada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteOrden($id_orden) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM ORDENES WHERE ID_ORDEN = :id_orden";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_orden', $id_orden);

        $stmt->execute();
        echo "Orden eliminada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
