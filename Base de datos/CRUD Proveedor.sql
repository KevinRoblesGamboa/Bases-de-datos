function createProveedor($nombre, $contacto, $telefono, $direccion) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO PROVEEDORES (NOMBRE, CONTACTO, TELEFONO, DIRECCION) VALUES (:nombre, :contacto, :telefono, :direccion)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);

        $stmt->execute();
        echo "Proveedor creado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getProveedor($id_proveedor) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT NOMBRE, CONTACTO, TELEFONO, DIRECCION FROM PROVEEDORES WHERE ID_PROVEEDOR = :id_proveedor";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos del proveedor
        } else {
            return null; // No se encontró el proveedor
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateProveedor($id_proveedor, $nombre, $contacto, $telefono, $direccion) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE PROVEEDORES SET NOMBRE = :nombre, CONTACTO = :contacto, TELEFONO = :telefono, DIRECCION = :direccion WHERE ID_PROVEEDOR = :id_proveedor";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);

        $stmt->execute();
        echo "Proveedor actualizado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteProveedor($id_proveedor) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM PROVEEDORES WHERE ID_PROVEEDOR = :id_proveedor";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);

        $stmt->execute();
        echo "Proveedor eliminado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

