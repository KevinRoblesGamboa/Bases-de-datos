<!DOCTYPE HTML>
<meta charset="utf8" />
<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$puerto = '1521'; // Cambia si usas un puerto diferente
$sid = 'ORCL'; // SID de la base de datos Oracle
$usuario = 'PROYECTOSC504'; // Usuario de la base de datos
$contraseña = '1234567'; // Contraseña del usuario

try
{
    // Crear la conexión
    $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

    if (!$conn) 
    {
        // Lanza una excepción si hay un error
        $e = oci_error();
        throw new Exception("Error al conectar con la base de datos: " . $e['message']);
    }

    echo "Conexión a la base de datos realizada con éxito.";

    // Agregar un mensaje para la consola del navegador
    echo "<script>console.log('Conexión exitosa a la base de datos Oracle.');</script>";
} 
catch (Exception $ex) 
{
    // Manejar errores y mostrar en la consola del navegador
    echo "<script>console.error('{$ex->getMessage()}');</script>";
    echo "<div class='error'>Error: " . htmlentities($ex->getMessage()) . "</div>";
    exit;
}
?>






