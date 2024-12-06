<?php
header("Content-Type: application/json");

// Obtener la conexión a la base de datos
$conn = include 'conexion.php';

// Determinar método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Obtener empleados o uno específico
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = oci_parse($conn, "BEGIN SP_GET_EMPLEADO(:id_empleado, :cursor); END;");
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":id_empleado", $id);
            oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
            oci_execute($stmt);
            oci_execute($cursor, OCI_DEFAULT);
            $data = [];
            while (($row = oci_fetch_assoc($cursor)) != false) {
                $data[] = $row;
            }
            echo json_encode($data[0] ?? []);
            oci_free_statement($stmt);
            oci_free_statement($cursor);
        } else {
            $stmt = oci_parse($conn, "BEGIN SP_GET_EMPLEADO(NULL, :cursor); END;");
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
            oci_execute($stmt);
            oci_execute($cursor, OCI_DEFAULT);
            $data = [];
            while (($row = oci_fetch_assoc($cursor)) != false) {
                $data[] = $row;
            }
            echo json_encode($data);
            oci_free_statement($stmt);
            oci_free_statement($cursor);
        }
        break;

    case 'POST': // Crear empleado
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = oci_parse($conn, "BEGIN SP_CREATE_EMPLEADO(:id_empleado, :nombre, :apellido, :telefono, :id_sucursal); END;");
        oci_bind_by_name($stmt, ":id_empleado", $input['ID_EMPLEADO']);
        oci_bind_by_name($stmt, ":nombre", $input['NOMBRE']);
        oci_bind_by_name($stmt, ":apellido", $input['APELLIDO']);
        oci_bind_by_name($stmt, ":telefono", $input['TELEFONO']);
        oci_bind_by_name($stmt, ":id_sucursal", $input['ID_SUCURSAL']);
        oci_execute($stmt);
        echo json_encode(["message" => "Empleado creado exitosamente"]);
        oci_free_statement($stmt);
        break;

    case 'PUT': // Actualizar empleado
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = oci_parse($conn, "BEGIN SP_UPDATE_EMPLEADO(:id_empleado, :nombre, :apellido, :telefono, :id_sucursal); END;");
        oci_bind_by_name($stmt, ":id_empleado", $input['ID_EMPLEADO']);
        oci_bind_by_name($stmt, ":nombre", $input['NOMBRE']);
        oci_bind_by_name($stmt, ":apellido", $input['APELLIDO']);
        oci_bind_by_name($stmt, ":telefono", $input['TELEFONO']);
        oci_bind_by_name($stmt, ":id_sucursal", $input['ID_SUCURSAL']);
        oci_execute($stmt);
        echo json_encode(["message" => "Empleado actualizado exitosamente"]);
        oci_free_statement($stmt);
        break;

    case 'DELETE': // Eliminar empleado
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = oci_parse($conn, "BEGIN SP_DELETE_EMPLEADO(:id_empleado); END;");
        oci_bind_by_name($stmt, ":id_empleado", $input['ID_EMPLEADO']);
        oci_execute($stmt);
        echo json_encode(["message" => "Empleado eliminado exitosamente"]);
        oci_free_statement($stmt);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

// Cerrar la conexión a la base de datos
oci_close($conn);
?>