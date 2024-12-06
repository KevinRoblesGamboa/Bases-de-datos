<?php
// backend.php
include 'conexion.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener un cliente específico por ID
            $id_cliente = $_GET['id'];
            $sql = "SELECT ID_CLIENTE, NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO FROM CLIENTES WHERE ID_CLIENTE = :id_cliente";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_cliente' => $id_cliente]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Obtener todos los clientes
            $sql = "SELECT ID_CLIENTE, NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO FROM CLIENTES";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($result);
        break;

    case 'POST':
        // Insertar un nuevo cliente
        $sql = "INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO) 
                VALUES (:nombre, :apellido, :email, :direccion, :telefono)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombre' => $input['NOMBRE'],
            'apellido' => $input['APELLIDO'],
            'email' => $input['EMAIL'],
            'direccion' => $input['DIRECCION'],
            'telefono' => $input['TELEFONO']
        ]);
        echo json_encode(['ID_CLIENTE' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        // Actualizar datos de un cliente
        $sql = "UPDATE CLIENTES 
                SET NOMBRE = :nombre, APELLIDO = :apellido, EMAIL = :email, 
                    DIRECCION = :direccion, TELEFONO = :telefono 
                WHERE ID_CLIENTE = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_cliente' => $input['ID_CLIENTE'],
            'nombre' => $input['NOMBRE'],
            'apellido' => $input['APELLIDO'],
            'email' => $input['EMAIL'],
            'direccion' => $input['DIRECCION'],
            'telefono' => $input['TELEFONO']
        ]);
        echo json_encode(['status' => 'success']);
        break;

    case 'DELETE':
        // Eliminar un cliente
        $sql = "DELETE FROM CLIENTES WHERE ID_CLIENTE = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_cliente' => $input['ID_CLIENTE']]);
        echo json_encode(['status' => 'success']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>