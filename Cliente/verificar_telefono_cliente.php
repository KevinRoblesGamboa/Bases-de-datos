<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521';
$sid = 'ORCL';
$usuario = 'c##ANDERSON';
$contraseña = '12345';

// Crear la conexión
$conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

if (!$conn) {
    $e = oci_error();
    echo "<p class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</p>";
    exit;
}

// Verificar si el número de teléfono está registrado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verificar'])) {
    $telefono = $_POST['telefono'];
    
    // Llamar a la función FN_VERIFICAR_TELEFONO
    $query = 'BEGIN :existe := FN_VERIFICAR_TELEFONO(:p_telefono); END;';
    $stid = oci_parse($conn, $query);
    
    // Enlazar los parámetros
    oci_bind_by_name($stid, ':p_telefono', $telefono, -1, SQLT_CHR); // Número de teléfono
    oci_bind_by_name($stid, ':existe', $result, 1, SQLT_INT); // Variable para recibir el resultado como un entero
    
    // Ejecutar la consulta
    if (oci_execute($stid)) {
        $message = $result ? "El número de teléfono está registrado." : "El número de teléfono no está registrado.";
        $messageClass = $result ? "success" : "error";
    } else {
        $e = oci_error($stid);
        echo "<p class='error'>Error al ejecutar la consulta: " . htmlentities($e['message']) . "</p>";
    }

    // Liberar recursos
    oci_free_statement($stid);
}

// Liberar conexión
oci_close($conn);
?>

<!-- Formulario para verificar el número de teléfono -->
<div class="container">
    <form method="POST">
        <h2 class="form-title">Verificar Número de Teléfono</h2>
        <label for="telefono">Ingrese su número de teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
        <input type="submit" name="verificar" value="Verificar">
    </form>

    <?php if (isset($message)): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Botón de redirección -->
    <a href="mostrar_cliente.php" class="redirect-button">Volver a clientes</a>
</div>

<!-- Opciones de estilos creativos -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }
    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .form-title {
        font-size: 24px;
        margin-bottom: 15px;
        color: #333;
    }
    label {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;
        color: #555;
    }
    input[type="tel"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border-color 0.3s;
    }
    input[type="tel"]:focus {
        border-color: #4CAF50;
    }
    input[type="submit"] {
        padding: 10px 15px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .message {
        margin-top: 15px;
        padding: 10px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
    }
    .success {
        background-color: green;
    }
    .error {
        background-color: red;
    }
    .redirect-button {
        display: block;
        margin-top: 15px;
        padding: 10px 15px;
        font-size: 16px;
        background-color: #008CBA;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
        text-align: center;
    }
    .redirect-button:hover {
        background-color: #005f73;
    }
</style>
