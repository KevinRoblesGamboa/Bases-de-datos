function createCategoria($nombre_categoria, $descripcion) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO CATEGORIAS (NOMBRE_CATEGORIA, DESCRIPCION) VALUES (:nombre_categoria, :descripcion)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre_categoria', $nombre_categoria);
        $stmt->bindParam(':descripcion', $descripcion);

        $stmt->execute();
        echo "Categoría creada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getCategoria($id_categoria) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT NOMBRE_CATEGORIA, DESCRIPCION FROM CATEGORIAS WHERE ID_CATEGORIA = :id_categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result; // Retorna un array con los datos de la categoría
        } else {
            return null; // No se encontró la categoría
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function updateCategoria($id_categoria, $nombre_categoria, $descripcion) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE CATEGORIAS SET NOMBRE_CATEGORIA = :nombre_categoria, DESCRIPCION = :descripcion WHERE ID_CATEGORIA = :id_categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':nombre_categoria', $nombre_categoria);
        $stmt->bindParam(':descripcion', $descripcion);

        $stmt->execute();
        echo "Categoría actualizada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function deleteCategoria($id_categoria) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=nombre_base_de_datos", "usuario", "contraseña");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM CATEGORIAS WHERE ID_CATEGORIA = :id_categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);

        $stmt->execute();
        echo "Categoría eliminada con éxito!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
