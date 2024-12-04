function createCliente($nombre, $apellido, $email, $direccion, $telefono) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO) VALUES (:nombre, :apellido, :email, :direccion, :telefono)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);

        $stmt->execute();
        echo "Cliente creado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getCliente($id_cliente) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO FROM CLIENTES WHERE ID_CLIENTE = :id_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos del cliente
        } else {
            return null; // No se encontró el cliente
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



function updateCliente($id_cliente, $nombre, $apellido, $email, $direccion, $telefono) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE CLIENTES SET NOMBRE = :nombre, APELLIDO = :apellido, EMAIL = :email, DIRECCION = :direccion, TELEFONO = :telefono WHERE ID_CLIENTE = :id_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);

        $stmt->execute();
        echo "Cliente actualizado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteCliente($id_cliente) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM CLIENTES WHERE ID_CLIENTE = :id_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);

        $stmt->execute();
        echo "Cliente eliminado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

