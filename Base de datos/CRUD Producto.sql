function createProducto($nombre, $descripcion, $precio, $id_categoria, $id_proveedor) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO PRODUCTOS (NOMBRE, DESCRIPCION, PRECIO, ID_CATEGORIA, ID_PROVEEDOR) VALUES (:nombre, :descripcion, :precio, :id_categoria, :id_proveedor)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':id_proveedor', $id_proveedor);

        $stmt->execute();
        echo "Producto creado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getProducto($id_producto) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT NOMBRE, DESCRIPCION, PRECIO, ID_CATEGORIA, ID_PROVEEDOR FROM PRODUCTOS WHERE ID_PRODUCTO = :id_producto";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos del producto
        } else {
            return null; // No se encontró el producto
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateProducto($id_producto, $nombre, $descripcion, $precio, $id_categoria, $id_proveedor) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE PRODUCTOS SET NOMBRE = :nombre, DESCRIPCION = :descripcion, PRECIO = :precio, ID_CATEGORIA = :id_categoria, ID_PROVEEDOR = :id_proveedor WHERE ID_PRODUCTO = :id_producto";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':id_proveedor', $id_proveedor);

        $stmt->execute();
        echo "Producto actualizado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteProducto($id_producto) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM PRODUCTOS WHERE ID_PRODUCTO = :id_producto";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);

        $stmt->execute();
        echo "Producto eliminado con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

