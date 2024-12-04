function createCarrito($id_cliente, $total, $fecha) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO CARRITO (ID_CLIENTE, TOTAL, FECHA) VALUES (:id_cliente, :total, :fecha)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':fecha', $fecha);

        $stmt->execute();
        echo "Carrito creado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getCarrito($id_carrito) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT ID_CLIENTE, TOTAL, FECHA FROM CARRITO WHERE ID_CARRITO = :id_carrito";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos del carrito
        } else {
            return null; // No se encontró el carrito
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateCarrito($id_carrito, $id_cliente, $total, $fecha) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE CARRITO SET ID_CLIENTE = :id_cliente, TOTAL = :total, FECHA = :fecha WHERE ID_CARRITO = :id_carrito";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':fecha', $fecha);

        $stmt->execute();
        echo "Carrito actualizado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteCarrito($id_carrito) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM CARRITO WHERE ID_CARRITO = :id_carrito";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);

        $stmt->execute();
        echo "Carrito eliminado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
