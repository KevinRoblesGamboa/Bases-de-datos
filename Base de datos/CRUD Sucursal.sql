function createSucursal($nombre, $direccion, $telefono) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO SUCURSALES (NOMBRE, DIRECCION, TELEFONO) VALUES (:nombre, :direccion, :telefono)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);

        $stmt->execute();
        echo "Sucursal creada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getSucursal($id_sucursal) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT NOMBRE, DIRECCION, TELEFONO FROM SUCURSALES WHERE ID_SUCURSAL = :id_sucursal";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_sucursal', $id_sucursal);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos de la sucursal
        } else {
            return null; // No se encontró la sucursal
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateSucursal($id_sucursal, $nombre, $direccion, $telefono) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE SUCURSALES SET NOMBRE = :nombre, DIRECCION = :direccion, TELEFONO = :telefono WHERE ID_SUCURSAL = :id_sucursal";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_sucursal', $id_sucursal);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);

        $stmt->execute();
        echo "Sucursal actualizada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteSucursal($id_sucursal) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM SUCURSALES WHERE ID_SUCURSAL = :id_sucursal";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_sucursal', $id_sucursal);

        $stmt->execute();
        echo "Sucursal eliminada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

