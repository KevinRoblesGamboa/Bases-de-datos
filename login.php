<?php
session_start();
ob_start(); // Evitar problemas con header()

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $host = 'localhost';       // Cambia según tu configuración
    $port = '1521';            // Puerto por defecto de Oracle
    $service_name = 'ORCL';      // Nombre del servicio o SID de Oracle
    $username = 'PROYECTOSC504';  // Usuario de la base de datos
    $password = '1234567';
    
     // Crear la cadena de conexión
     $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$service_name)))";
     try 
     {
         $pdo = new PDO($dsn, $username, $password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
         echo "Error de conexión: " . $e->getMessage();
         exit;
     }

    
    // Obtener los datos del formulario
    $user = $_POST['usuario'];
    $password = $_POST['password'];
    $rol = '';  // Inicializamos el valor de $rol

    try {
        // Llamado al SP
        $stmt = $pdo->prepare("BEGIN OBTENER_ROL(:email, :contrasena, :rol); END;");
        
        // Vincular parámetros
        $stmt->bindParam(':email', $user, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $password, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_INPUT_OUTPUT, 50); // Usamos PDO::PARAM_INPUT_OUTPUT para el parámetro OUT

        // Ejecutar el SP
        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    if (strtolower($rol) === '')
    {
        header('Location: login.php?error=acceso_denegado&rol=' . urlencode($rol));
        exit;
    }

    // Verificar el valor de rol y redirigir según el caso
    if (strtolower($rol) === 'admin')
    {
        $_SESSION['usuario'] = $user;
        $_SESSION['rol'] = 'admin';
        header('Location: sistema_gestion_tienda.php');
        exit;
    } 
     
    try 
    {

        // Llamado al SP
        $stmt2 = $pdo->prepare("BEGIN OBTENER_ROL_CLIENTE(:email, :contrasena, :rol); END;"); // cambiar el sp ojojojojojo
        
        if (!$stmt2) 
        {
            die("Error en la preparación del SP: " . implode(", ", $pdo->errorInfo()));
        }
        // Vincular parámetros
        $stmt2->bindParam(':email', $user, PDO::PARAM_STR);
        $stmt2->bindParam(':contrasena', $password, PDO::PARAM_STR);
        $stmt2->bindParam(':rol', $rol, PDO::PARAM_STR, 50); // Usamos PDO::PARAM_INPUT_OUTPUT para el parámetro OUT
        // Ejecutar el SP
        $stmt2->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    if (strtolower($rol) === 'example')
    {
        $_SESSION['usuario'] = $user;
        $_SESSION['rol'] = 'cliente';
        header('Location: sistema_clientes.php');
        exit;
    } 


}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <h1 class="login-title">Inicio de Sesión</h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-success btn-block" value="Iniciar Sesión">
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="insertar_cliente.php" class="btn btn-secondary">Registrar</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
